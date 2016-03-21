@extends('layout.appli')

@section('title', 'Administration - Catégories')

@section('content')
	<div class="row">
	    <h1>Administration des catégories</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin_home') }}">Retour</a></p>
	    <br>
		<p><a class="btn btn-primary" href="{{ URL::route('admin.category.create') }}">Ajouter une catégorie</a></p>
    </div>

    <div class="row">
    	<table class="table table-striped">
    		<thead>
    			<tr>
    				<th>Nom</th>
    				<th>Slug</th>
    				<th>Actions</th>
    			</tr>
    		</thead>
    		<tbody>
			    @foreach($categories as $category)
			    	<tr>
			    		<td>{{ $category->name }}</td>
			    		<td>{{ $category->slug }}</td>
			    		<td><a class="btn btn-primary" href="{{ URL::route('admin.category.edit', ['category' => $category->id]) }}">Editer</a>
			    		{{ Form::open(array('url' => route('admin.category.destroy', $category), 'style' => 'display:inline-block')) }}
		                	{{ Form::hidden('_method', 'DELETE') }}
		                    {{ Form::submit('Supprimer', array('class' => 'btn btn-danger')) }}
		                {{ Form::close() }}
			    		</td>
			    	</tr>
			    @endforeach
	    	</tbody>
	    </table>

	    @if(count($categories) <= 0)
	    	<p class="text-center"><b>Aucune catégorie...<b></p>
	    @endif

    </div>

@endsection