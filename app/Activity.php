<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'ars_number', 'ttype', 'user_id'
    ];

    protected $primaryKey = 'rowid';

    public function user(){
        return $this->hasOne('App\User');
    }

}
