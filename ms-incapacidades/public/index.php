<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require __DIR__ . '/../app/Config/database.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {

    $response->getBody()->write(json_encode([
        'microservicio' => 'ms-incapacidades',
        'estado' => 'funcionando'
    ]));

    return $response->withHeader(
        'Content-Type',
        'application/json'
    );
});

$routes = require __DIR__ . '/../app/Routes/incapacidadRoutes.php';

$routes($app);

$app->run();