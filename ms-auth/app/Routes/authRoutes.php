<?php

use Slim\App;
use App\Controllers\AuthController;

return function (App $app) {

    $controller = new AuthController();

    // AUTENTICACIÓN

    // Iniciar sesión
    $app->post('/login', [$controller, 'login']);

    // Cerrar sesión
    $app->post('/logout', [$controller, 'logout']);

    // Validar token
    $app->get('/validate', [$controller, 'validate']);

    // GESTIÓN DE USUARIOS

    // Obtener todos los usuarios
    $app->get('/usuarios', [$controller, 'index']);

    // Obtener usuario por ID
    $app->get('/usuarios/{id}', [$controller, 'show']);

    // Crear usuario
    $app->post('/usuarios', [$controller, 'store']);

    // Actualizar usuario
    $app->put('/usuarios/{id}', [$controller, 'update']);

    // Desactivar usuario
    $app->delete('/usuarios/{id}', [$controller, 'destroy']);
};