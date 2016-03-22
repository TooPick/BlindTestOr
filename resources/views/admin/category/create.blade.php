@extends('layout.appli')

@section('title', 'Administration - Ajouter une catégorie')

@section('content')
	<div class="row">
	    <h1>Administration des catégories | Ajouter une catégorie</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin.category.index') }}">Retour</a></p>
    </div>

    <div class="row">
    	{!! Form::open(array('route' => 'admin.category.store', 'files' => true)) !!}
		    
		    <div class="form-group">
			    {{ Form::label('name', 'Nom de la catégorie', ['class' => 'control-label']) }}
			    {{ Form::text('name', null, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group">
			    {{ Form::label('slug', 'Slug (optionnel)', ['class' => 'control-label']) }}
			    {{ Form::text('slug', null, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group">
			    {{ Form::label('image', 'Image de la catégorie', ['class' => 'control-label']) }}
			    {{ Form::file('image', null, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group text-center">
				<input type="submit" class="btn btn-primary" value="Ajouter">
			</div>

		{!! Form::close() !!}
    </div>

@endsection