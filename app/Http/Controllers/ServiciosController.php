<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Clientes;
use App\Servicio;
use DataTables;
use Illuminate\Support\Facades\DB;
Use Carbon\Carbon;



class ServiciosController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        $users = DB::select("select users.id, users.name, count(is_read) as unread 
        from users LEFT JOIN messages ON users.id = messages.from and is_read = 0 and messages.to = " . auth()->id() ." 
        where users.id != " . auth()->id() . " group by users.id, users.name");

        $userss = User::where('id', '!=', auth()->id())->get();
        $userss = DB::table('users')->where('rol', '=' ,'Administrador')->get();
        $userss = DB::select("select users.id, users.name, count(is_read) as unread 
        from users LEFT JOIN messages ON users.id = messages.from and is_read = 0 and messages.to = " . auth()->id() ." 
        where users.id != " . auth()->id() . " and users.rol = 'Administrador' group by users.id, users.name");

        $nombreCliente = Clientes::all();

        $usuariosGet = User::where('id', '!=', auth()->id())->get();
        $usuariosGet = DB::table('users')->where('rol', '!=' ,'Administrador')->get();

        return view('pages/servicios', array('userss'=>$userss, 'users'=>$users, 'nombreCliente'=>$nombreCliente, 'usuariosGet'=>$usuariosGet));
    }

    function getdata()
    {

        $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
                                      ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
                                      ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->get();
                                      
        return DataTables()->of($join)
        ->addColumn('name', function($data){
            $name = $data->name;
            return $name;
        })
        ->addColumn('nombre_cliente', function($data){
            $nombre_cliente = $data->nombre_cliente;
            return $nombre_cliente;
        })
        ->addColumn('referencia', function($data){
            $referencia = $data->referencia;
            return $referencia;
        })
        ->addColumn('tipo_equipo', function($data){
            $tipo_equipo = $data->tipo_equipo;
            return $tipo_equipo;
        })
        ->addColumn('tipo_servicio', function($data){
            $tipo_servicio = $data->tipo_servicio;
            return $tipo_servicio;
        })
        ->addColumn('imagen_inicio', function($data){
            if($data->imagen_inicio == null){
            return 'Pendiente';
            }
            else
            {
            return '<a href="'.$data->imagen_inicio.'" class="linkTable" target="_blank">Imagen Inicio</a>';
            }        
        })
        ->addColumn('imagen_fin', function($data){
            if($data->imagen_fin == null){
            return 'Pendiente';
            }
            else
            {
            return '<a href="'.$data->imagen_fin.'" class="linkTable" target="_blank">Imagen Fin</a>';
            }
        })
        ->addColumn('id_reporte', function($data){
            if($data->id_reporte == null){
            return 'Pendiente';
            }
            else
            {
            return $data->id_reporte;
            }        
        })
        ->addColumn('pdf_reporte', function($data){
            if($data->pdf_reporte == null){
            return 'Pendiente';
            }
            else
            {
            return '<a href="'.$data->pdf_reporte.'" class="linkTable" target="_blank">Reporte (PDF)</a>';
            }
        })
        ->addColumn('fecha_inicio', function($data){
            $fecha_inicio = $data->fecha_inicio;
            $date = Carbon::parse($fecha_inicio);
            return $date->format('d/m/Y');
        })
        ->addColumn('fecha_final', function($data){
            $fecha_final = $data->fecha_final;
            $date = Carbon::parse($fecha_final);
            return $date->format('d/m/Y');
        })
        ->addColumn('status', function($data){
            $status = $data->status;
            return $status;
        })
        ->addColumn('action', function($data){
            return '<a href="#" class="btn btn-xs btn-editarServicio edit" id="'.$data->idServicio.'"><img src="/img/editar.svg" width="24px" height="24px"></a><a href="#" class="btn btn-xs btn-editarServicioDanger delete" id="'.$data->idServicio.'"><img src="/img/eliminar.svg" width="24px" height="24px"></a>';
        })
        ->rawColumns(['name', 'nombre_cliente', 'referencia', 'tipo_equipo', 'tipo_servicio', 'imagen_inicio', 'imagen_fin', 'id_reporte', 'pdf_reporte', 'fecha_inicio', 'fecha_final', 'status', 'action'])
        ->make(true);
    }


    function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_usuario' => 'required',
            'id_cliente'  => 'required',
            'referencia'  => 'required',
            'tipo_equipo'  => 'required',
            'tipo_servicio'  => 'required',
            'fecha_inicio'  => 'required',
            'fecha_final'  => 'required',
            'status'  => 'required',
        ]);

        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
            if($request->get('button_action') == "insert")
            {
                $servicio = new Servicio([
                    'id_usuario' => $request->get('id_usuario'),
                    'id_cliente'  => $request->get('id_cliente'),
                    'referencia'  => $request->get('referencia'),
                    'tipo_equipo'  => $request->get('tipo_equipo'),
                    'tipo_servicio'  => $request->get('tipo_servicio'),
                    'fecha_inicio'  => $request->get('fecha_inicio'),
                    'fecha_final'  => $request->get('fecha_final'),
                    'status'  => $request->get('status'),
                ]);
                $servicio->save();
                $success_output = '<div class="alertaTables alert alert-success">Servicio Añadido</div>';
            }

            if($request->get('button_action') == 'update')
            {
                $servicio = Servicio::find($request->get('servicio_id'));
                $servicio->id_usuario = $request->get('id_usuario');
                $servicio->id_cliente = $request->get('id_cliente');
                $servicio->referencia = $request->get('referencia');
                $servicio->tipo_equipo = $request->get('tipo_equipo');
                $servicio->tipo_servicio = $request->get('tipo_servicio');
                $servicio->fecha_inicio = $request->get('fecha_inicio');
                $servicio->fecha_final = $request->get('fecha_final');
                $servicio->status = $request->get('status');
                $servicio->save();
                $success_output = '<div class="alertaTables alert alert-success">Servicio Actualizado</div>';
            }
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }

    function fetchdata(Request $request)
    {
        $id = $request->input('id');
        $servicio = Servicio::find($id);

        $inicio = $servicio->fecha_inicio;
        $dateInicio = Carbon::parse($inicio)->format('Y-m-d\TH:i');

        $final = $servicio->fecha_final;
        $dateFinal = Carbon::parse($final)->format('Y-m-d\TH:i');

        $output = array(
            'id_usuario' => $servicio->id_usuario,
            'id_cliente' => $servicio->id_cliente,
            'referencia' => $servicio->referencia,
            'tipo_equipo' => $servicio->tipo_equipo,
            'tipo_servicio' => $servicio->tipo_servicio,
            'fecha_inicio' => $dateInicio,
            'fecha_final' => $dateFinal,
            'status' => $servicio->status
        );
        echo json_encode($output);
    }

    function removedata(Request $request)
    {
        $servicio = Servicio::find($request->input('id'));
        if($servicio->delete()){
            echo 'Servicio eliminado';
        }
    }

}




