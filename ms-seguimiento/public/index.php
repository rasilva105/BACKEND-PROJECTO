<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(
    dirname(__DIR__)
);

$dotenv->load();

require __DIR__ . '/../app/Config/database.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {

    $response->getBody()->write(json_encode([
        'microservicio' => 'ms-seguimiento',
        'estado' => 'funcionando'
    ]));

    return $response->withHeader(
        'Content-Type',
        'application/json'
    );
});

$routes = require __DIR__ . '/../app/Routes/seguimientoRoutes.php';

$routes($app);

$app->run();