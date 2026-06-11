<?php

namespace Incapacidades\Middleware;

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
                'error' => 'Token requerido'
            ]));

            return $response
                ->withStatus(401)
                ->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}