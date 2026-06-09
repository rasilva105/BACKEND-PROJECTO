<?php

use Slim\App;
use App\Controllers\AuthController;

return function(App $app)
{
    $controller = new AuthController();

    $app->get('/test', [$controller, 'test']);
};