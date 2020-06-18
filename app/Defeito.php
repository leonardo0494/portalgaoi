<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defeito extends Model
{

    protected $fillable=[
        'prj_ent',
        'def',
        'reports_id'
    ];

    public function reports(){
        return $this->belongsTo(Reports::class, 'reports_id', 'id');
    }

}
