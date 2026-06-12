<?php

namespace App\Controllers;

use App\Models\Empleado;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EmpleadoController
{
    public function index(Request $request, Response $response): Response
    {
        $empleados = Empleado::all();

        $response->getBody()->write(
            $empleados->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $empleado = Empleado::find($args['id']);

        if (!$empleado) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Empleado no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(
            $empleado->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    public function crear(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $empleado = Empleado::create([
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'documento' => $data['documento'],
            'correo' => $data['correo'],
            'telefono' => $data['telefono'],
            'cargo' => $data['cargo'],
            'area' => $data['area'],
            'fecha_ingreso' => $data['fecha_ingreso'],
            'estado' => $data['estado'] ?? 'activo'
        ]);

        $response->getBody()->write(
            $empleado->toJson()
        );

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }

    public function actualizar(Request $request, Response $response, array $args): Response
    {
        $empleado = Empleado::find($args['id']);

        if (!$empleado) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Empleado no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $empleado->update(
            $request->getParsedBody()
        );

        $response->getBody()->write(
            $empleado->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    public function eliminar(Request $request, Response $response, array $args): Response
    {
        $empleado = Empleado::find($args['id']);

        if (!$empleado) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Empleado no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        /*
         * Cambio importante:
         * NO elimina físicamente el registro.
         */

        $empleado->estado = 'inactivo';
        $empleado->save();

        $response->getBody()->write(json_encode([
            'mensaje' => 'Empleado desactivado correctamente'
        ]));

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }
}