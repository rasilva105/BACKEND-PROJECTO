<?php

use Slim\App;
use App\Controllers\IncapacidadController;
use App\Middleware\AuthMiddleware;

return function (App $app) {

    $controller = new IncapacidadController();

    $app->get('/incapacidades', [$controller, 'index'])
        ->add(new AuthMiddleware());

    $app->get('/incapacidades/{id}', [$controller, 'show'])
        ->add(new AuthMiddleware());

    $app->post('/incapacidades', [$controller, 'crear'])
        ->add(new AuthMiddleware());

    $app->put('/incapacidades/{id}', [$controller, 'actualizar'])
        ->add(new AuthMiddleware());

    $app->delete('/incapacidades/{id}', [$controller, 'eliminar'])
        ->add(new AuthMiddleware());

    $app->get('/incapacidades/empleado/{id}', [$controller, 'buscarPorEmpleado'])
        ->add(new AuthMiddleware());

    $app->get('/incapacidades/estado/{estado}', [$controller, 'buscarPorEstado'])
        ->add(new AuthMiddleware());

    $app->get('/incapacidades/tipo/{tipo}', [$controller, 'buscarPorTipo'])
        ->add(new AuthMiddleware());
};