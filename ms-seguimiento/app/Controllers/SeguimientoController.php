<?php

namespace App\Controllers;

use App\Models\Seguimiento;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SeguimientoController
{
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

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $seguimiento = Seguimiento::create([
            'incapacidad_id'     => $data['incapacidad_id'],
            'fecha_seguimiento'  => $data['fecha_seguimiento'],
            'observaciones'      => $data['observaciones'],
            'recomendaciones'    => $data['recomendaciones'],
            'proxima_revision'   => $data['proxima_revision'],
            'estado'             => $data['estado'] ?? 'activo'
        ]);

        $response->getBody()->write(
            $seguimiento->toJson()
        );

        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }

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

        $seguimiento->update(
            $request->getParsedBody()
        );

        $response->getBody()->write(
            $seguimiento->toJson()
        );

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }

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

        $seguimiento->estado = 'inactivo';
        $seguimiento->save();

        $response->getBody()->write(json_encode([
            'mensaje' => 'Seguimiento desactivado'
        ]));

        return $response->withHeader(
            'Content-Type',
            'application/json'
        );
    }
}