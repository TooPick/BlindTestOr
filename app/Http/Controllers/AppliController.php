<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Category;
use App\Http\Requests\ContactFormRequest;
use Auth;
use URL;
use Redirect;

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

    public function profil(){
        $user = Auth::user();
        $errors = array();

        return view('profil', array('user' => $user, 'errors' => $errors));
    }

    public function profilPost(Request $request){
        $post = $request->all();
        $user = Auth::user();
        $errors = array();
        if(!empty($post["email"])) {
            $user->email = $post["email"];
        }

        if(!empty($post["password"])){
            if($post["password"] == $post["passwordConf"]) {
                $user->password = Hash::make($post["password"]);
            }
            else {
                $errors["password"] = "Password does not match";
            }
        }
        $user->save();

        return view('profil', array('user' => $user, 'errors' => $errors));
    }

    public function contact(Request $request){
        $error = "";
        $post = $request->all();

        if(empty($post['email']) || empty($post["message"]) || strlen($post["message"]) < 8 ){
            $error = "Complete all the fields ( the message must be over 8 caracters )";
        }

        return redirect()->to(URL::route('profil'). '#contact')->with('error', $error);
    }

}