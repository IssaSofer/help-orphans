<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Savepost extends Model
{
    //
    protected $fillable = [
        'user_id', 'post_id',
    ];

    public function user()
    {
        return $this->belongTo('App\User', 'id');
    }

    public function post()
    {
        return $this->belongTo('App\Posts', 'id');
    }
}
