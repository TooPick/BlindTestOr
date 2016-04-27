@extends('layout.appli')

@section('title', 'Accueil')

@section('content')
    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1>BlindTestOr</h1>
    </div>

    <!-- Example row of columns -->
    <div class="row">
        <div class="col-lg-4">
            <h2>Mode Solo</h2>
            <p>Teste tes connaissances et améliore les en mode solo. Une compétition avec sois même !  </p>
            <p><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseSolo" aria-expanded="false" aria-controls="collapseSolo">Détails &raquo;</button></p>
            <div class="collapse" id="collapseSolo">
                <div class="well">
                    Le mode solo fonctionne sous la forme d'un chat. Une question est posé en haut, un extrait se lance et tu dois deviner le titre ou l'artiste en fonction de la question. 
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <h2>Mode Multijoueur</h2>
            <p>Affronte les autres joueurs sur tes catégories préférées et vois qui à la meilleure culture musicale !  </p>
            <p><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseMulti" aria-expanded="false" aria-controls="collapseMulti">Détails &raquo;</button></p>
            <div class="collapse" id="collapseMulti">
                <div class="well">
                    Le mode multi est sur la même principe que le mode solo. Un chat, une question, un extrait. Tu dois trouver le titre ou l'artiste en fonction fonction de la question. La seule différence est la compétition du mode en ligne. 
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <h2>Catégorie</h2>
            <p>Plus rock ou année 80 ? Nous avons pensé à tous !</p>
            <p><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseCat" aria-expanded="false" aria-controls="collapseCat">Détails &raquo;</button></p>
            <div class="collapse" id="collapseCat">
                <div class="well">
                    Plusieures catégories sont disponibles afin de couvrir la plupart des styles musicaux et contenter tout le monde ! 
                </div>
            </div>
        </div>
    </div>
@endsection