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
			<p>Règles : Répondez aux questions le plus vite possible pour gagner un maximum de points !</p>
			<h3 class="text-center">Question : <span id="question">Qui chante cette chanson ?</span></h3>
		</div>
	</div>

	<hr>

	<div class="row">
		<div id="players" class="col-md-4">
			@if($isHost)
				<div id="host-actions">
					<h4>Actions</h4>
					<button class="btn btn-primary" id="start-game">Lancer la partie</button>
				</div>
			@endif

			<h4>Joueurs</h4>
			<ul id="players-list">

			</ul>
		</div>

		<div class="col-md-8">
			<h4>Chat</h4>

			<div id="chat" style="height:300px;background:lightgrey;overflow-y:scroll;"></div>
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
			var playlist = null;

			var player = document.createElement('audio');

			var selected = null;
			var startDate = 0;
			var previewLength = 20;

			//A la fermeture de la fenêtre
			$(window).bind('beforeunload', function() {
				return 'Êtes-vous sûr de vouloir quitter la partie ? Vos points gagnés seront perdus !';
			});
			 
			$(window).unload( function() {
				$.ajax({
					url : '{{ URL::route("ajax.exitGame") }}',
					type : 'POST',
					async : false,
					data : {
						"_token": "{{ csrf_token() }}",
						"game_id": {{ $game->id }}
					}
				});
			});

			$('#send-message').on('click', function (e) {
				e.preventDefault();

				var msg = $.trim($('#chat-message').val());

				if(msg != "")
				{
					$.ajax({
						url : '{{ URL::route("ajax.sendMessage") }}',
						type : 'POST',
						data : {
							"_token": "{{ csrf_token() }}",
							"game_id": {{ $game->id }},
							"message": msg
						},
						success : function(result, statut){
							var result = $.parseJSON(result);

						   $('#chat-message').val('');
						}

					});
				}
			});

			function updatePlayersList(data)
			{
				$('#players-list').html('');
				$.each(data, function(key, value){
					var html = "";

					html += "<li id='" + value['user']['username'] + "'>";
					html += 	"<b class='name'>";
					html +=			value['user']['username'];
					html += 	"</b>";
					html +=		" : ";
					html +=		"<span class='score'>";
					html +=			value['score'];
					html +=		"</span>";
					html += "</li>";

					$('#players-list').append(html);
				});
			}

			function addMessage(user, message)
			{
				var html = "<p><strong>" + user + "</strong> : " + message + "</p>";
	            $('#chat').append(html);
	            $('#chat').scrollTop($('#chat').height());
			}

			//Mise à jour automatique
			var update = 1; //Temps en secondes
			setInterval(function(){
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
				            addMessage(value['user']['username'], value['message']);
				        });
				        
				        updatePlayersList(result['players']);

				        last_update = result["date"];
					}

				});
			
			}, 1000 * update);

			$('#start-game').on('click', function(e) {
				e.preventDefault();
				alert("Début de la partie");

				//Récupération de la playlist
				$.ajax({
					url : '{{ URL::route("ajax.getPlaylist") }}',
					type : 'POST',
					async : false,
					data : {
						"_token": "{{ csrf_token() }}",
						"game_id": {{ $game->id }}
					},
					success : function(result, statut){
						var result = $.parseJSON(result);
						playlist = result;
					}
				});

				//Choix random de la chanson
				selected = playlist[Math.floor(Math.random()*Object.keys(playlist).length)];

				//Chargement de la chanson
				player.setAttribute('src', "{{ url('/') }}/" + selected.link);
				$.get();

				startDate = 0;
			});
		});
	</script>
@endsection