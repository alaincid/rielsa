@if(Auth::user()->rol == "Usuario")


@extends('home')
@section('content')

<main class="content">
				<div class="container-fluid p0">
					<h1 class="h3 mb-3">Mis Servicios Pendientes</h1>

                    <br />
                    <table id="mis-servicios_table" class="table table-striped table-bordered dataTable" style="width:100%">
                        <thead>
                            <tr style="background-color: white;">
                                <th>Usuario</th>
                                <th>Cliente</th>
                                <th>Referencia</th>
                                <th>Equipo</th>
                                <th>Servicio</th>
                                <th>No. de Reporte</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Status</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="container-fluid p0">
					<h1 class="h3 mb-3">Mis Servicios Completados</h1>

                    <br />
                    <table id="mis-servicios-completados_table" class="table table-striped table-bordered dataTable" style="width:100%">
                        <thead>
                            <tr style="background-color: white;">
                                <th>Usuario</th>
                                <th>Cliente</th>
                                <th>Referencia</th>
                                <th>Equipo</th>
                                <th>Servicio</th>
                                <th>No. de Reporte</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="container-fluid p0">
					<h1 class="h3 mb-3">Mis Servicios No Completados</h1>

                    <br />
                    <table id="mis-servicios-nocompletados_table" class="table table-striped table-bordered dataTable" style="width:100%">
                        <thead>
                            <tr style="background-color: white;">
                                <th>Usuario</th>
                                <th>Cliente</th>
                                <th>Referencia</th>
                                <th>Equipo</th>
                                <th>Servicio</th>
                                <th>No. de Reporte</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div id="servicioModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" id="servicio_form" enctype="multipart/form-data">
                                <div class="modal-header">
                                <h4 class="modal-title">Añadir Servicio</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    {{csrf_field()}}
                                    <span id="form_output"></span>
                                    <div class="form-group">
                                        <label>Usuario</label>
                                        <select name="id_usuario" id="id_usuario" class="form-control" disabled>
                                                <option value="">Elige el Usuario</option>
                                            @foreach($useres as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select name="id_cliente" id="id_cliente" class="form-control" disabled>
                                                <option value="">Elige el Cliente</option>
                                            @foreach($nombreCliente as $nombreCliente)
                                                <option value="{{ $nombreCliente->id }}">{{ $nombreCliente->nombre_cliente }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Referencia</label>
                                        <input type="text" name="referencia" id="referencia" class="form-control" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipo de Equipo</label>
                                        <input type="text" name="tipo_equipo" id="tipo_equipo" class="form-control" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipo de Servicio</label>
                                        <input type="text" name="tipo_servicio" id="tipo_servicio" class="form-control" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label>ID Reporte</label>
                                        <input type="text" name="id_reporte" id="id_reporte" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Imagen ID Equipo</label>
                                        <input type="file" name="imagen_inicio" id="imagen_inicio" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Imagen Servicio Terminado</label>
                                        <input type="file" name="imagen_fin" id="imagen_fin" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Reporte en PDF</label>
                                        <input type="file" name="pdf_reporte" id="pdf_reporte" class="form-control" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="servicio_id" id="servicio_id" value="" />

                                    <input type="hidden" name="button_action" id="button_action" value="insert" />
                                    <input type="submit" name="submit" id="action" value="Añadir" class="btn btn-info" />
                                    <button id="cerrarModal" type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
</main>


<script type="text/javascript">
$(document).ready(function() {
     $('#mis-servicios_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('mis-servicios.getdata') }}",
        "columns":[
            { "data": "name"},
            { "data": "nombre_cliente"},
            { "data": "referencia" },
            { "data": "tipo_equipo" },
            { "data": "tipo_servicio" },
            { "data": "id_reporte" },
            { "data": "fecha_inicio" },
            { "data": "fecha_final" },
            { "data": "status" },
            { "data": "action", orderable:false, searchable: false, className: "text-center"}

        ],
        "language": idioma_espanol,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
     });

     $('#servicio_form').on('submit', function(event){
        event.preventDefault();

        $.ajax({
        url:"{{ route('mis-servicios.postdata') }}",
        method:"POST",
        dataType:"json",
        data:new FormData(this),       // change this and the following options
        contentType: false, 
        processData: false,
        cache: false,
        success: function(data) {
                if(data.error.length > 0)
                {
                    var error_html = '';
                    for(var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<div class="alertaTables alert alert-danger">'+data.error[count]+'</div>';
                    }
                    $('#form_output').html(error_html);
                    window.setTimeout(function() {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                         });
                    }, 5000);
                }
                else
                {
                    $('#form_output').html(data.success);
                    $('#mis-servicios_table').DataTable().ajax.reload();

                    window.setTimeout(function() {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                         });
                    }, 5000);
                }
            }
        });
    });



    $(document).on('click', '.edit', function(){
        var id = $(this).attr("id");
        $.ajax({
            url:"{{ route('mis-servicios.fetchdata') }}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#id_usuario').val(data.id_usuario);
                $('#id_cliente').val(data.id_cliente);
                $('#referencia').val(data.referencia);
                $('#tipo_equipo').val(data.tipo_equipo);
                $('#tipo_servicio').val(data.tipo_servicio);
                $('#id_reporte').val(data.id_reporte);
                $('#imagen_inicio').html(data.imagen_inicio);
                $('#imagen_fin').html(data.imagen_fin);
                $('#pdf_reporte').html(data.pdf_reporte);
                $('#servicio_id').val(id);
                $('#servicioModal').modal('show');
                $('#action').val('Editar');
                $('.modal-title').text('Editar Servicio');
                $('#button_action').val('update');
            }
        })            
    });


    $('#mis-servicios-completados_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('mis-servicios.getdataCompletado') }}",
        "columns":[
            { "data": "name"},
            { "data": "nombre_cliente"},
            { "data": "referencia" },
            { "data": "tipo_equipo" },
            { "data": "tipo_servicio" },
            { "data": "id_reporte" },
            { "data": "fecha_inicio" },
            { "data": "fecha_final" },
            { "data": "status" }
        ],
        "language": idioma_espanol,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
     });


     $('#mis-servicios-nocompletados_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('mis-servicios.getdataNoCompletado') }}",
        "columns":[
            { "data": "name"},
            { "data": "nombre_cliente"},
            { "data": "referencia" },
            { "data": "tipo_equipo" },
            { "data": "tipo_servicio" },
            { "data": "id_reporte" },
            { "data": "fecha_inicio" },
            { "data": "fecha_final" },
            { "data": "status" }
        ],
        "language": idioma_espanol,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
     });

        $('#nav4').addClass('active');


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

@endsection

@else

<script>

        window.location="/dashboard"

</script>

@endif
