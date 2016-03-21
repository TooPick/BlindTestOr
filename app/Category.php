<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

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

    public function setSlugAttribute($value){
    	if(empty($value))
    	{
    		$this->attributes['slug'] = Str::slug($this->name, '-');
    	}
    }
}
