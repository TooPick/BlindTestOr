@extends('layout.appli')

@section('title', 'Administration')

@section('content')
    <h1>Administration</h1>

    <ul>
    	<li><a href="{{ URL::route('admin.category.index') }}">Gestion des catégories</a></li>
    </ul>
@endsection