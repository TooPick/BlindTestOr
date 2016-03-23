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
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseSolo" aria-expanded="false" aria-controls="collapseSolo">Détails &raquo;</button></p>
            <div class="collapse" id="collapseSolo">
                <div class="well">
                    Blabla solo
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <h2>Mode Multijoueur</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseMulti" aria-expanded="false" aria-controls="collapseMulti">Détails &raquo;</button></p>
            <div class="collapse" id="collapseMulti">
                <div class="well">
                    Blabla multi
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <h2>Catégorie</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
            <p><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseCat" aria-expanded="false" aria-controls="collapseCat">Détails &raquo;</button></p>
            <div class="collapse" id="collapseCat">
                <div class="well">
                    Blabla catégories
                </div>
            </div>
        </div>
    </div>
@endsection