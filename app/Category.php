<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['name', 'slug'];

    public function games()
    {
    	return $this->hasMany('App\Game');
    }

    public function songs()
    {
    	return $this->belongsToMany('App\Song');
    }
}
