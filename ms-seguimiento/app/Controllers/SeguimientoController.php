<?php

namespace Seguimiento\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Seguimiento\Models\Seguimiento;

class SeguimientoController
{
    // Obtener todos
    public function index(Request $request, Response $response)
    {
        $seguimientos = Seguimiento::all();

        $response->getBody()->write(json_encode($seguimientos));

        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    // Obtener por ID
    public function show(Request $request, Response $response, array $args)
    {
        $seguimiento = Seguimiento::find($args['id']);

        if (!$seguimiento) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Seguimiento no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($seguimiento));

        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    // Registrar
    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $seguimiento = Seguimiento::create([
            'incapacidad_id'   => $data['incapacidad_id'],
            'fecha_seguimiento'=> $data['fecha_seguimiento'],
            'observaciones'    => $data['observaciones'],
            'recomendaciones'  => $data['recomendaciones'] ?? null,
            'proxima_revision' => $data['proxima_revision'] ?? null,
            'estado'           => $data['estado']
        ]);

        $response->getBody()->write(json_encode([
            'mensaje' => 'Seguimiento registrado correctamente',
            'data' => $seguimiento
        ]));

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }

    // Actualizar
    public function update(Request $request, Response $response, array $args)
    {
        $seguimiento = Seguimiento::find($args['id']);

        if (!$seguimiento) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Seguimiento no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $data = $request->getParsedBody();

        $seguimiento->update([
            'fecha_seguimiento' => $data['fecha_seguimiento'] ?? $seguimiento->fecha_seguimiento,
            'observaciones'     => $data['observaciones'] ?? $seguimiento->observaciones,
            'recomendaciones'   => $data['recomendaciones'] ?? $seguimiento->recomendaciones,
            'proxima_revision'  => $data['proxima_revision'] ?? $seguimiento->proxima_revision,
            'estado'            => $data['estado'] ?? $seguimiento->estado
        ]);

        $response->getBody()->write(json_encode([
            'mensaje' => 'Seguimiento actualizado correctamente',
            'data' => $seguimiento
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    // Eliminar
    public function destroy(Request $request, Response $response, array $args)
    {
        $seguimiento = Seguimiento::find($args['id']);

        if (!$seguimiento) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Seguimiento no encontrado'
            ]));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $seguimiento->delete();

        $response->getBody()->write(json_encode([
            'mensaje' => 'Seguimiento eliminado correctamente'
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}