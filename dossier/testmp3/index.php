<!DOCTYPE html>
<html>
	<head>
		<title>Test MP3</title>
		<meta charset="UTF-8" />
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	</head>
	<body>

		<h1>Test lecture mp3</h1>
		<p>Titre : <span id="song-title"></span></p>
		<p>Artiste : <span id="song-artist"></span></p>
		<p>Progression : <span id="time">--:--</span> / <span id="duration">--:--</span></p>

		<button id="new-game">New Game !!</button>

		<script type="text/javascript">
			$(function() {
				var playlist = {
				  "0":{
				    "title" : "Raoul et Rosita",
				    "artist": "Les Fatals Picards",
				    "link": "7.mp3"
				  },
				  "1":{
				    "title" : "Without You",
				    "artist": "Anna Tsuchiya",
				    "link": "8.mp3"
				  }
				};

				var player = document.createElement('audio');

				var selected = null;
				var startDate = 0;
				var previewLength = 20;

				$('#new-game').on('click', function(){
					//Choix random de la chanson
					selected = playlist[Math.floor(Math.random()*Object.keys(playlist).length)];

					//Chargement de la chanson
					player.setAttribute('src', 'songs/' + selected.link);
					$.get();

					startDate = 0;

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

						//Déplacement du début de l'écoute
						player.currentTime = random;

						//Enregistrement de la valeur de début
						startDate = random;

						$('#song-title').html(selected.title);
						$('#song-artist').html(selected.artist);

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
				});
			});
		</script>
	</body>
</html>