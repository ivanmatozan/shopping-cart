<?php

namespace Cart\Events;

use Cart\Basket\Basket;
use Cart\Models\Order;

class OrderWasCreated extends Event
{
    protected $order;
    protected $basket;

    public function __construct(Order $order, Basket $basket)
    {
        $this->order = $order;
        $this->basket = $basket;
    }

    /**
     * @return Basket
     */
    public function getBasket(): Basket
    {
        return $this->basket;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }
}