<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $fillable = [
        'tipo',
        'prj_ent',
        'ars',
        'def',
        'pendencia',
        'sistema',
        'descricao',
        'inicio_atendimento',
        'final_atendimento',
        'user_id'
    ];

}
