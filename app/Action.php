<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['action', 'parameter', 'date'];

    public function game()
    {
    	return $this->belongsTo('App\Game');
    }
}
