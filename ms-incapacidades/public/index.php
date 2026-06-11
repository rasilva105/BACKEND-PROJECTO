<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Dotenv\Dotenv;

require __DIR__ . '/../../vendor/autoload.php';

/*
 Cargar variables de entorno
*/
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

/*

 Configurar base de datos
*/
require __DIR__ . '/../app/Config/database.php';

/*
 Crear aplicación Slim
*/
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

/*
 Ruta principal
*/
$app->get('/', function ($request, $response) {

    $response->getBody()->write(json_encode([
        "microservicio" => "ms-incapacidades",
        "estado" => "funcionando"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json');
});

/*
 Cargar rutas
*/
(require __DIR__ . '/../app/Routes/incapacidadRoutes.php')($app);

/* Ejecutar aplicación */
$app->run();