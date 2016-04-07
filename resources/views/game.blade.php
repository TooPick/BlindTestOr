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
			<p>Temps de l'écoute : <span id="preview-time">{{ $game->response_time }}</span> secondes.</p>
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

			<div id="chat"></div>
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
			var previewLength = {{ $game->response_time }};

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

			function addAction(action, parameter){
				$.ajax({
					url : '{{ URL::route("ajax.addAction") }}',
					type : 'POST',
					async : false,
					data : {
						"_token": "{{ csrf_token() }}",
						"game_id": {{ $game->id }},
						"action": action,
						"parameter": parameter,
					},
					success : function(result, statut){
						console.log(result);
					}
				});
			}

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
							console.log(result);

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

			function makeAction(action, parameter)
			{
				console.log(parameter);
				switch(action) {
					case 'startMusic':
						var music = $.parseJSON(parameter);
						console.log(music);
						startMusic(player, music);
						break;
				}
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
						console.log(result);

						var length = result["chats"].length;

						$.each(result['chats'], function(key, value) {
				            addMessage(value['user']['username'], value['message']);
				        });

						$.each(result['actions'], function(key, value) {
							makeAction(value['action'], value['parameter']);
						});
				        
				        updatePlayersList(result['players']);

				        last_update = result["date"];
					}

				});
			
			}, 1000 * update);

			function startMusic(player, music){
				//Chargement de la chanson
				player.setAttribute('src', "{{ url('/') }}/" + music.link);
				$.get();

				startDate = music.startDate;

				player.onloadedmetadata = function()
				{
					//Déplacement du début de l'écoute
					player.currentTime = startDate;

					player.play();
				}

				function formatTime(time)
				{
					var minutes = Math.round(time/60);
					var sec = Math.round(time%60);
					var result = minutes + ":" + sec;
					return result;
				}

				function endPreview()
				{
					var time = Math.round(player.currentTime) - startDate;
					if(time >= previewLength || time > player.duration)
					{
						player.pause();
						alert("Fin de l'écoute");
					}
				}

				player.onplay = function() {
					$("#duration").html(formatTime(player.duration));
				};

				player.ontimeupdate = function() {
					//Mise à jour de l'affichage
					$("#time").html(formatTime(player.currentTime));
					
					//Détecte si le temps d'écoute est écoulé
					endPreview();
				};
			}

			function generateRandomStart(player, music)
			{
				//Chargement de la chanson
				player.setAttribute('src', "{{ url('/') }}/" + music.link);
				$.get();

				player.onloadedmetadata = function()
				{
					//Sélection de la portion de chanson aléatoire 
					var middle = Math.round(player.duration / 2);

					//Minimum du random
					var begin = middle - 60;
					if(begin < 0)
						begin = 0;

					//Maximum du random
					var end = middle + 60;
					if(end > player.duration)
						end = player.duration;

					//Random
					var random = Math.floor(Math.random()*(end-begin+1)+begin);
					//Cas du random trop proche de la fin
					if((player.duration - random) < previewLength)
						random = Math.floor(player.duration - previewLength);

					music.startDate = random;
					addAction('startMusic', JSON.stringify(music));
				}
			}

			$('#start-game').on('click', function(e) {
				e.preventDefault();

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

				//Enregistrement de la musique random
				$.ajax({
					url : '{{ URL::route("ajax.setSong") }}',
					type : 'POST',
					async : false,
					data : {
						"_token": "{{ csrf_token() }}",
						"game_id": {{ $game->id }},
						"song_id": selected.id,
					},
					success : function(result, statut){
						var result = $.parseJSON(result);
						console.log(result);

						if(result)
							generateRandomStart(player, selected);
					}
				});

				generateRandomStart(player, selected);
			});
		});
	</script>
@endsection