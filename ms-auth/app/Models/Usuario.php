<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'usuario',
        'contrasena',
        'token',
        'sesion_activa',
        'estado'
    ];

    public $timestamps = true;
}