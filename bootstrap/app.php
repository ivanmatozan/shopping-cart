<?php

use Cart\App;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Views\Twig;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new App();

$container = $app->getContainer();

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'cart',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('sg9pzbjk9s3yg82d');
Braintree_Configuration::publicKey('6cyq6tsc7zbb5cjj');
Braintree_Configuration::privateKey('cc911ff42ee3b31e8be05065958d7b0e');

require __DIR__ . '/../app/routes.php';

$app->add(new \Cart\Middleware\ValidationErrorsMiddleware($container->get(Twig::class)));
$app->add(new \Cart\Middleware\OldInputMiddleware($container->get(Twig::class)));