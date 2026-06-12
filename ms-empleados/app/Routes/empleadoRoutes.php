<?php

use Slim\App;
use App\Controllers\EmpleadoController;
use App\Middleware\AuthMiddleware;

return function (App $app) {

    $controller = new EmpleadoController();

    $app->get('/empleados', [$controller, 'index'])
        ->add(new AuthMiddleware());

    $app->get('/empleados/{id}', [$controller, 'show'])
        ->add(new AuthMiddleware());

    $app->post('/empleados', [$controller, 'crear'])
        ->add(new AuthMiddleware());

    $app->put('/empleados/{id}', [$controller, 'actualizar'])
        ->add(new AuthMiddleware());

    $app->delete('/empleados/{id}', [$controller, 'eliminar'])
        ->add(new AuthMiddleware());
};