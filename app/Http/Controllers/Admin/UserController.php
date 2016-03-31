<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Input;

use App\User;

class UserController extends Controller
{
    public function index()
    {
    	$users = User::get();
    	return view('admin.user.index', array('users' => $users));
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return redirect(route('admin.user.index'));
    }

    public function create()
    {
    	return redirect(route('admin.user.index'));
    }

    public function show()
    {
        return redirect(route('admin.user.index'));
    }  

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return redirect(route('admin.user.index'));
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);

        $params = $request->all();

        if(isset($params['admin']) && $params['admin'] == 1)
            $user->admin = 1;
        else
            $user->admin = 0;

        $user->save();

        return redirect(route('admin.user.index'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        //dd($song->categories->pluck('id')->toArray());

        return view('admin.user.edit', array('user' => $user));
    }
}
