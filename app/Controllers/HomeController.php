<?php

namespace Cart\Controllers;

use Cart\Models\Product;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class HomeController
{
    public function index(Request $request, Response $response, Twig $view, Product $product)
    {
        $products = $product::all();

        return $view->render($response, 'home.twig', compact('products'));
    }
}