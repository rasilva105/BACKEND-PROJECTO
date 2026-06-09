<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    public function test(
        Request $request,
        Response $response
    ): Response
    {
        $response->getBody()->write(
            json_encode([
                'mensaje' => 'ms-auth funcionando'
            ])
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }
}