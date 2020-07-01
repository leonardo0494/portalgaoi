<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ARS extends Model
{

    protected $table = "arss";

    protected $fillable=[
        'ars',
        'categorie',
        'pendencia',
        'reports_id'
    ];

    public function reports(){
        return $this->belongsTo(Reports::class, 'reports_id', 'id');
    }
}
