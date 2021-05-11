@if(Auth::user()->rol == "Administrador")


@extends('home')
@section('content')

<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">Mapas</h1>
          <div id="dvMap" >

                    <br />


                <div class="row">
					
                        @foreach($useress as $user)
                        <div id="mapUser{{ $user->id }}" class="col-md-6 text-center paddTop50">
                            <h1 id="{{ $user->id }}">{{ $user->name }}</h1>
                            <div id="map{{ $user->id }}" class="map" data-index=""></div>
                        </div>
                        @endforeach
                    
                </div>
</main>

<script type="text/javascript">


 
    Pusher.logToConsole = true;

    

   
    
    var coords = [
      
    @foreach($useress as $user)
    @if(!empty($user->lat))
    @if(Auth::user()->id != $user->id)
      {
        id: {{$user->id}},
    lat: {{ $user->lat}},
    lng: {{ $user->long}},
    zoom: 17,
    marks: [{
        mlat: {{ $user->lat}},
        mlng: {{ $user->long}},
        mCont: "<p>{{ $user->name }}</p>"
      }
    ]
  },
  @endif
  @endif
  @endforeach
];

       
  
    var markers = [];
var maps = [];
var infowindow = [];



function initMap() {
  for (var i = 0, length = coords.length; i < length; i++) {
    var point = coords[i];
    var latlng = new google.maps.LatLng(point.lat, point.lng);

    maps[i] = new google.maps.Map(document.getElementById('map'+point.id), {
      zoom: point.zoom,
      center: latlng
    });

    for (var j = 0; j < coords[i].marks.length; j++) {
      if (!markers[i]) markers[i] = [];
      if (!infowindow[i]) infowindow[i] = new google.maps.InfoWindow();
      markers[i][j] = new google.maps.Marker({
        position: {
          lat: coords[i].marks[j].mlat,
          lng: coords[i].marks[j].mlng
        },
        map: maps[i]
      });
      google.maps.event.addListener(markers[i][j], 'click', (function(map, content, infowindow) {
        return function(e) {
          infowindow.setContent(content);
          infowindow.open(map, this);
        }
      })(maps[i], coords[i].marks[j].mCont, infowindow[i]));
    }
    $("#map"+point.id).attr("data-index", i);
  }

  var pusher = new Pusher('602962290d7c2075b1c1', {
            cluster: 'us3'
    });

        var channel = pusher.subscribe('my-channel2');
        channel.bind('my-event2', function(data) {
            if (data.id != '1'){
        var MapIndex = $("#map"+data.id).attr("data-index");
        myLatlng = new google.maps.LatLng(data.lat,data.long);
        markers[MapIndex][0].setPosition(myLatlng);
        maps[MapIndex].setCenter(myLatlng);
            }
        });

  return maps;
}


$(window).on('load', function() {
  initMap();
})


$('#nav7').addClass('active');  



</script>
@endsection

@else

<script>

        window.location="/dashboard"

</script>

@endif





