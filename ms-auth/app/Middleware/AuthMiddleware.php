<?php

namespace App\Middleware;
use App\Models\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class AuthMiddleware
{
    /**
     * Middleware de autenticación.
     *
     * Verifica que el token enviado en el header
     * Authorization exista y corresponda a una
     * sesión activa.
     */
    public function __invoke(
        Request $request,
        Handler $handler
    ): Response {

        // Obtener token
  
        $token = $request->getHeaderLine('Authorization');

        // Si no envían token
   
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

        // Buscar usuario con sesión activa
        $usuario = Usuario::where('token', $token)
            ->where('sesion_activa', 1)
            ->where('estado', 'activo')
            ->first();

        // Token inválido
        
        if (!$usuario) {

            $response = new \Slim\Psr7\Response();

            $response->getBody()->write(json_encode([
                'success' => false,
                'mensaje' => 'Token inválido o expirado'
            ]));

            return $response
                ->withStatus(401)
                ->withHeader('Content-Type', 'application/json');
        }

        // Guardar usuario autenticado
        
        $request = $request->withAttribute(
            'usuario_autenticado',
            $usuario
        );

        // Continuar con la petición

        return $handler->handle($request);
    }
}