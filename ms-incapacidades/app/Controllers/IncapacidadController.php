<?php

namespace Incapacidades\Controllers;

use Incapacidades\Models\Incapacidad;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class IncapacidadController
{
    public function listar(Request $request, Response $response)
    {
        $response->getBody()->write(
            Incapacidad::all()->toJson()
        );

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function obtener(Request $request, Response $response, array $args)
    {
        $incapacidad = Incapacidad::find($args['id']);

        if (!$incapacidad) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Incapacidad no encontrada'
            ]));

            return $response->withStatus(404);
        }

        $response->getBody()->write($incapacidad->toJson());

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function crear(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if (strtotime($data['fecha_fin']) < strtotime($data['fecha_inicio'])) {

            $response->getBody()->write(json_encode([
                'mensaje' => 'La fecha fin no puede ser menor que la fecha inicio'
            ]));

            return $response->withStatus(400);
        }

        $dias = floor(
            (strtotime($data['fecha_fin']) -
            strtotime($data['fecha_inicio'])) / 86400
        ) + 1;

        $duplicada = Incapacidad::where('empleado_id', $data['empleado_id'])
            ->where('fecha_inicio', $data['fecha_inicio'])
            ->where('fecha_fin', $data['fecha_fin'])
            ->exists();

        if ($duplicada) {

            $response->getBody()->write(json_encode([
                'mensaje' => 'Ya existe una incapacidad con ese rango de fechas'
            ]));

            return $response->withStatus(409);
        }

        $data['dias_incapacidad'] = $dias;

        $incapacidad = Incapacidad::create($data);

        $response->getBody()->write($incapacidad->toJson());

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }

    public function actualizar(Request $request, Response $response, array $args)
    {
        $incapacidad = Incapacidad::find($args['id']);

        if (!$incapacidad) {

            $response->getBody()->write(json_encode([
                'mensaje' => 'Incapacidad no encontrada'
            ]));

            return $response->withStatus(404);
        }

        $data = $request->getParsedBody();

        $incapacidad->update($data);

        $response->getBody()->write($incapacidad->fresh()->toJson());

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function eliminar(Request $request, Response $response, array $args)
    {
        $incapacidad = Incapacidad::find($args['id']);

        if (!$incapacidad) {

            $response->getBody()->write(json_encode([
                'mensaje' => 'Incapacidad no encontrada'
            ]));

            return $response->withStatus(404);
        }

        $incapacidad->estado = 'finalizada';
        $incapacidad->save();

        $response->getBody()->write(json_encode([
            'mensaje' => 'Incapacidad finalizada correctamente'
        ]));

        return $response;
    }

    public function buscarPorEmpleado(Request $request, Response $response, array $args)
    {
        $response->getBody()->write(
            Incapacidad::where('empleado_id', $args['id'])->get()->toJson()
        );

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorEstado(Request $request, Response $response, array $args)
    {
        $response->getBody()->write(
            Incapacidad::where('estado', $args['estado'])->get()->toJson()
        );

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorTipo(Request $request, Response $response, array $args)
    {
        $response->getBody()->write(
            Incapacidad::where('tipo', $args['tipo'])->get()->toJson()
        );

        return $response->withHeader('Content-Type', 'application/json');
    }
}