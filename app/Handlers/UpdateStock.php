<?php

namespace Cart\Handlers;

use Cart\Events\Event;
use Cart\Handlers\Contracts\HandlerInterface;

class UpdateStock implements HandlerInterface
{
    public function handle(Event $event)
    {
        foreach ($event->getBasket()->all() as $product) {
            $product->decrement('stock', $product->quantity);
        }
    }
}