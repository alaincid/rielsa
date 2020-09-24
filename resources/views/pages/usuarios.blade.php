@if(Auth::user()->rol == "Administrador")

@extends('home')
@section('content')

<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">Usuarios</h1>
                    <br />
                    <table id="usuarios_table" class="table table-striped table-bordered dataTable" style="width:100%">
                        <thead>
                            <tr style="background-color: white;">
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div id="usuarioModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" id="usuario_form">
                                <div class="modal-header">
                                <h4 class="modal-title">Añadir usuario</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    {{csrf_field()}}
                                    <span id="form_output"></span>
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" name="name" id="usuario_name" class="form-control" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" id="usuario_email" class="form-control" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input type="text" name="telefono" id="usuario_telefono" class="form-control" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Rol</label>
                                        <select name="rol" id="usuario_rol" class="form-control">
                                            <option value="Usuario">Usuario</option>
                                            <option value="Administrador">Administrador</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="usuario_id" id="usuario_id" value="" />
                                    <input type="hidden" name="button_action" id="button_action" value="" />
                                    <input type="submit" name="submit" id="action" value="Editar" class="btn btn-info" />
                                    <button id="cerrarModal" type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
</main>

<script type="text/javascript">
$(document).ready(function() {
     $('#usuarios_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('usuarios.getdata') }}",
        "columns":[
            { "data": "name" },
            { "data": "email" },
            { "data": "telefono" },
            { "data": "rol" },
            { "data": "action", orderable:false, searchable: false, className: "accionesTD"}
        ],
        "language": idioma_espanol,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    });


    $('#usuario_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"{{ route('usuarios.postdata') }}",
            method:"POST",
            data:form_data,
            dataType:"json",
            success:function(data)
            {
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
                    $('#usuarios_table').DataTable().ajax.reload();

                    window.setTimeout(function() {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                         });
                    }, 5000);
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).attr("id");
        $.ajax({
            url:"{{ route('usuarios.fetchdata') }}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#usuario_name').val(data.name);
                $('#usuario_email').val(data.email);
                $('#usuario_telefono').val(data.telefono);
                $('#usuario_rol').val(data.rol);
                $('#usuario_id').val(id);
                $('#usuarioModal').modal('show');
                $('#action').val('Editar');
                $('.modal-title').text('Editar Cliente');
                $('#button_action').val('update');
            }
        })            
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("¿Estas seguro que quieres eliminar este usuario?"))
        {
            $.ajax({
                url:"{{ route('usuarios.removedata') }}",
                method:'get',
                data:{id:id},
                success:function(data)
                {
                    alert(data);
                    $('#usuarios_table').DataTable().ajax.reload();
                }

            });
        }
        else{
            return false;
        }
    });


        $('#nav2').addClass('active');

});

var idioma_espanol = {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_   Usuarios",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando   Usuarios del _START_ al _END_ de un total de _TOTAL_   Usuarios",
            "sInfoEmpty":      "Mostrando   Usuarios del 0 al 0 de un total de 0   Usuarios",
            "sInfoFiltered":   "(filtrado de un total de _MAX_   Usuarios)",
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
