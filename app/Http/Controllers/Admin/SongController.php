<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Song;

class SongController extends Controller
{
    public function index()
    {
    	$songs = Song::get();
    	return view('admin.song.index', array('songs' => $songs));
    }

    public function store(Request $request)
    {
        Song::create($request->all());
        return redirect(route('admin.song.index'));
    }

    public function create()
    {
    	return view('admin.song.create');
    }

    public function show()
    {
        return redirect(route('admin.song.index'));
    }  

    public function destroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();
        return redirect(route('admin.song.index'));
    }

    public function update($id, Request $request)
    {
        $song = Song::findOrFail($id);
        $song->update($request->all());
        return redirect(route('admin.song.index'));
    }

    public function edit($id)
    {
        $song = Song::findOrFail($id);

        return view('admin.song.edit', array('song' => $song));
    }
}
