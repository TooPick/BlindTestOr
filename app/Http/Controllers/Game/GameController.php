<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

class GameController extends Controller
{
    public function ajaxSendMessage(Request $request)
    {
        $data = $request->get('message');
        /*//$request = Request::ajax();
        $response = array(
            'message' => "lol"
        );
        //var_dump($response);*/
        return json_encode($data);

    }

}