@extends('layout.appli')

@section('title', 'Administration - Ajouter une chason')

@section('content')
	<div class="row">
	    <h1>Administration des catégories | Ajouter une chanson</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin.song.index') }}">Retour</a></p>
    </div>

    <div class="row">
    	{!! Form::open(array('route' => 'admin.song.store', 'files' => true)) !!}
		    
		    <div class="form-group">
			    {{ Form::label('song', 'Fichier de la chanson', ['class' => 'control-label']) }}
			    {{ Form::file('song', null, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group">
			    {{ Form::label('title', 'Titre', ['class' => 'control-label']) }}
			    {{ Form::text('title', null, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group">
			    {{ Form::label('artist', 'Artiste', ['class' => 'control-label']) }}
			    {{ Form::text('artist', null, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group text-center">
				<input type="submit" class="btn btn-primary" value="Ajouter">
			</div>

		{!! Form::close() !!}
    </div>

@endsection