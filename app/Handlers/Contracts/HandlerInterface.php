<?php

namespace Cart\Handlers\Contracts;

use Cart\Events\Event;

interface HandlerInterface
{
    public function handle(Event $event);
}