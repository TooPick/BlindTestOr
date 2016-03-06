@extends('layout.appli')

@section('title', 'Connexion')

@section('content')

<form class="form-signin">
	<h2 class="form-signin-heading">Connexion</h2>
	<input type="text" class="form-control" placeholder="Adresse email" autofocus>
	<input type="password" class="form-control" placeholder="Mot de passe">
	<label class="checkbox">
		<input type="checkbox" value="remember-me"> Se souvenir de moi
	</label>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
</form>

@endsection