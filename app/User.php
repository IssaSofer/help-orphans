<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens , Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 

        'password', 'kind',

        'region', 'asia', 
        
        'zain', 'crad',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function posts()
    {
        return $this->hasMany('App\Posts', 'kind_id');
    }

    public function savepost()
    {
        return $this->hasMany('App\Savepost', 'user_id');
    }

    public function chat1()
    {
        return $this->hasMany('App\Chat', 'user_1');
    }

    public function chat2()
    {
        return $this->hasMany('App\Chat', 'user_2');
    }
}
