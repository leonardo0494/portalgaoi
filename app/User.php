<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'login', 'password', 'period', 'level_id', 'profile_image', 'work_phone', 'personal_phone', 'login_oi', 'login_remedy'
    ];

    protected $primaryKey = 'rowid';

    public function level()
    {
        return $this->belongsTo('App\Level', 'level_id');
    }

    public function activity()
    {
        return $this->belongsToMany('App\Acitivity');
    }

    public function plantoes()
    {
        return $this->hasMany("App\PlantaoEquipe", "user_id", "rowid");
    }

    public function notices()
    {
        return $this->belongsTo('App\Notice', 'rowid');
    }

}
