<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityOnline extends Model
{
    protected $fillable = [
        'recurso',
        'hora_inicio',
        'hora_termino'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
