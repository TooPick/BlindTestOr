<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

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

    public function store()
    {

    }

    public function create()
    {
    	return view('admin.category.create');
    }

    public function show()
    {

    }  

    public function destroy()
    {

    }

    public function update()
    {

    }

    public function edit()
    {

    }
}
