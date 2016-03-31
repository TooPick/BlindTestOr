<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use Auth;
use URL;
use Redirect;

use App\User;
use App\Category;
use App\Game;
use App\Score;

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
            $cat = Category::where('slug', $category)->first();

            $game = NULL;

            //Recherche d'une partie multijoueur déjà commencée
            if($type == "multi")
                $game = Game::where('category_id', $cat->id)->first();

            $nbPlayers = 0;

            //Récupération du nombre de joueurs si une partie est trouvée
            if($game != NULL)
                $nbPlayers = Score::where('game_id', $game->id)->count();

            //Aucune partie trouvée ou solo ou plus de 6 joueurs
            if($game == NULL || $nbPlayers >= 6)
            {
                //Création d'une nouvelle partie
                $game = new Game;

                if($type == "solo")
                    $game->type = 0;
                else
                    $game->type = 1;

                $game->response_time = 20;
                $game->finished = 0;
                $game->category()->associate($cat);
            }
            //Partie trouvée et moins de 7 joueurs
            else
            {

            }

            $game->save();

            $score = new Score;
            $score->user()->associate(Auth::user());
            $score->game()->associate($game);
            $score->score = 0;
            
            $score->save();

            //dd($score);
        	return view('game', array('game' => $game));
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