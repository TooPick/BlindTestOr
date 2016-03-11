@extends('layout.appli')

@section('title', 'Erreur 404')

@section('content')

<div class="jumbotron">     
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="text-center col-sm-12 col-lg-12">
                    <h1 class="error-title">Oops, 401 !</h1>
                    <p class="lead">
                        Vous n'êtes pas autorisé à accéder à cette page.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection