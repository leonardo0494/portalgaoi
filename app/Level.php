<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    protected $primaryKey = 'rowid';

    public function user(){
        return $this->hasMany('App\User', 'level_id');
    }

}
