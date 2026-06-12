<?php

namespace App\Controllers;

use App\Models\Seguimiento;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SeguimientoController
{
    // GET /seguimientos
    public function index(Request $request, Response $response): Response
    {
        $response->getBody()->write(
            Seguimiento::all()->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // GET /seguimientos/{id}
    public function show(Request $request, Response $response, array $args): Response
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

        $response->getBody()->write(
            $seguimiento->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // POST /seguimientos
    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $seguimiento = Seguimiento::create([
            'incapacidad_id'    => $data['incapacidad_id'],
            'fecha_seguimiento' => $data['fecha_seguimiento'],
            'observaciones'     => $data['observaciones'],
            'recomendaciones'   => $data['recomendaciones'] ?? null,
            'proxima_revision'  => $data['proxima_revision'] ?? null,
            'estado'            => $data['estado'] ?? 'pendiente'
        ]);

        $response->getBody()->write(
            $seguimiento->toJson()
        );

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }

    // PUT /seguimientos/{id}
    public function update(Request $request, Response $response, array $args): Response
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
            'incapacidad_id'    => $data['incapacidad_id'],
            'fecha_seguimiento' => $data['fecha_seguimiento'],
            'observaciones'     => $data['observaciones'],
            'recomendaciones'   => $data['recomendaciones'] ?? null,
            'proxima_revision'  => $data['proxima_revision'] ?? null,
            'estado'            => $data['estado']
        ]);

        $response->getBody()->write(
            $seguimiento->fresh()->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

    // DELETE /seguimientos/{id}
    public function destroy(Request $request, Response $response, array $args): Response
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

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }
}