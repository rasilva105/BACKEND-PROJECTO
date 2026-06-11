<?php

use Slim\App;
use Incapacidades\Controllers\IncapacidadController;
use Incapacidades\Middleware\AuthMiddleware;

return function (App $app) {

    $app->get('/incapacidades', [IncapacidadController::class, 'listar'])
        ->add(new AuthMiddleware());

    $app->get('/incapacidades/{id}', [IncapacidadController::class, 'obtener'])
        ->add(new AuthMiddleware());

    $app->post('/incapacidades', [IncapacidadController::class, 'crear'])
        ->add(new AuthMiddleware());

    $app->put('/incapacidades/{id}', [IncapacidadController::class, 'actualizar'])
        ->add(new AuthMiddleware());

    $app->delete('/incapacidades/{id}', [IncapacidadController::class, 'eliminar'])
        ->add(new AuthMiddleware());

    $app->get('/incapacidades/empleado/{id}', [IncapacidadController::class, 'buscarPorEmpleado'])
        ->add(new AuthMiddleware());

    $app->get('/incapacidades/estado/{estado}', [IncapacidadController::class, 'buscarPorEstado'])
        ->add(new AuthMiddleware());

    $app->get('/incapacidades/tipo/{tipo}', [IncapacidadController::class, 'buscarPorTipo'])
        ->add(new AuthMiddleware());
};