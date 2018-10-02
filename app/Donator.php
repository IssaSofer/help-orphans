<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donator extends Model
{
    //
    protected $fillable = [
        'user_id', 'asia', 
        
        'zain', 'crad', 
    ];

    public function users()
    {
    	return $this->belongTo('App\User', 'id');
    } 
}
