<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Config/database.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

/*
Ruta principal
*/
$app->get('/', function ($request, $response) {

    $response->getBody()->write(json_encode([
        'microservicio' => 'ms-empleados',
        'estado' => 'funcionando'
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json');
});

/*
|--------------------------------------------------------------------------
| Registrar rutas del microservicio
|--------------------------------------------------------------------------
*/
(require __DIR__ . '/../app/Routes/empleadoRoutes.php')($app);

$app->run();