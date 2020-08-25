<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantaoEquipe extends Model
{

    protected $table = "plantao_equipe";

    protected $fillable = [
        "id",
        "dia_plantao",
        "user_id"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

}
