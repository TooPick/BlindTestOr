<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image as Image;
use File;

use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
    	$categories = Category::get();
    	return view('admin.category.index', array('categories' => $categories));
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());

        if($request->hasFile('image'))
        {
            $pathToFile = 'upload/category/'.$category->id.'.'.$request->file('image')->getClientOriginalExtension();
            Image::make($request->file('image'))->save($pathToFile);
            $category->image_url = $pathToFile;
            $category->save();
        }

        return redirect(route('admin.category.index'));
    }

    public function create()
    {
    	return view('admin.category.create');
    }

    public function show()
    {
        return redirect(route('admin.category.index'));
    } 

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if(!empty($category->image_url))
        {
            $pathToFile = public_path($category->image_url);
            File::delete($pathToFile);
        }
        $category->delete();
        return redirect(route('admin.category.index'));
    }

    public function update($id, Request $request)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());

        if($request->hasFile('image'))
        {
            if(!empty($category->image_url))
            {
                $pathToFile = public_path($category->image_url);
                File::delete($pathToFile);
            }
            
            $pathToFile = 'upload/category/'.$category->id.'.'.$request->file('image')->getClientOriginalExtension();
            Image::make($request->file('image'))->save($pathToFile);
            $category->image_url = $pathToFile;
            $category->save();
        }

        return redirect(route('admin.category.index'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.category.edit', array('category' => $category));
    }
}
