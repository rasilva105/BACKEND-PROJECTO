<?php

namespace Empleados\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware
{
    public function __invoke(
        Request $request,
        RequestHandlerInterface $handler
    ): Response {

        $token = $request->getHeaderLine('Authorization');

        if (empty($token)) {

            $response = new \Slim\Psr7\Response();

            $response->getBody()->write(json_encode([
                'mensaje' => 'Token requerido'
            ]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }

        return $handler->handle($request);
    }
}