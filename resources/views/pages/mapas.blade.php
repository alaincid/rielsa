@if(Auth::user()->rol == "Administrador")


@extends('home')
@section('content')

<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">Mapas</h1>
                    <br />
                @foreach($users as $user)
                    <h1 id="{{ $user->id }}">{{ $user->name }}</h1>
                    <div id="map{{ $user->id }}" class="map"></div>
                @endforeach
</main>

<script type="text/javascript">
$(document).ready(function() {

    			// Enable pusher logging - don't include this in production
			Pusher.logToConsole = false;

            var pusher = new Pusher('602962290d7c2075b1c1', {
            cluster: 'us3'
            });

            var channel = pusher.subscribe('my-channel2');
            channel.bind('my-event2', function(data) {
                //alert(JSON.stringify(data));
                //console.log(data);

                // Here's the pusher channel that will be updating everytime the position changes

            });

        

    var map = new GMaps({
      el: '.map',
      lat: -12.043333,
      lng: -77.028333
    });

});

</script>
@endsection

@else

<script>

        window.location="/dashboard"

</script>

@endif