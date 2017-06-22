<?php

namespace Cart\Basket;

use Cart\Basket\Exceptions\QuantityExceededExceptions;
use Cart\Support\Storage\Contracts\StorageInterface;
use Cart\Models\Product;

class Basket
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var Product
     */
    protected $product;

    public function __construct(StorageInterface $storage, Product $product)
    {
        $this->storage = $storage;
        $this->product = $product;
    }

    /**
     * Add Product to Basket
     *
     * @param Product $product
     * @param int $quantity
     */
    public function add(Product $product, int $quantity)
    {
        if ($this->has($product)) {
            $quantity = $this->get($product)['quantity'] + $quantity;
        }

        $this->update($product, $quantity);
    }

    /**
     * Add or update Product in Basket
     *
     * @param Product $product
     * @param int $quantity
     * @throws QuantityExceededExceptions
     */
    public function update(Product $product, int $quantity)
    {
        if (!$product->hasStock($quantity)) {
            throw new QuantityExceededExceptions();
        }

        if ($quantity == 0) {
            $this->remove($product);
            return;
        }

        $this->storage->set($product->id, [
            'product_id' => (int)$product->id,
            'quantity' => (int)$quantity
        ]);
    }

    /**
     * Remove Product from Basket
     *
     * @param Product $product
     */
    public function remove(Product $product)
    {
        $this->storage->remove($product->id);
    }

    /**
     * Get Product from Basket
     *
     * @param Product $product
     * @return mixed
     */
    public function get(Product $product)
    {
        return $this->storage->get($product->id);
    }

    /**
     * Check if Product exists in Basket
     *
     * @param Product $product
     * @return bool
     */
    public function has(Product $product): bool
    {
        return $this->storage->exists($product->id);
    }

    /**
     * Clear Basket
     */
    public function clear()
    {
        $this->storage->clear();
    }

    /**
     * Get all Products from Basket
     *
     * @return array
     */
    public function all(): array
    {
        $ids = [];
        $items = [];

        foreach ($this->storage->all() as $product) {
            $ids[] = $product['product_id'];
        }

        $products = $this->product->find($ids);

        foreach ($products as $product) {
            $product->quantity = $this->get($product)['quantity'];
            $items[] = $product;
        }

        return $items;
    }

    /**
     * Count number of Products in Basket
     *
     * @return int
     */
    public function itemCount(): int
    {
        return count($this->storage);
    }

    /**
     * Calculate total only with products in stock
     *
     * @return float
     */
    public function subTotal(): float
    {
        $total = 0;

        foreach ($this->all() as $item) {
            if ($item->outOfStock()) {
                continue;
            }

            $total += $item->price * $item->quantity;
        }

        return $total;
    }

    /**
     * Refresh basket item quantity
     */
    public function refresh()
    {
        foreach ($this->all() as $item) {
            if (!$item->hasStock($item->quantity)) {
                // Update to max available for this item
                $this->update($item, $item->stock);
            } elseif ($item->hasStock(1) && $item->quantity === 0) {
                $this->update($item, 1);
            }
        }
    }
}