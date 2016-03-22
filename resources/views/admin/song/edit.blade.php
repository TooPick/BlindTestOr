@extends('layout.appli')

@section('title', 'Administration - Editer une chanson')

@section('content')
	<div class="row">
	    <h1>Administration des catégories | Editer une chanson</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin.song.index') }}">Retour</a></p>
    </div>

    <div class="row">
    	{!! Form::open(['method' => 'put', 'url' => route('admin.song.update', $song), 'files' => true]) !!}
		    
		    @if(!empty($song->link))
		    	<div class="form-group">
		    		<p>Une chanson est déjà uploadée.</p>
		    	</div>
		    @endif
		    
		    <div class="form-group">
			    {{ Form::label('song', 'Fichier de la chanson', ['class' => 'control-label']) }}
			    {{ Form::file('song', null, array_merge(['class' => 'form-control'])) }}
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