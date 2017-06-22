<?php

namespace Cart\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class OldInputMiddleware
{
    protected $view;

    function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        if (isset($_SESSION['old'])) {
            $this->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
            unset($_SESSION['old']);
        }

        $_SESSION['old'] = $request->getParams();

        $response = $next($request, $response);

        return $response;
    }
}