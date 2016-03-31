@extends('layout.appli')

@section('title', 'Administration - utilisateurs')

@section('content')
	<div class="row">
	    <h1>Administration des utilisateurs</h1>
	    <p><a class="btn btn-primary" href="{{ URL::route('admin_home') }}">Retour</a></p>
    </div>

    <div class="row">
    	<table class="table table-striped">
    		<thead>
    			<tr>
    				<th>username</th>
    				<th>email</th>
    				<th>statut</th>
    			</tr>
    		</thead>
    		<tbody>
			    @foreach($users as $user)
			    	<tr>
			    		<td>{{ $user->username }}</td>
			    		<td>{{ $user->email }}</td>
						<td>
							{!! Form::open(['method' => 'put', 'url' => route('admin.user.update', $user)]) !!}

								<div class="checkbox">
									{{ Form::label('admin', 'Administateur', ['class' => 'control-label']) }}
								    {{ Form::checkbox('admin', true, $user->admin) }}
								</div>

								{{ Form::submit('Editer', array('class' => 'btn btn-primary')) }}

							{!! Form::close() !!}
						</td>
			    		<td>
			    		{{ Form::open(array('url' => route('admin.user.destroy', $user), 'style' => 'display:inline-block')) }}
		                	{{ Form::hidden('_method', 'DELETE') }}
		                    {{ Form::submit('Supprimer', array('class' => 'btn btn-danger')) }}
		                {{ Form::close() }}
			    		</td>
			    	</tr>
			    @endforeach
	    	</tbody>
	    </table>

	    @if(count($users) <= 0)
	    	<p class="text-center"><b>Tu es seul, aucun utilisateurs<b></p>
	    @endif
	    
    </div>

@endsection