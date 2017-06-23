<?php

namespace Cart\Handlers;

use Cart\Events\Event;
use Cart\Handlers\Contracts\HandlerInterface;

class RecordSuccessfulPayment implements HandlerInterface
{
    protected $transactionId;

    function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function handle(Event $event)
    {
        $event->getOrder()->payment()->create([
            'failed' => false,
            'transaction_id' => $this->transactionId
        ]);
    }
}