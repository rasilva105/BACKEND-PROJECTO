<?php

namespace App\Controllers;

use App\Models\Incapacidad;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class IncapacidadController
{
    // GET /incapacidades
    public function index(Request $request, Response $response): Response
    {
        $incapacidades = Incapacidad::all();

        $response->getBody()->write(
            $incapacidades->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // GET /incapacidades/{id}
    public function show(Request $request, Response $response, array $args): Response
    {
        $incapacidad = Incapacidad::find($args['id']);

        if (!$incapacidad) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Incapacidad no encontrada'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(
            $incapacidad->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // POST /incapacidades
    public function crear(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $incapacidad = Incapacidad::create([
            'empleado_id' => $data['empleado_id'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
            'tipo' => $data['tipo'],
            'diagnostico_general' => $data['diagnostico_general'],
            'entidad_medica' => $data['entidad_medica'],
            'observaciones' => $data['observaciones'],
            'estado' => $data['estado'] ?? 'activa'
        ]);

        $response->getBody()->write(
            $incapacidad->toJson()
        );

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }

    // PUT /incapacidades/{id}
    public function actualizar(Request $request, Response $response, array $args): Response
    {
        $incapacidad = Incapacidad::find($args['id']);

        if (!$incapacidad) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Incapacidad no encontrada'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $incapacidad->update(
            $request->getParsedBody()
        );

        $response->getBody()->write(
            $incapacidad->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // DELETE /incapacidades/{id}
    public function eliminar(Request $request, Response $response, array $args): Response
    {
        $incapacidad = Incapacidad::find($args['id']);

        if (!$incapacidad) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Incapacidad no encontrada'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        // Eliminación lógica
        $incapacidad->estado = 'finalizada';
        $incapacidad->save();

        $response->getBody()->write(json_encode([
            'mensaje' => 'Incapacidad finalizada correctamente'
        ]));

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // GET /incapacidades/empleado/{id}
    public function buscarPorEmpleado(Request $request, Response $response, array $args): Response
    {
        $incapacidades = Incapacidad::where(
            'empleado_id',
            $args['id']
        )->get();

        $response->getBody()->write(
            $incapacidades->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // GET /incapacidades/estado/{estado}
    public function buscarPorEstado(Request $request, Response $response, array $args): Response
    {
        $incapacidades = Incapacidad::where(
            'estado',
            $args['estado']
        )->get();

        $response->getBody()->write(
            $incapacidades->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // GET /incapacidades/tipo/{tipo}
    public function buscarPorTipo(Request $request, Response $response, array $args): Response
    {
        $incapacidades = Incapacidad::where(
            'tipo',
            urldecode($args['tipo'])
        )->get();

        $response->getBody()->write(
            $incapacidades->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }
}