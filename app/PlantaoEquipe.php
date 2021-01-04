<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantaoEquipe extends Model
{

    protected $table = "plantao_equipe";

    protected $fillable = [
        "id",
        "start_date",
        "end_date"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

}
