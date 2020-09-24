@extends('home')
@section('content')

@if(Auth::user()->rol == "Administrador")



<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Dashboard</h1>

					<div class="card grid-dashboard">
						<div class="card-header grid-dashboard">
							<div class="d-flex flex-row-reverse">
								<div class="col-md-3 text-center p-0">
									<select name="seleccionarUsuario" id="seleccionarUsuario" class="form-control" value="Todos">
										<option value="Todos">Todos</option>
										@foreach($usuariosGet as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
									</select>
								</div>
							</div>
								<div class="d-flex flex-row">
									<div class="col-md-6 d-inline-flex" style="padding: 20px 0 20px 0; max-height: 78px !important;">

									<input type="date" id="rangoInicio" class="input-group form-control">
									<div class="dateRange"><img src="/img/iconmonstr-arrow-20.svg" alt=""></div>
									<input type="date" id="rangoFinal" class="input-group form-control">
									<button id="filtrar" class="btn btn-success" style="margin: 0 0 0 20px !important;">Filtrar</button>
									<button id="clear" class="btn btn-primary" style="margin: 0 0 0 10px !important;">Limpiar</button>

									</div>
								</div>


							

						</div>
						<div class="card-body">

							<!-- /.row -->

							<div class="row">
								<div class="col-md-3 text-center">
									<div class="card bg-light py-2 py-md-3 border">
                                    <h6 class="card-subtitle text-muted">Servicios Asignados</h6>
										<div class="card-body">
                                            <span id="serviciosAsignados">{{ $serviciosTotalTodos }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-3 text-center">
									<div class="card bg-light py-2 py-md-3 border">
                                    <h6 class="card-subtitle text-muted">Servicios Pendientes</h6>
										<div class="card-body">
										<span id="serviciosPendientes">{{ $serviciosPendientesTodos }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-3 text-center">
									<div class="card bg-light py-2 py-md-3 border">
                                    <h6 class="card-subtitle text-muted">Servicios Completados</h6>
										<div class="card-body">
										<span id="serviciosCompletados">{{ $serviciosCompletadosTodos }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-3 text-center">
									<div class="card bg-light py-2 py-md-3 border">
                                    <h6 class="card-subtitle text-muted">Servicios No Completados</h6>
										<div class="card-body">
										<span id="serviciosNoCompletados">{{ $serviciosNoCompletadosTodos }}</span>
										</div>
									</div>
								</div>
                            </div>
                            
							<!-- /.row -->

						</div>
					</div>

					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">
						<canvas id="myChart"></canvas>
						</div>
						<div class="col-md-2"></div>
					</div>


					<div class="d-flex flex-row" style="padding-top: 100px;">

						<div class="col-md-6">
							<div class="table-responsive">
								<table id="tabla-dashboard" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Cliente</th>
											<th>Equipo</th>
											<th>Servicio</th>
											<th>Fecha</th>
										</tr>
									</thead>
									<tbody id="tbody-dashboard">
										@foreach($join as $join)
										<tr>
											<td>{{$join->name}}</td>
											<td>{{$join->nombre_cliente}}</td>
											<td>{{$join->tipo_equipo}}</td>
											<td>{{$join->tipo_servicio}}</td>
											<td>{{date('d/m/y', strtotime($join->fecha_inicio))}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

					</div>

				</div>
</main>

<script>

var datos = [];


$(document).ready(function() {

				var ctx = document.getElementById('myChart').getContext('2d');
				if (window.MyChart != undefined)
				{
					window.MyChart.destroy();
				}
				window.MyChart = new Chart(ctx, {
				// The type of chart we want to create
				type: 'line',
				data: {
					labels: ['Asignados', 'Pendientes', 'Completados', 'No Completados'],
					datasets: [{
						label: 'Servicios',
						data: [{{ $serviciosTotalTodos }}, {{ $serviciosPendientesTodos }}, {{ $serviciosCompletadosTodos }}, {{ $serviciosNoCompletadosTodos }}],
						backgroundColor: [
							'rgba(54, 162, 235, 0.2)',
							'rgba(255, 206, 86, 0.2)',
							'rgba(75, 192, 192, 0.2)',
							'rgba(255, 99, 132, 0.2)'
						],
						borderColor: [
							'rgba(54, 162, 235, 1)',
							'rgba(255, 206, 86, 1)',
							'rgba(75, 192, 192, 1)',
							'rgba(255, 99, 132, 1)'
						],
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});

			$('#tabla-dashboard').DataTable({
				destroy: true,
				"processing": true,
				"bFilter": false,
				"bInfo": false,
				"language": idioma_espanol,
				responsive: true
				});
    

	$(document).on('change', '#seleccionarUsuario', function(){
        var id = $('#seleccionarUsuario').val();
		var rangoInicio = $('#rangoInicio').val();
		var rangoFinal = $('#rangoFinal').val();

		$.ajax({
            url:"{{ route('dashboard.fetchdata') }}",
            method:'get',
            data:{id:id, rangoInicio:rangoInicio, rangoFinal:rangoFinal},
            dataType:'json',
            success:function(data)
            {

                $('#serviciosAsignados').html(data.serviciosTotal);
                $('#serviciosPendientes').html(data.serviciosPendientes);
                $('#serviciosCompletados').html(data.serviciosCompletados);
                $('#serviciosNoCompletados').html(data.serviciosNoCompletados);

                $('#seleccionarUsuario').val(id);

				var ctx = document.getElementById('myChart').getContext('2d');
				if (window.MyChart != undefined)
				{
					window.MyChart.destroy();
				}
				window.MyChart = new Chart(ctx, {
				// The type of chart we want to create
				type: 'line',
				data: {
					labels: ['Asignados', 'Pendientes', 'Completados', 'No Completados'],
					datasets: [{
						label: 'Servicios',
						data: [data.serviciosTotal, data.serviciosPendientes, data.serviciosCompletados, data.serviciosNoCompletados],
						backgroundColor: [
							'rgba(54, 162, 235, 0.2)',
							'rgba(255, 206, 86, 0.2)',
							'rgba(75, 192, 192, 0.2)',
							'rgba(255, 99, 132, 0.2)'
						],
						borderColor: [
							'rgba(54, 162, 235, 1)',
							'rgba(255, 206, 86, 1)',
							'rgba(75, 192, 192, 1)',
							'rgba(255, 99, 132, 1)'
						],
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});

            }

        })


		$.ajax({
            url:"{{ route('dashboard.fetchdatatable') }}",
            method:'get',
            data:{id:id, rangoInicio:rangoInicio, rangoFinal:rangoFinal},
            dataType:'json',
            success:function(data)
            {



				$('#tabla-dashboard').DataTable({
				destroy: true,
				"processing": true,
				"bFilter": false,
				"bInfo": false,
				"language": idioma_espanol,
				responsive: true
				});

				var contenido = '';



				$.each(data, function(index, value) {
				var date = value.fecha_inicio;
				var fechaInicio = moment(date).format('DD/MM/YY');

					contenido +='<tr>'+
						'<td>'+value.name+'</td>'+
						'<td>'+value.nombre_cliente+'</td>'+
						'<td>'+value.tipo_equipo+'</td>'+
						'<td>'+value.tipo_servicio+'</td>'+
						'<td>'+fechaInicio+'</td>'+
					'</tr>';
				});

				
				$('#tbody-dashboard').html(contenido);



            }

		})

		
		      
    });



	$(document).on('click', '#filtrar', function(){
        var id = $('#seleccionarUsuario').val();
		var rangoInicio = $('#rangoInicio').val();
		var rangoFinal = $('#rangoFinal').val();

		$.ajax({
            url:"{{ route('dashboard.fetchdata') }}",
            method:'get',
            data:{id:id, rangoInicio:rangoInicio, rangoFinal:rangoFinal},
            dataType:'json',
            success:function(data)
            {

                $('#serviciosAsignados').html(data.serviciosTotal);
                $('#serviciosPendientes').html(data.serviciosPendientes);
                $('#serviciosCompletados').html(data.serviciosCompletados);
                $('#serviciosNoCompletados').html(data.serviciosNoCompletados);

                $('#seleccionarUsuario').val(id);


				var ctx = document.getElementById('myChart').getContext('2d');
				if (window.MyChart != undefined)
				{
					window.MyChart.destroy();
				}
				window.MyChart = new Chart(ctx, {
				// The type of chart we want to create
				type: 'line',
				data: {
					labels: ['Asignados', 'Pendientes', 'Completados', 'No Completados'],
					datasets: [{
						label: 'Servicios',
						data: [data.serviciosTotal, data.serviciosPendientes, data.serviciosCompletados, data.serviciosNoCompletados],
						backgroundColor: [
							'rgba(54, 162, 235, 0.2)',
							'rgba(255, 206, 86, 0.2)',
							'rgba(75, 192, 192, 0.2)',
							'rgba(255, 99, 132, 0.2)'
						],
						borderColor: [
							'rgba(54, 162, 235, 1)',
							'rgba(255, 206, 86, 1)',
							'rgba(75, 192, 192, 1)',
							'rgba(255, 99, 132, 1)'
						],
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});

            }

        })

		$.ajax({
            url:"{{ route('dashboard.fetchdatatable') }}",
            method:'get',
            data:{id:id, rangoInicio:rangoInicio, rangoFinal:rangoFinal},
            dataType:'json',
            success:function(data)
            {



				$('#tabla-dashboard').DataTable({
				destroy: true,
				"processing": true,
				"bFilter": false,
				"bInfo": false,
				"language": idioma_espanol,
				responsive: true
				});

				var contenido = '';



				$.each(data, function(index, value) {
				var date = value.fecha_inicio;
				var fechaInicio = moment(date).format('DD/MM/YY');

					contenido +='<tr>'+
						'<td>'+value.name+'</td>'+
						'<td>'+value.nombre_cliente+'</td>'+
						'<td>'+value.tipo_equipo+'</td>'+
						'<td>'+value.tipo_servicio+'</td>'+
						'<td>'+fechaInicio+'</td>'+
					'</tr>';
				});

				
				$('#tbody-dashboard').html(contenido);



            }

		})
		
		      
    });




	$(document).on('click', '#clear', function(){
        var id = $('#seleccionarUsuario').val();
		var rangoInicio = $('#rangoInicio').val(null);
		var rangoFinal = $('#rangoFinal').val(null);

		$.ajax({
            url:"{{ route('dashboard.fetchdata') }}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {

                $('#serviciosAsignados').html(data.serviciosTotal);
                $('#serviciosPendientes').html(data.serviciosPendientes);
                $('#serviciosCompletados').html(data.serviciosCompletados);
                $('#serviciosNoCompletados').html(data.serviciosNoCompletados);

                $('#seleccionarUsuario').val(id);


				var ctx = document.getElementById('myChart').getContext('2d');
				if (window.MyChart != undefined)
				{
					window.MyChart.destroy();
				}
				window.MyChart = new Chart(ctx, {
				// The type of chart we want to create
				type: 'line',
				data: {
					labels: ['Asignados', 'Pendientes', 'Completados', 'No Completados'],
					datasets: [{
						label: 'Servicios',
						data: [data.serviciosTotal, data.serviciosPendientes, data.serviciosCompletados, data.serviciosNoCompletados],
						backgroundColor: [
							'rgba(54, 162, 235, 0.2)',
							'rgba(255, 206, 86, 0.2)',
							'rgba(75, 192, 192, 0.2)',
							'rgba(255, 99, 132, 0.2)'
						],
						borderColor: [
							'rgba(54, 162, 235, 1)',
							'rgba(255, 206, 86, 1)',
							'rgba(75, 192, 192, 1)',
							'rgba(255, 99, 132, 1)'
						],
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});

            }

        })

		$.ajax({
            url:"{{ route('dashboard.fetchdatatable') }}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {



				$('#tabla-dashboard').DataTable({
				destroy: true,
				"processing": true,
				"bFilter": false,
				"bInfo": false,
				"language": idioma_espanol,
				responsive: true
				});

				var contenido = '';



				$.each(data, function(index, value) {
				var date = value.fecha_inicio;
				var fechaInicio = moment(date).format('DD/MM/YY');

					contenido +='<tr>'+
						'<td>'+value.name+'</td>'+
						'<td>'+value.nombre_cliente+'</td>'+
						'<td>'+value.tipo_equipo+'</td>'+
						'<td>'+value.tipo_servicio+'</td>'+
						'<td>'+fechaInicio+'</td>'+
					'</tr>';
				});

				
				$('#tbody-dashboard').html(contenido);



            }

		})
		
		      
    });


    $('#nav1').addClass('active');

});


var idioma_espanol = {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_   Servicios",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando   Servicios del _START_ al _END_ de un total de _TOTAL_   Servicios",
            "sInfoEmpty":      "Mostrando   Servicios del 0 al 0 de un total de 0   Servicios",
            "sInfoFiltered":   "(filtrado de un total de _MAX_   Servicios)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        }

</script>



@else




<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Dashboard</h1>

					<div class="card grid-dashboard">
						<div class="card-header grid-dashboard">
							<h5 class="card-title">Mis Servicios</h5>

						</div>
						<div class="card-body">

							<!-- /.row -->

							<div class="row">
								<div class="col-md-3 text-center">
									<div class="card bg-light py-2 py-md-3 border">
                                    <h6 class="card-subtitle text-muted">Servicios Asignados</h6>
										<div class="card-body">
                                            {{ $serviciosTotal }}
										</div>
									</div>
								</div>
								<div class="col-md-3 text-center">
									<div class="card bg-light py-2 py-md-3 border">
                                    <h6 class="card-subtitle text-muted">Servicios Pendientes</h6>
										<div class="card-body">
                                        {{ $serviciosPendientes }}
										</div>
									</div>
								</div>
								<div class="col-md-3 text-center">
									<div class="card bg-light py-2 py-md-3 border">
                                    <h6 class="card-subtitle text-muted">Servicios Completados</h6>
										<div class="card-body">
                                        {{ $serviciosCompletados }}
										</div>
									</div>
								</div>
								<div class="col-md-3 text-center">
									<div class="card bg-light py-2 py-md-3 border">
                                    <h6 class="card-subtitle text-muted">Servicios No Completados</h6>
										<div class="card-body">
                                        {{ $serviciosNoCompletados }}
										</div>
									</div>
								</div>
                            </div>
                            
							<!-- /.row -->

						</div>
					</div>

				</div>
</main>

<script>

$(document).ready(function() {


    $('#nav1').addClass('active');

});

</script>

@endif


@endsection

