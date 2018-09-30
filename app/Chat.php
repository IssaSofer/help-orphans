<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //
     protected $fillable = [
        'user_1', 'user_2', 'post_id', 'message', 
    ];


}
