<?php

namespace Empleados\Controllers;

use Empleados\Models\Empleado;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EmpleadoController
{
    public function listar(Request $request, Response $response)
    {
        $response->getBody()->write(
            Empleado::all()->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    public function obtener(Request $request, Response $response, array $args)
    {
        $empleado = Empleado::find($args['id']);

        if (!$empleado) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Empleado no encontrado'
            ]));

            return $response->withStatus(404);
        }

        $response->getBody()->write($empleado->toJson());

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    public function crear(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $empleado = Empleado::create($data);

        $response->getBody()->write(
            $empleado->toJson()
        );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function actualizar(Request $request, Response $response, array $args)
    {
        $empleado = Empleado::find($args['id']);

        if (!$empleado) {
            return $response->withStatus(404);
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

    public function eliminar(Request $request, Response $response, array $args)
    {
        $empleado = Empleado::find($args['id']);

        if (!$empleado) {
            return $response->withStatus(404);
        }

        $empleado->delete();

        $response->getBody()->write(json_encode([
            'mensaje' => 'Empleado eliminado'
        ]));

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }
}