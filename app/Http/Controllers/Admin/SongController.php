<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Input;

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
        $song = Song::create($request->all());

        if($request->hasFile('song'))
        {
            $pathToFile = 'upload/song/';
            $fileName = $song->id.'.'.$request->file('song')->getClientOriginalExtension();
            $request->file('song')->move($pathToFile, $fileName);
            $song->link = $pathToFile.$fileName;
            $song->save();
        }

        $song->categories()->sync($request->get('categories'));

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
        if(!empty($song->link))
        {
            $pathToFile = public_path($song->link);
            File::delete($pathToFile);
        }
        $song->delete();
        return redirect(route('admin.song.index'));
    }

    public function update($id, Request $request)
    {
        $song = Song::findOrFail($id);
        $song->update($request->all());
        $song->categories()->sync($request->get('categories'));

        if($request->hasFile('song'))
        {
            if(!empty($song->link))
            {
                $pathToFile = public_path($song->link);
                File::delete($pathToFile);
            }
            
            $pathToFile = 'upload/song/';
            $fileName = $song->id.'.'.$request->file('song')->getClientOriginalExtension();
            $request->file('song')->move($pathToFile, $fileName);
            $song->link = $pathToFile.$fileName;
            $song->save();
        }

        return redirect(route('admin.song.index'));
    }

    public function edit($id)
    {
        $song = Song::findOrFail($id);
        //dd($song->categories->pluck('id')->toArray());

        return view('admin.song.edit', array('song' => $song));
    }
}
