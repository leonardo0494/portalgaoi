<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantaoEquipeUser extends Model
{

    protected $fillable = [
        'user_id',
        'plantao_equipe_id'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

}
