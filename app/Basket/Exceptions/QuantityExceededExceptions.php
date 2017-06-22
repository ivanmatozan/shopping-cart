<?php

namespace Cart\Basket\Exceptions;

class QuantityExceededExceptions extends \Exception
{
    protected $message = 'You hve added maximum stock for this item';
}