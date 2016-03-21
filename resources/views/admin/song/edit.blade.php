@extends('layout.appli')

@section('title', 'Administration - Editer une chanson')

@section('content')
	<div class="row">
	    <h1>Administration des catégories | Editer une chanson</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin.song.index') }}">Retour</a></p>
    </div>

    <div class="row">
    	{!! Form::open(['method' => 'put', 'url' => route('admin.song.update', $song)]) !!}
		    
		    <div class="form-group">
			    {{ Form::label('link', 'Lien de la chanson (provisoire)', ['class' => 'control-label']) }}
			    {{ Form::text('link', $song->link, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group">
			    {{ Form::label('title', 'Titre', ['class' => 'control-label']) }}
			    {{ Form::text('title', $song->title, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group">
			    {{ Form::label('artist', 'Artiste', ['class' => 'control-label']) }}
			    {{ Form::text('artist', $song->artist, array_merge(['class' => 'form-control'])) }}
			</div>

			<div class="form-group text-center">
				<input type="submit" class="btn btn-primary" value="Ajouter">
			</div>

		{!! Form::close() !!}
    </div>

@endsection