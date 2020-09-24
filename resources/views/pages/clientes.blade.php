@if(Auth::user()->rol == "Administrador")


@extends('home')
@section('content')

<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">Clientes</h1>
                    <br />
                    <div align="right">
                        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Añadir Cliente</button>
                    </div>
                    <br />
                    <table id="clientes_table" class="table table-striped table-bordered dataTable" style="width:100%">
                        <thead>
                            <tr style="background-color: white;">
                                <th>Nombre</th>
                                <th>RFC</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div id="clienteModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" id="cliente_form">
                                <div class="modal-header">
                                <h4 class="modal-title">Añadir Cliente</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    {{csrf_field()}}
                                    <span id="form_output"></span>
                                    <div class="form-group">
                                        <label>Nombre del Cliente</label>
                                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>RFC del Cliente</label>
                                        <input type="text" name="rfc_cliente" id="rfc_cliente" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Dirección del cliente</label>
                                        <input type="text" name="direccion_cliente" id="direccion_cliente" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Teléfono del cliente</label>
                                        <input type="text" name="telefono_cliente" id="telefono_cliente" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Email del cliente</label>
                                        <input type="text" name="email_cliente" id="email_cliente" class="form-control" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="cliente_id" id="cliente_id" value="" />
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
     $('#clientes_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('clientes.getdata') }}",
        "columns":[
            { "data": "nombre_cliente" },
            { "data": "rfc_cliente" },
            { "data": "direccion_cliente" },
            { "data": "telefono_cliente" },
            { "data": "email_cliente" },
            { "data": "action", orderable:false, searchable: false, className: "accionesTD"}
        ],
        "language": idioma_espanol,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
     });

     $('#add_data').click(function(){
        $('#clienteModal').modal('show');
        $('#cliente_form')[0].reset();
        $('#form_output').html('');
        $('#button_action').val('insert');
        $('#action').val('Añadir');
    });

    $('#cliente_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"{{ route('clientes.postdata') }}",
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
                    $('#cliente_form')[0].reset();
                    $('#action').val('Añadir');
                    $('.modal-title').text('Añadir Cliente');
                    $('#button_action').val('insert');
                    $('#clientes_table').DataTable().ajax.reload();

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
            url:"{{ route('clientes.fetchdata') }}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#nombre_cliente').val(data.nombre_cliente);
                $('#rfc_cliente').val(data.rfc_cliente);
                $('#direccion_cliente').val(data.direccion_cliente);
                $('#telefono_cliente').val(data.telefono_cliente);
                $('#email_cliente').val(data.email_cliente);
                $('#cliente_id').val(id);
                $('#clienteModal').modal('show');
                $('#action').val('Editar');
                $('.modal-title').text('Editar Cliente');
                $('#button_action').val('update');
            }
        })            
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("¿Estas seguro que quieres eliminar este cliente?"))
        {
            $.ajax({
                url:"{{ route('clientes.removedata') }}",
                method:'get',
                data:{id:id},
                success:function(data)
                {
                    alert(data);
                    $('#clientes_table').DataTable().ajax.reload();
                }

            });
        }
        else{
            return false;
        }
    });

        $('#nav3').addClass('active');  

        


});
var idioma_espanol = {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_   Clientes",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando   Clientes del _START_ al _END_ de un total de _TOTAL_   Clientes",
            "sInfoEmpty":      "Mostrando   Clientes del 0 al 0 de un total de 0   Clientes",
            "sInfoFiltered":   "(filtrado de un total de _MAX_   Clientes)",
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