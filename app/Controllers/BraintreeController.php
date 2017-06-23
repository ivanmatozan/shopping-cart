<?php

namespace Cart\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BraintreeController
{
    public function token(Response $response)
    {
        return $response->withJson([
            'token' => \Braintree_ClientToken::generate()
        ]);
    }
}