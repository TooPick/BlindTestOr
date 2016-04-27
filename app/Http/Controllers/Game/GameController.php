<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use DB;

use App\Chat;
use App\Score;
use App\Game;
use App\Song;
use App\Action;

class GameController extends Controller
{
    function compareTo($answer , $submission) {
        $article = ["le", "la", "les", "the"];

        if (substr_compare($answer, $submission, 0, strlen($answer), true) != 0) {
            $one = explode(" ", $answer, 2);
            
            if(in_array(strtolower($one[0]), $article)) {
                $result = substr_compare($one[1],$submission, 0, strlen($one[1]),true);
                if($result == 0)
                    return true;
                else 
                    return false;
            }
            else
                return false;
        }
        else 
            return true;
    }

    public function ajaxSendMessage(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();

        $game = Game::where('id', $data['game_id'])->first();

        $song = NULL;

        if($game->song_id != NULL)
            $song = Song::find($game->song_id);

        $response = NULL;
        if($song != NULL)
        {
            switch ($game->question_type) {
                case 0:
                    $response = $song->artist;
                    break;
                case 1:
                    $response = $song->title;
                    break;
            }
        }

        $chat = new Chat;
        $chat->user()->associate($user);
        $chat->game()->associate($data["game_id"]);
        $chat->date = date('Y-m-d H:i:s');

        $round_scores = json_decode($game->round_scores);

        if($game->analyseResponse)
        {
            foreach($round_scores as $winner)
            {
                if($winner->user == $user->id)
                    return json_encode($winner);
            }
        }

        if($game->analyseResponse && $this->compareTo($response, $data["message"])) 
        {
            $nbWinners = count($round_scores);

            //Gestion du nombre de point en fonction du rang de l'utilisateur

            //4eme et plus
            $score = 1;

            switch ($nbWinners) {
                //Premier
                case 0:
                    $score = 4;
                    break;
                //Deuxième
                case 1:
                    $score = 3;
                    break;
                //Troisième
                case 2:
                    $score = 2;
                    break;
            }

            $winner = array(
                "user" => $user->id,
                "score" => $score,
            );

            $round_scores[] = $winner;
            $game->round_scores = json_encode($round_scores);
            $game->save();

            $chat->message = "Bonne réponse vous gagnez : <span style='color:green'>".$score."</span> point(s).";
        }
        else 
            $chat->message = $data["message"];

        $chat->save();

        return json_encode($data["message"]);

    }

    public function ajaxAutoUpdate(Request $request)
    {
        $data = $request->all();

        $lastUpdate = $data["last_update"];

        $chats = Chat::where('game_id', $data['game_id'])->where('date', '>', $lastUpdate)->with('user')->orderBy('date', 'ASC')->get()->toArray();
        $players = Score::where('game_id', $data['game_id'])->with('user')->get()->toArray();
        $actions = Action::where('game_id', $data['game_id'])->where('date', '>', $lastUpdate)->orderBy('date', 'ASC')->get()->toArray();

        if(count($chats) > 0)
            $lastUpdate = $chats[count($chats)-1]["date"];

        if((count($actions) > 0) && ($actions[count($actions)-1]["date"] > $lastUpdate))
            $lastUpdate = $actions[count($actions)-1]["date"];

        $response = array(
            'chats' => $chats,
            'actions' => $actions,
            'date' => $lastUpdate,
            'players' => $players,
        );

        return json_encode($response);
    }

    public function ajaxExitGame(Request $request)
    {
        $data = $request->all();

        $scores = Score::where('game_id', $data['game_id'])->where('user_id', $data['user_id'])->get();

        foreach ($scores as $score) {
            $score->delete();
        }

        $nbPlayers = Score::where('game_id', $data['game_id'])->count();

        if($nbPlayers <= 0)
        {
            $game = Game::where('id', $data['game_id']);
            $chats = Chat::where('game_id', $data['game_id']);
            $chats->delete();
            $actions = Action::where('game_id', $data['game_id']);
            $actions->delete();
            $game->delete();
        }
    }

    public function ajaxGetPlaylist(Request $request)
    {
        $data = $request->all();

        $game = Game::where('id', $data['game_id'])->first();

        $songs = DB::table('songs')
            ->join('category_song', 'songs.id', '=', 'category_song.song_id')
            ->where('category_song.category_id', '=', $game->category_id)
            ->get();

        return json_encode($songs);
    }

    public function ajaxAddAction(Request $request)
    {
        $data = $request->all();

        $game_id = $data['game_id'];
        $actionName = $data['action'];
        $actionParameter = $data['parameter'];

        $action = new Action;
        $action->game_id = $game_id;
        $action->action = $actionName;
        $action->parameter = $actionParameter;
        $action->date = date('Y-m-d H:i:s');
        $action->save();

        return json_encode(true);
    }

    public function ajaxSetSong(Request $request)
    {
        $data = $request->all();

        $game = Game::where('id', $data['game_id'])->first();
        $game->song_id = $data['song_id'];
        $game->analyseResponse = true;

        $question = random_int(0, 1);

        $game->question_type = $question;

        $game->save();

        $result = array(
            'result' => true,
            'question_type' => $game->question_type
        );

        return json_encode($result);
    }

    public function ajaxEndRound(Request $request)
    {
        $data = $request->all();

        $game = Game::where('id', $data['game_id'])->first();

        //Sauvegarde des scores
        $round_scores = json_decode($game->round_scores);
        $isEnd = false;
        foreach ($round_scores as $winner) 
        {
            $score = Score::where('game_id', $data['game_id'])->where('user_id', $winner->user)->first();
            $score->score = $score->score + $winner->score;

            if($score->score >= 15)
            {
                $isEnd = true;
            }

            $score->save();
        }

        //Remise des scores à zéro
        $game->round_scores = json_encode(array());

        $game->analyseResponse = false;
        $game->save();

        $song = Song::where('id', $game->song_id)->first();
        $answer = $song->artist;

        $result = array(
            "answer" => $answer,
            "isEnd" => $isEnd,
        );

        return json_encode($result);
    }

    public function ajaxGetScores(Request $request)
    {
        $data = $request->all();

        $game = Game::where('id', $data['game_id'])->first();

        $scores = Score::where('game_id', $game->id)->with('user')->orderBy('score','asc')->get()->toArray();

        return json_encode($scores);
    }
}