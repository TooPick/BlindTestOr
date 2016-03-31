@extends('layout.appli')

@section('title', 'Administration - Editer un utilisateur')

@section('stylesheets')
	<!-- Multiselect CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/multi-select.css') }}">
@endsection

@section('content')
	<div class="row">
	    <h1>Administration des utilisateurs | Editer un utilisateur</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin.user.index') }}">Retour</a></p>
    </div>

    <div class="row">
    	{!! Form::open(array('route' => 'admin.user.store', 'files' => true)) !!}

			<div class="form-group">
				{{ Form::label('admin', 'Administateur', ['class' => 'control-label']) }}
			    {{ Form::checkbox('admin', null, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group text-center">
				<input type="submit" class="btn btn-primary" value="Editer">
			</div>

		{!! Form::close() !!}
    </div>

@endsection