@extends('layout.appli')

@section('title', 'Mon compte')

@section('content')

    <div class="page-header">
        <h1 style="color:#2cc990">Espace personnel</h1>
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
			<img src="{{ $user->avatar }}">
			<p>Nom d'utilisateur : {{ $user->username }}</p>
			<p>Email : {{ $user->email }}</p>
			<p>Mot de passe : </p>

				
			<role="presentation" id="edition" data-panel="editer"><a href="#">Editer</a></li>


			</div>
			<div id="profil-edition">
				<form action="" method="POST">
					{{ Form::token() }}
					<div class="form-group">
						<label for="Email">Email : </label>
						<input type="email" class="form-control" id="Email" placeholder="{{ $user->username }}">
					</div>
					<div class="form-group">
						<label for="Password">Mot de passe : </label>
						<input type="password" class="form-control" id="Password" placeholder="Mot de passe">
					</div>
					<div class="form-group">
						<label for="InputFile">Avatar </label>
						<input type="file" id="InputFile">
					</div>
					<button type="submit" class="btn btn-default">Enregistrer</button>
				</form>

			</div>
			<div id="stats" >
				<p>Nombre de partie jouée en mode solo : </p>

				<p>Nombre de partie jouée en mode multi : </p>
				<p>Nombre de partie gagnée : </p>
				<p>Nombre de points total : </p>
				
			</div>
			<div id="contact">

				<form>
					<div class="form-group">
						<label for="Email">Email address</label>
						<input type="email" class="form-control" id="Email" value="{{ $user->email }}">
					</div>
					<div class="form-group">
						<label for="Object">Objet</label>
						<input type="text" class="form-control" id="Object" placeholder="Objet">
					</div>
					<div class="form-group">
						<label for="Message">Message</label>
						<textarea class="form-control" rows="10" placeholder="Message"></textarea>
					</div>
					<button type="submit" class="btn btn-default">Envoyer</button>
				</form>
				
			</div>
		</div>
	</div>




	
@endsection

@section('javascripts')
	<script type="text/javascript">
		$(document).ready(function() {
			$("#panels > div").hide();
			$("#profil").show();
			$(".change-panel[data-panel='profil']").addClass("active");
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