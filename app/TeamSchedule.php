<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamSchedule extends Model
{
    protected $fillable = [
        'start_date', 'end_date', 'ttype', 'user_id'
    ];

    protected $primaryKey = 'rowid';

    public function user(){
        return $this->hasMany('App\User');
    }

}
