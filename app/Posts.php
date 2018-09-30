<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //
    protected $fillable = [
        'name', 'description', 

        'kind_id','category', 

        'degree', 'status', 
    ];

    public function user()
    {
        return $this->belongTo('App\User', 'id');
    }

    public function savepost()
    {
        return $this->hasMany('App\Savepost', 'post_id');
    }

    public function chat()
    {
        return $this->hasMany('App\Chat', 'post_id');
    }
}
