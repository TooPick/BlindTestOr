@extends('layout.appli')

@section('title', 'Administration - Editer une catégorie')

@section('content')
	<div class="row">
	    <h1>Administration des catégories | Editer une catégorie</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin.category.index') }}">Retour</a></p>
    </div>

    <div class="row">
    	{!! Form::open(['method' => 'put', 'url' => route('admin.category.update', $category), 'files' => true]) !!}
		    
		    <div class="form-group">
			    {{ Form::label('name', 'Nom de la catégorie', ['class' => 'control-label']) }}
			    {{ Form::text('name', $category->name, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group">
			    {{ Form::label('slug', 'Slug (optionnel)', ['class' => 'control-label']) }}
			    {{ Form::text('slug', $category->slug, array_merge(['class' => 'form-control'])) }}
			</div>

			@if(!empty($category->image_url))
				<div class="form-group">
					<p>Image actuelle :</p>
					<img style="max-width=200px;max-height:200px;" src="{{ URL::asset($category->image_url) }}">		
				</div>
			@endif

			<div class="form-group">
			    {{ Form::label('image', 'Image de la catégorie', ['class' => 'control-label']) }}
			    {{ Form::file('image', null, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group text-center">
				<input type="submit" class="btn btn-primary" value="Enregistrer">
			</div>

		{!! Form::close() !!}
    </div>

@endsection