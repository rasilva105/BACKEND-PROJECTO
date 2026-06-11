<?php

use Slim\App;
use Empleados\Controllers\EmpleadoController;
use Empleados\Middleware\AuthMiddleware;

return function (App $app) {

    $app->get('/empleados', [EmpleadoController::class, 'listar'])
        ->add(new AuthMiddleware());

    $app->get('/empleados/{id}', [EmpleadoController::class, 'obtener'])
        ->add(new AuthMiddleware());

    $app->post('/empleados', [EmpleadoController::class, 'crear'])
        ->add(new AuthMiddleware());

    $app->put('/empleados/{id}', [EmpleadoController::class, 'actualizar'])
        ->add(new AuthMiddleware());

    $app->delete('/empleados/{id}', [EmpleadoController::class, 'eliminar'])
        ->add(new AuthMiddleware());
};