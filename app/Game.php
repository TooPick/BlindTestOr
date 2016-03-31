<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['name', 'type', 'response_time', 'finished'];

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

    protected static function boot() {
        parent::boot();

        static::deleting(function($game) { // before delete() method call this
             $game->chats()->delete();
             // do the rest of the cleanup...
        });
    }
}
