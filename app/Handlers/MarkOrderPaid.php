<?php

namespace Cart\Handlers;

use Cart\Events\Event;
use Cart\Handlers\Contracts\HandlerInterface;

class MarkOrderPaid implements HandlerInterface
{
    public function handle(Event $event)
    {
        $event->getOrder()->update([
            'paid' => true
        ]);
    }
}