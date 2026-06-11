<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar Composer
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configurar Eloquent
require __DIR__ . '/../app/Config/database.php';

use Slim\Factory\AppFactory;


// Crear la aplicación Slim

$app = AppFactory::create();

// Middleware para leer JSON

$app->addBodyParsingMiddleware();

// Middleware de manejo de errores

$app->addErrorMiddleware(true, true, true);


// Esta ruta sirve para verificar que el microservicio está vivo.
$app->get('/', function ($request, $response) {

    $response->getBody()->write(json_encode([
        'microservicio' => 'ms-auth',
        'estado' => 'funcionando'
    ]));

    return $response->withHeader(
        'Content-Type',
        'application/json'
    );
});

// Cargar rutas de autenticación

$routes = require __DIR__ . '/../app/Routes/authRoutes.php';

$routes($app);

$app->run();