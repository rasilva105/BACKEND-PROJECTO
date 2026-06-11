<?php

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../app/Config/database.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$routes = require __DIR__ . '/../app/Routes/seguimientoRoutes.php';
$routes($app);

$app->get('/', function ($request, $response) {

    $response->getBody()->write(json_encode([
        "mensaje" => "ms-seguimiento funcionando"
    ]));

    return $response->withHeader(
        'Content-Type',
        'application/json'
    );
});

$app->run();