<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Category;

use Auth;

class AppliController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function categories($type)
    {
    	if($type == "solo" || $type == "multi")
    	{
            $categories = Category::get();
        	return view('categories', array('type' => $type, 'categories' => $categories));
    	}
    	else
    	{
    		abort(404);
    	}
    }

    public function game($type, $category)
    {
    	if($type == "solo" || $type == "multi")
    	{
        	return view('game');
    	} 
    	else
    	{
    		abort(404);
    	}
    }

}