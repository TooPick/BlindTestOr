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
    public function ajaxSendMessage(Request $request)
    {
        $data = $request->all();

        $chat = new Chat;
        $chat->message = $data["message"];
        $chat->user()->associate(Auth::user());
        $chat->game()->associate($data["game_id"]);
        $chat->date = date('Y-m-d H:i:s');

        $chat->save();


        /*//$request = Request::ajax();
        $response = array(
            'message' => "lol"
        );
        //var_dump($response);*/
        return json_encode($chat);

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

        $score = Score::where('game_id', $data['game_id'])->where('user_id', Auth::user()->id)->first();
        $score->delete();

        $nbPlayers = Score::where('game_id', $data['game_id'])->count();

        if($nbPlayers <= 0)
        {
            $game = Game::where('id', $data['game_id']);
            $chats = Chat::where('game_id', $data['game_id']);
            $chats->delete();
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
        $game->save();

        return json_encode(true);
    }
}