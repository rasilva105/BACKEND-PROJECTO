<?php

namespace Seguimiento\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response as SlimResponse;

class AuthMiddleware
{
    public function __invoke(Request $request, Handler $handler): Response
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader) {
            $response = new SlimResponse();

            $response->getBody()->write(json_encode([
                'mensaje' => 'Token requerido'
            ]));

            return $response
                ->withStatus(401)
                ->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}