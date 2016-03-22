@extends('layout.appli')

@section('title', 'Administration - Chansons')

@section('content')
	<div class="row">
	    <h1>Administration des chansons</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin_home') }}">Retour</a></p>
	    <br>
		<p><a class="btn btn-primary" href="{{ URL::route('admin.song.create') }}">Ajouter une chanson</a></p>
    </div>

    <div class="row">
    	<table class="table table-striped">
    		<thead>
    			<tr>
    				<th>Titre</th>
    				<th>Artiste</th>
    				<th>Catégories</th>
    				<th>Fichier</th>
    				<th>Actions</th>
    			</tr>
    		</thead>
    		<tbody>
			    @foreach($songs as $song)
			    	<tr>
			    		<td>{{ $song->title }}</td>
			    		<td>{{ $song->artist }}</td>
			    		<td>
			    			<ul>
			    				@foreach($song->categories as $category)
			    					<li>{{ $category->name }}</li>
			    				@endforeach
			    			</ul>
			    		</td>
			    		<td>
			    			@if(!empty($song->link))
			    				Oui
			    			@else
			    				Non
			    			@endif
			    		</td>
			    		<td><a class="btn btn-primary" href="{{ URL::route('admin.song.edit', ['song' => $song->id]) }}">Editer</a>
			    		{{ Form::open(array('url' => route('admin.song.destroy', $song), 'style' => 'display:inline-block')) }}
		                	{{ Form::hidden('_method', 'DELETE') }}
		                    {{ Form::submit('Supprimer', array('class' => 'btn btn-danger')) }}
		                {{ Form::close() }}
			    		</td>
			    	</tr>
			    @endforeach
	    	</tbody>
	    </table>

	    @if(count($songs) <= 0)
	    	<p class="text-center"><b>Aucune chanson...<b></p>
	    @endif
	    
    </div>

@endsection