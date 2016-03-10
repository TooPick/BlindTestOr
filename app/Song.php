<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
	protected $fillable = ['link', 'title', 'artist'];

    public function categories()
    {
    	return $this->belongsToMany('App\Category');
    }
}
