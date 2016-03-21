@extends('layout.appli')

@section('title', 'Administration')

@section('content')
	<div class="row">
    	<h1>Administration</h1>
    </div>
    
    <div class="row">
    	<a class="btn btn-primary" href="{{ URL::route('admin.category.index') }}">Gestion des catégories</a>
    	<a class="btn btn-primary" href="{{ URL::route('admin.song.index') }}">Gestion des chansons</a>
    </div>
@endsection