@extends('layout.appli')

@section('title', 'Catégories')

@section('content')

<h2 class="text-center">Catégories</h2>

<div class="row">
	
		@foreach ($categories as $category)
			<div class="col-md-6">
				<a href="{{ URL::route('game', [$type, $category->slug]) }}">
					<!--Bar-->
					<div class="mosaic-block bar">
						<div class="mosaic-overlay">
							<div class="details text-center" style="padding:25px;">
								<h4>{{ $category->name }}</h4>
							</div>
						</div>
						<div class="mosaic-backdrop"><img style="width:100%;height:100%;" src="{{ URL::asset($category->image_url) }}"/></div>
					</div>
				</a>
			</div>
		@endforeach
	
</div>

@endsection

@section('stylesheets')

	<link rel="stylesheet" href="{{ URL::asset('css/mosaic.css') }}" type="text/css" media="screen" />
	
	<script type="text/javascript" src="{{ URL::asset('js/mosaic.1.0.1.min.js') }}"></script>

	<script type="text/javascript">
			
		jQuery(function($){
			
			$('.bar').mosaic({
				animation	:	'slide'		//fade or slide
			});
			
	    });

	</script>

@endsection