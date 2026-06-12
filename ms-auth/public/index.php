<?php

// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Responder solicitudes preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar Composer
require __DIR__ . '/../vendor/autoload.php';

// Configurar Eloquent
require __DIR__ . '/../app/Config/database.php';

use Slim\Factory\AppFactory;

// Crear la aplicación Slim
$app = AppFactory::create();

// Middleware para leer JSON
$app->addBodyParsingMiddleware();

// Middleware de manejo de errores
$app->addErrorMiddleware(true, true, true);

// Ruta para verificar que el microservicio está vivo
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

// Cargar rutas
$routes = require __DIR__ . '/../app/Routes/authRoutes.php';

$routes($app);

// Ejecutar la aplicación
$app->run();