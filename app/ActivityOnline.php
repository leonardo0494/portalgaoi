<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityOnline extends Model
{
    protected $fillable = [
        'recurso',
        'data_inicio'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
