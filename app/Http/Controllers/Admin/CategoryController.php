<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        Category::create($request->all());
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
        $category->delete();
        return redirect(route('admin.category.index'));
    }

    public function update($id, Request $request)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect(route('admin.category.index'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.category.edit', array('category' => $category));
    }
}
