<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function scores()
    {
    	return $this->hasMany('App\Score');
    }

    public function chats()
    {
    	return $this->hasMany('App\Chat');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
}
