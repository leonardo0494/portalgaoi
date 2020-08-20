<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantaoEquipe extends Model
{
    protected $fillable = [
        "id",
        "dia_plantao",
        "user_id"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function plantao_usuarios()
    {
        return $this->hasMany(PlantaoEquipeUser::class, "plantao_equipe_id", "id");
    }


}
