<?php

namespace Cart\Handlers;

use Cart\Events\Event;
use Cart\Handlers\Contracts\HandlerInterface;

class EmptyBasket implements HandlerInterface
{
    public function handle(Event $event)
    {
        $event->getBasket()->clear();
    }
}