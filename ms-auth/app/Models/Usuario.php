<?php

namespace Auth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Usuario
 *
 * Representa la tabla usuarios de la base de datos bd_auth.
 */
class Usuario extends Model
{
    /**
     * Nombre de la tabla asociada.
     */
    protected $table = 'usuarios';

    /**
     * Campos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombre',
        'usuario',
        'contrasena',
        'token',
        'sesion_activa',
        'estado'
    ];

    /**
     * Indica que la tabla usa created_at y updated_at.
     */
    public $timestamps = true;
}