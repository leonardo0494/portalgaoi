<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'rowid',
        'titulo',
        'descricao',
        'user_id',
        'status'
    ];

    protected $primaryKey = 'rowid';

    public function users(){
        return $this->hasOne('App\User', 'rowid', 'rowid');
    }

}