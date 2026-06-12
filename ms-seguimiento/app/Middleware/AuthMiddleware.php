<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class AuthMiddleware
{
    public function __invoke(
        Request $request,
        Handler $handler
    ): Response {

        $token = $request->getHeaderLine('Authorization');

        if (empty($token)) {
            $response = new \Slim\Psr7\Response();

            $response->getBody()->write(json_encode([
                'success' => false,
                'mensaje' => 'Token no proporcionado'
            ]));

            return $response
                ->withStatus(401)
                ->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}