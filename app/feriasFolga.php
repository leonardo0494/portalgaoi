<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class feriasFolga extends Model
{
    protected $table = "ferias_folga";

    protected $fillable = [
        "id",
        "start_date",
        "end_date",
        "tipo",
        "user_id"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
