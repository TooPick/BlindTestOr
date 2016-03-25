@extends('layout.appli')

@section('title', 'Jeu')

@section('content')
	
	<div class="row text-center">
		<h2>Jouer</h2>
	</div>

	<hr>

	<div class="row">
		<div id="timers" class="col-md-4">
			<p>Prochain round dans : <span id="timer-next-round">00:20</span> minutes.</p>
			<p>Temps de l'écoute : <span id="preview-time">20</span> secondes.</p>
		</div>

		<div class="col-md-8">
			<p>Règles : Répondez aux questions le plus vite porssible pour gagner un maximum de points !</p>
			<h3 class="text-center">Question : Qui chante cette chanson ?</h3>
		</div>
	</div>

	<hr>

	<div class="row">
		<div id="players" class="col-md-4">
			<h4>Joueurs</h4>
			<ul id="players-list">
				<li id="joueur-1"><b class="name">Joueur 1</b> : <span class="score">10</span></li>
				<li id="joueur-2"><b class="name">Joueur 2</b> : <span class="score">3</span></li>
			</ul>
		</div>

		<div class="col-md-8">
			<h4>Chat</h4>

			<div id="chat" style="height:300px;background:lightgrey;"></div>
			<br>
			<form class="form-horizontal">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" id="chat-message" name="chat-message" placeholder="Message...">
						<span class="input-group-btn">
							<input type="submit" id="send-message" class="btn btn-primary" value="Envoyer">
						</span>
					</div>	
				</div>
			</form>
	</div>

@endsection

@section('javascripts')
	<script src="{{ URL::asset('js/moment.js') }}"></script>

	<script type="text/javascript">
		$(function() {
			var last_update = 0;

			$(window).bind("beforeunload", function() { 
				return confirm("Do you really want to close?"); 
			});

			$('#send-message').on('click', function (e) {
				e.preventDefault();
				$.ajax({
					url : '{{ URL::route("ajax.sendMessage") }}',
					type : 'POST',
					data : {
						"_token": "{{ csrf_token() }}",
						"game_id": {{ $game->id }},
						"message": $('#chat-message').val()
					},
					success : function(result, statut){
						var result = $.parseJSON(result);
						console.log(result);
					   //console.log(result["message"]);

					   $('#chat-message').val('');
					},

					error : function(resultat, statut, erreur){

					},

				});
			});

			//Mise à jour automatique
			var update = 1; //Temps en secondes
			setInterval(function(){

				console.log("update");
				$.ajax({
					url : '{{ URL::route("ajax.autoUpdate") }}',
					type : 'POST',
					data : {
						"_token": "{{ csrf_token() }}",
						"game_id": {{ $game->id }},
						"last_update": last_update
					},
					success : function(result, statut){
						var result = $.parseJSON(result);

						var length = result["chats"].length;

						$.each(result['chats'], function(key, value) {
				            var message = "<p><strong>" + value["user"]["username"] + "</strong> : " + value["message"] + "</p>";
				            $('#chat').append(message);
				        });

				        last_update = result["date"];
				        
				        console.log(result);
						console.log(last_update);
					},

					error : function(resultat, statut, erreur){

					},

				});
			
			}, 1000 * update);
		});
	</script>
@endsection