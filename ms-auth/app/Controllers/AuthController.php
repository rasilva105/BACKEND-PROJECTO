<?php

namespace App\Controllers;
use App\Models\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class AuthController
{
    
    // POST /login
    // Inicia sesión.
     
    public function login(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $usuario = $data['usuario'] ?? '';
        $contrasena = $data['contrasena'] ?? '';

        $user = Usuario::where('usuario', $usuario)->first();

        if (!$user) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'mensaje' => 'Usuario no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        if ($user->estado !== 'activo') {
            $response->getBody()->write(json_encode([
                'success' => false,
                'mensaje' => 'Usuario inactivo'
            ]));

            return $response
                ->withStatus(403)
                ->withHeader('Content-Type', 'application/json');
        }

        
         //Por ahora usamos comparación simple.
         //Luego podremos cambiarlo por password_verify().
         
        if ($user->contrasena !== $contrasena) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'mensaje' => 'Contraseña incorrecta'
            ]));

            return $response
                ->withStatus(401)
                ->withHeader('Content-Type', 'application/json');
        }

        $token = bin2hex(random_bytes(32));

        $user->token = $token;
        $user->sesion_activa = 1;
        $user->save();

        $response->getBody()->write(json_encode([
            'success' => true,
            'mensaje' => 'Login exitoso',
            'token' => $token,
            'usuario' => $user->usuario,
            'nombre' => $user->nombre
        ]));

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }


    // POST /logout
    // Cierra la sesión.
    public function logout(Request $request, Response $response): Response
    {
        $token = $request->getHeaderLine('Authorization');

        $user = Usuario::where('token', $token)->first();

        if (!$user) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'mensaje' => 'Token inválido'
            ]));

            return $response
                ->withStatus(401)
                ->withHeader('Content-Type', 'application/json');
        }

        $user->token = null;
        $user->sesion_activa = 0;
        $user->save();

        $response->getBody()->write(json_encode([
            'success' => true,
            'mensaje' => 'Sesión cerrada correctamente'
        ]));

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // GET /validate
    // Valida si un token es válido.
    public function validate(Request $request, Response $response): Response
    {
        $token = $request->getHeaderLine('Authorization');

        $user = Usuario::where('token', $token)
            ->where('sesion_activa', 1)
            ->first();

        if (!$user) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'valido' => false
            ]));

            return $response
                ->withStatus(401)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode([
            'success' => true,
            'valido' => true,
            'usuario' => $user->usuario,
            'nombre' => $user->nombre
        ]));

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // GET /usuarios
    // Lista todos los usuarios.
    public function index(Request $request, Response $response): Response
    {
        $usuarios = Usuario::all();

        $response->getBody()->write(
            $usuarios->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }
    
    // GET /usuarios/{id}
    // Obtiene un usuario por ID.

    public function show(Request $request, Response $response, array $args): Response
    {
        $usuario = Usuario::find($args['id']);

        if (!$usuario) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Usuario no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(
            $usuario->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    
    //  POST /usuarios
    //  Crea un usuario.
    
    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $usuario = Usuario::create([
            'nombre' => $data['nombre'],
            'usuario' => $data['usuario'],
            'contrasena' => $data['contrasena'],
            'estado' => 'activo',
            'sesion_activa' => 0
        ]);

        $response->getBody()->write(
            $usuario->toJson()
        );

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }


    // PUT /usuarios/{id}
    // Actualiza un usuario.

    public function update(Request $request, Response $response, array $args): Response
    {
        $usuario = Usuario::find($args['id']);

        if (!$usuario) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Usuario no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $data = $request->getParsedBody();

        $usuario->update($data);

        $response->getBody()->write(
            $usuario->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    
    // DELETE /usuarios/{id}
    // Desactiva un usuario.
     
    public function destroy(Request $request, Response $response, array $args): Response
    {
        $usuario = Usuario::find($args['id']);

        if (!$usuario) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Usuario no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $usuario->estado = 'inactivo';
        $usuario->save();

        $response->getBody()->write(json_encode([
            'mensaje' => 'Usuario desactivado'
        ]));

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }
}