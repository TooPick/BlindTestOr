@extends('layout.appli')

@section('title', 'Administration - Editer une catégorie')

@section('content')
	<div class="row">
	    <h1>Administration des catégories | Editer une catégorie</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin.category.index') }}">Retour</a></p>
    </div>

    <div class="row">
    	{!! Form::open(['method' => 'put', 'url' => route('admin.category.update', $category)]) !!}
		    
		    <div class="form-group">
			    {{ Form::label('name', 'Nom de la catégorie', ['class' => 'control-label']) }}
			    {{ Form::text('name', $category->name, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group">
			    {{ Form::label('slug', 'Slug (optionnel)', ['class' => 'control-label']) }}
			    {{ Form::text('slug', $category->slug, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group text-center">
				<input type="submit" class="btn btn-primary" value="Enregistrer">
			</div>

		{!! Form::close() !!}
    </div>

@endsection