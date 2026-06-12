<?php

use Slim\App;
use App\Controllers\SeguimientoController;
use App\Middleware\AuthMiddleware;

return function (App $app) {

    $controller = new SeguimientoController();

    $app->get('/seguimientos', [$controller, 'index'])
        ->add(new AuthMiddleware());

    $app->get('/seguimientos/{id}', [$controller, 'show'])
        ->add(new AuthMiddleware());

    $app->post('/seguimientos', [$controller, 'store'])
        ->add(new AuthMiddleware());

    $app->put('/seguimientos/{id}', [$controller, 'update'])
        ->add(new AuthMiddleware());

    $app->delete('/seguimientos/{id}', [$controller, 'destroy'])
        ->add(new AuthMiddleware());
};