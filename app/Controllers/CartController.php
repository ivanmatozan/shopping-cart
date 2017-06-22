<?php

namespace Cart\Controllers;

use Cart\Basket\Basket;
use Cart\Basket\Exceptions\QuantityExceededExceptions;
use Cart\Models\Product;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Router;
use Slim\Views\Twig;

class CartController
{
    protected $basket;
    protected $product;

    public function __construct(Basket $basket, Product $product)
    {
        $this->basket = $basket;
        $this->product = $product;
    }

    public function index(Request $request, Response $response, Twig $view)
    {
        $this->basket->refresh();

        $view->render($response, 'cart/index.twig');
    }

    public function add(string $slug, int $quantity, Request $request, Response $response, Router $router)
    {
        $product = $this->product->where('slug', $slug)->first();

        if (!$product) {
            return $response->withRedirect($router->pathFor('home'));
        }

        try {
            $this->basket->add($product, $quantity);
        } catch (QuantityExceededExceptions $e) {

        }

        return $response->withRedirect($router->pathFor('cart.index'));
    }

    public function update(string $slug, Request $request, Response $response, Router $router)
    {
        $product = $this->product->where('slug', $slug)->first();

        if (!$product) {
            return $response->withRedirect($router->pathFor('home'));
        }

        try {
            $this->basket->update($product, $request->getParam('quantity'));
        } catch (QuantityExceededExceptions $e) {

        }

        return $response->withRedirect($router->pathFor('cart.index'));
    }
}