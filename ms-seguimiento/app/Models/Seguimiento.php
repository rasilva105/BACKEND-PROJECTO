<?php

namespace Seguimiento\Models;

use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    protected $table = 'seguimientos';

    protected $fillable = [
        'incapacidad_id',
        'fecha_seguimiento',
        'observaciones',
        'recomendaciones',
        'proxima_revision',
        'estado'
    ];

    public $timestamps = true;
}