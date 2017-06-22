<?php

namespace Cart\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function hasLowStock(): bool
    {
        if ($this->outOfStock()) {
            return false;
        }

        return $this->stock <= 5;
    }

    public function outOfStock(): bool
    {
        return $this->stock === 0;
    }

    public function inStock(): bool
    {
        return $this->stock >= 1;
    }

    public function hasStock(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }
}