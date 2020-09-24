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


class MisServiciosController extends Controller
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
        $useres = User::all();


        return view('pages/mis-servicios', array('userss'=>$userss, 'users'=>$users, 'nombreCliente'=>$nombreCliente, 'useres'=>$useres));
    }

    function getdata()
    {

        $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', auth()->id())
                                      ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
                                      ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Pendiente')->get();
              
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
        ->addColumn('id_reporte', function($data){
            if($data->id_reporte == null){
            return 'Pendiente';
            }
            else
            {
            return $data->id_reporte;
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
            return '<a href="#" class="btn btn-xs btn-editarMiServicio edit" id="'.$data->idServicio.'"><img src="/img/editCheck.svg" width="24px" height="24px"></a>';
        })
        ->rawColumns(['name', 'nombre_cliente', 'referencia', 'tipo_equipo', 'tipo_servicio', 'id_reporte', 'fecha_inicio', 'fecha_final', 'status', 'action'])
        ->make(true);
    }

    function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [

            'referencia'  => 'required',
            'tipo_equipo'  => 'required',
            'tipo_servicio'  => 'required',
            'id_reporte'  => 'required',
            'imagen_inicio' => 'mimes:jpeg,jpg,png,gif|required|max:4000',
            'imagen_fin' => 'mimes:jpeg,jpg,png,gif|required|max:4000',
            'pdf_reporte' => 'required|mimes:pdf|max:4000',

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



            if($request->get('button_action') == 'update')
            {
                $imagen_inicio = $request->file('imagen_inicio');
                $aleatorio = mt_rand(100,999);
                $rutaInicio = 'img/servicios/'.$aleatorio.'.'.$imagen_inicio->guessExtension();

                $imagen_fin = $request->file('imagen_fin');
                $aleatorio = mt_rand(100,999);
                $rutaFin = 'img/servicios/'.$aleatorio.'.'.$imagen_fin->guessExtension();

                $pdf_reporte = $request->file('pdf_reporte');
                $aleatorio = mt_rand(100,999);
                $rutaPDF = 'pdf/'.$aleatorio.'.'.$pdf_reporte->guessExtension();

                $imagen_inicio->move(public_path('img/servicios'), $rutaInicio);
                $imagen_fin->move(public_path('img/servicios'), $rutaFin);
                $pdf_reporte->move(public_path('pdf/'), $rutaPDF);

                $servicio = Servicio::find($request->get('servicio_id'));
                $servicio->referencia = $request->get('referencia');
                $servicio->tipo_equipo = $request->get('tipo_equipo');
                $servicio->tipo_servicio = $request->get('tipo_servicio');
                $servicio->id_reporte = $request->get('id_reporte');
                $servicio->imagen_inicio = $rutaInicio;
                $servicio->imagen_fin = $rutaFin;
                $servicio->pdf_reporte = $rutaPDF;
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


        

        $output = array(
            'id_usuario' => $servicio->id_usuario,
            'id_cliente' => $servicio->id_cliente,
            'referencia' => $servicio->referencia,
            'tipo_equipo' => $servicio->tipo_equipo,
            'tipo_servicio' => $servicio->tipo_servicio,
            'id_reporte' => $servicio->id_reporte,
            'imagen_inicio' => $servicio->imagen_inicio,
            'imagen_fin' => $servicio->imagen_fin,
            'pdf_reporte' => $servicio->pdf_reporte
        );
        echo json_encode($output);
    }


    function getdataCompletado()
    {

        $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', auth()->id())
                                      ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
                                      ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Completado')->get();
              
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
        ->addColumn('id_reporte', function($data){
            if($data->id_reporte == null){
            return 'Pendiente';
            }
            else
            {
            return $data->id_reporte;
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
            return '<a href="#" class="btn btn-xs btn-editarMiServicio edit" id="'.$data->idServicio.'"><img src="/img/editCheck.svg" width="24px" height="24px"></a>';
        })
        ->rawColumns(['name', 'nombre_cliente', 'referencia', 'tipo_equipo', 'tipo_servicio', 'id_reporte', 'fecha_inicio', 'fecha_final', 'status', 'action'])
        ->make(true);
    }

    function getdataNoCompletado()
    {

        $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', auth()->id())
                                      ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
                                      ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'No Completado')->get();
              
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
        ->addColumn('id_reporte', function($data){
            if($data->id_reporte == null){
            return 'Pendiente';
            }
            else
            {
            return $data->id_reporte;
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
            return '<a href="#" class="btn btn-xs btn-editarMiServicio edit" id="'.$data->idServicio.'"><img src="/img/editCheck.svg" width="24px" height="24px"></a>';
        })
        ->rawColumns(['name', 'nombre_cliente', 'referencia', 'tipo_equipo', 'tipo_servicio', 'id_reporte', 'fecha_inicio', 'fecha_final', 'status', 'action'])
        ->make(true);
    }
}
