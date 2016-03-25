<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\Chat;

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

        if(count($chats) > 0)
            $lastUpdate = $chats[count($chats)-1]["date"];

        $response = array(
            'chats' => $chats,
            'date' => $lastUpdate
        );

        return json_encode($response);
    }

}