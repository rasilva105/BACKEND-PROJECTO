<?php

use Slim\App;
use Seguimiento\Controllers\SeguimientoController;
use Seguimiento\Middleware\AuthMiddleware;

return function (App $app) {

    $app->get('/seguimientos', SeguimientoController::class . ':index')
        ->add(new AuthMiddleware());

    $app->get('/seguimientos/{id}', SeguimientoController::class . ':show')
        ->add(new AuthMiddleware());

    $app->post('/seguimientos', SeguimientoController::class . ':store')
        ->add(new AuthMiddleware());

    $app->put('/seguimientos/{id}', SeguimientoController::class . ':update')
        ->add(new AuthMiddleware());

    $app->delete('/seguimientos/{id}', SeguimientoController::class . ':destroy')
        ->add(new AuthMiddleware());
};