@extends('layout.appli')

@section('title', 'Mon compte')

@section('content')

    <div class="page-header">
        <h1 style="color:#2cc990">Espace personnel</h1>
        @if(isset($message))
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="	Close"><span aria-hidden="true">&times;</span></button>
				{{ $message }}
			</div>
        @endif

		@if(Session::get("error"))
			<span class="help-block">
			<strong>{{ Session::get("error") }}</strong>
			</span>
			@endif

		@if(Session::get("success"))
			<span class="help-block">
			<strong>{{ Session::get("success") }}</strong>
			</span>
			@endif
    </div>
	
	<div class="row">
		<div class="col-md-3">
			<ul class="nav nav-pills nav-stacked">
				<li  role="presentation" class="change-panel" data-panel="profil"><a href="#">Profil</a></li>
				<li  role="presentation" class="change-panel" data-panel="stats"><a href="#">Statistiques</a></li>
				<li  role="presentation" class="change-panel" data-panel="contact"><a href="#">Contact</a></li>
	
			</ul>
		</div>
		<div id="panels" class="col-md-9 left">
			<div id="profil">

				<div class="row">					

					<div class="col-md-6">
						<p>Nom d'utilisateur : {{ $user->username }}</p>
						<p>Email : {{ $user->email }}</p>
						<p>Mot de passe : ******** </p>
					</div>

					<div class ="col-md-3">
						@if(empty($user->avatar)) 
							<img src="upload/avatar/default/defaultAV.jpg" alt="some text" height="250px"> 
						@else
							<img src="{{ $user->avatar }}" height="250px">
						@endif
					</div>

				</div>

				
			<role="presentation" id="edition" data-panel="editer"><a href="#" class="btn btn-primary">Editer</a></li>


			</div>
			<div id="profil-edition">
				{!! Form::open(array('route' => 'profil.post', 'files' => true)) !!}
					<div class="form-group">
						<label for="Email">Email : </label>
						<input type="email" class="form-control" id="Email" name="email" value="{{ $user->email }}">
					</div>
					<div class="form-group">
						<label for="Password">Mot de passe : </label>
						<input type="password" class="form-control" id="Password" name="password" placeholder="Mot de passe">
						@if (!empty($errors['password']))
                            <span class="help-block">
                                <strong>{{ $errors['password'] }}</strong>
                            </span>
                        @endif
					</div>
					<div class="form-group">
						<label for="Password">Confirmation du mot de passe : </label>
						<input type="password" class="form-control" id="PasswordConf" name="passwordConf" placeholder="Mot de passe">
					</div>
					<div class="form-group">
						<label for="InputFile">Avatar </label>
						<input type="file" id="InputFile" name="avatar">
					</div>
					<button type="submit" class="btn btn-primary">Enregistrer</button>
				{!! Form::close() !!}

			</div>
			<div id="stats" >
				<p>Nombre de partie jouée en mode solo : </p>

				<p>Nombre de partie jouée en mode multi : </p>
				<p>Nombre de partie gagnée : </p>
				<p>Nombre de points total : </p>
				
			</div>
			<div id="contact">

				{!! Form::open(array('route' => 'contact', 'files' => true)) !!}
					<div class="form-group">
						<label for="Email">Email address</label>
						<input type="email" class="form-control" name="email" id="Email" value="{{ $user->email }}">
					</div>
					<div class="form-group">
						<label for="Object">Objet</label>
						<input type="text" class="form-control" name = "object" id="Object" placeholder="Objet">
					</div>
					<div class="form-group">
						<label for="Message">Message</label>
						<textarea class="form-control" rows="10" name="message" placeholder="Message"></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Envoyer</button>
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>




	
@endsection

@section('javascripts')
	<script type="text/javascript">
		$(document).ready(function() {
			$("#panels > div").hide();

			var hash = window.location.hash.substring(1);

			if(hash != "")
			{
				$('#' + hash).show();
	  			$(".change-panel[data-panel='" + hash + "']").addClass("active");
			}
			else
			{
				$("#profil").show();
				$(".change-panel[data-panel='profil']").addClass("active");
			}
			
	  		$(".change-panel").on('click', function(e){
	  			e.preventDefault();
	  			$("#panels > div").hide();
	  			$(".change-panel").removeClass("active");
	  			
	  			var name = $(this).data('panel');
	  			$("#" + name).show();

	  			$(".change-panel[data-panel='"+ name +"']").addClass('active');	
	  		});
	  		$("#edition").on('click', function(){
	  			$("#panels > div").hide();
	  			$("#profil-edition").show();
	  		});
		});
	</script>
@endsection