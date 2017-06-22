<?php

use Interop\Container\ContainerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Interfaces\RouterInterface as Router;
use Cart\Models\Product;

return [
    Router::class => function (ContainerInterface $c) {
        return $c->get('router');
    },
    Twig::class => function (ContainerInterface $c) {
        $twig = new Twig(__DIR__ . '/../resources/views', [
            'cache' => false
        ]);

        $twig->addExtension(new TwigExtension(
            $c->get('router'),
            $c->get('request')->getUri()
        ));

        return $twig;
    },
    Product::class => function (ContainerInterface $c) {
        return new Product();
    }
];