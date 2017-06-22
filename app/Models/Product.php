<?php

namespace Cart\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $quantity = null;

    /**
     * Check if Product low on stock (5 or less)
     *
     * @return bool
     */
    public function hasLowStock(): bool
    {
        if ($this->outOfStock()) {
            return false;
        }

        return $this->stock <= 5;
    }

    /**
     * Check if Product is out of stock
     *
     * @return bool
     */
    public function outOfStock(): bool
    {
        return $this->stock === 0;
    }

    /**
     * Check if Product is in stock
     *
     * @return bool
     */
    public function inStock(): bool
    {
        return $this->stock >= 1;
    }

    /**
     * Check if wanted quantity of Product is in stock
     *
     * @param int $quantity
     * @return bool
     */
    public function hasStock(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }

    public function order()
    {
        return $this->belongsToMany(Order::class, 'orders_products')->withPivot('quantity');
    }
}