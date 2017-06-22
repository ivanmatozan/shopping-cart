<?php

use Interop\Container\ContainerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Interfaces\RouterInterface as Router;
use Cart\Models\Product;
use Cart\Models\Customer;
use Cart\Models\Address;
use Cart\Models\Order;
use Cart\Support\Storage\Contracts\StorageInterface;
use Cart\Support\Storage\SessionStorage;
use Cart\Basket\Basket;
use Cart\Validation\Contracts\ValidatorInterface;
use Cart\Validation\Validator;

return [
    Router::class => function (ContainerInterface $c) {
        return $c->get('router');
    },
    ValidatorInterface::class => function (ContainerInterface $c) {
        return new Validator();
    },
    StorageInterface::class => function (ContainerInterface $c) {
        return new SessionStorage('cart');
    },
    Twig::class => function (ContainerInterface $c) {
        $twig = new Twig(__DIR__ . '/../resources/views', [
            'cache' => false
        ]);

        $twig->addExtension(new TwigExtension(
            $c->get('router'),
            $c->get('request')->getUri()
        ));

        $twig->getEnvironment()->addGlobal('basket', $c->get(Basket::class));

        return $twig;
    },
    Product::class => function (ContainerInterface $c) {
        return new Product();
    },
    Customer::class => function (ContainerInterface $c) {
        return new Customer();
    },
    Order::class => function (ContainerInterface $c) {
        return new Order();
    },
    Address::class => function (ContainerInterface $c) {
        return new Address();
    },
    Basket::class => function (ContainerInterface $c) {
        return new Basket(
            $c->get(SessionStorage::class),
            $c->get(Product::class)
        );
    }
];