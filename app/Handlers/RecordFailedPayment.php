<?php

namespace Cart\Handlers;

use Cart\Events\Event;
use Cart\Handlers\Contracts\HandlerInterface;

class RecordFailedPayment implements HandlerInterface
{
    public function handle(Event $event)
    {
        $event->getOrder()->payment()->create([
            'failed' => true,
            'transaction_id' => null
        ]);
    }
}