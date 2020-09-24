<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Pusher\Pusher;
use DB;
use Auth;
Use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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


        $usuariosGet = User::where('id', '!=', auth()->id())->get();
        $usuariosGet = DB::table('users')->where('rol', '!=' ,'Administrador')->get();


        $serviciosTotal = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', auth()->id())
        ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
        ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->count();

        $serviciosPendientes = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', auth()->id())
        ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
        ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Pendiente')->count();

        $serviciosCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', auth()->id())
        ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
        ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Completado')->count();

        $serviciosNoCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', auth()->id())
        ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
        ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'No Completado')->count();




        $serviciosTotalTodos = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
        ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
        ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->count();

        $serviciosPendientesTodos = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
        ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
        ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Pendiente')->count();

        $serviciosCompletadosTodos = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
        ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
        ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Completado')->count();

        $serviciosNoCompletadosTodos = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
        ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
        ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'No Completado')->count();



        $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
        ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
        ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->get();


        return view('pages/dashboard', array('userss'=>$userss, 'users'=>$users, 'usuariosGet'=>$usuariosGet, 'serviciosTotal'=>$serviciosTotal, 'serviciosPendientes'=>$serviciosPendientes, 'serviciosCompletados'=>$serviciosCompletados, 'serviciosNoCompletados'=>$serviciosNoCompletados, 'serviciosTotalTodos'=>$serviciosTotalTodos, 'serviciosPendientesTodos'=>$serviciosPendientesTodos, 'serviciosCompletadosTodos'=>$serviciosCompletadosTodos, 'serviciosNoCompletadosTodos'=>$serviciosNoCompletadosTodos, 'join'=>$join));

    }

    public function getMessage($user_id)
    {
        $my_id = auth()->id();

        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->get();

        return view('messages.index', ['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $from = auth()->id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();   
        
        $options = array(
            'cluster' => 'us3'
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to];
        $pusher->trigger('my-channel', 'my-event', $data);
    }






    function fetchdata(Request $request)
    {
        $id = $request->input('id');
        $rangoInicio = $request->input('rangoInicio');
        $rangoFinal = $request->input('rangoFinal');
        

    if($rangoInicio == null & $rangoFinal == null){

        if($id == 'Todos'){

            $serviciosTotal = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->count();
    
            $serviciosPendientes = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Pendiente')->count();
    
            $serviciosCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Completado')->count();
    
            $serviciosNoCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'No Completado')->count();
    

            $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->get();
    


            $output = array(
    
                'serviciosTotal'=>$serviciosTotal,
                'serviciosPendientes'=>$serviciosPendientes,
                'serviciosCompletados'=>$serviciosCompletados,
                'serviciosNoCompletados'=>$serviciosNoCompletados
    
            );

            
            echo json_encode($output);
    
    
            }
            else{
    
            
    
            $serviciosTotal = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->count();
    
            $serviciosPendientes = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Pendiente')->count();
    
            $serviciosCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Completado')->count();
    
            $serviciosNoCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'No Completado')->count();
    
            $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->get();
    
            
            $output = array(
    
                'serviciosTotal'=>$serviciosTotal,
                'serviciosPendientes'=>$serviciosPendientes,
                'serviciosCompletados'=>$serviciosCompletados,
                'serviciosNoCompletados'=>$serviciosNoCompletados
    
            );
            echo json_encode($output);
    
            }

    }else{
        $rangoFinale = $request->input('rangoFinal');
        $rangoFinal = Carbon::parse($rangoFinale)->addHours(24);

        if($id == 'Todos'){

            $serviciosTotal = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->count();
    
            $serviciosPendientes = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Pendiente')->count();
    
            $serviciosCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Completado')->count();
    
            $serviciosNoCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'No Completado')->count();
    
            $output = array(
    
                'serviciosTotal'=>$serviciosTotal,
                'serviciosPendientes'=>$serviciosPendientes,
                'serviciosCompletados'=>$serviciosCompletados,
                'serviciosNoCompletados'=>$serviciosNoCompletados  
            );
            echo json_encode($output);
    
    
            }
            else{
    
            
    
            $serviciosTotal = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->count();
    
            $serviciosPendientes = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Pendiente')->count();
    
            $serviciosCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'Completado')->count();
    
            $serviciosNoCompletados = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->where('servicios.status', '=', 'No Completado')->count();
    
            $output = array(
    
                'serviciosTotal'=>$serviciosTotal,
                'serviciosPendientes'=>$serviciosPendientes,
                'serviciosCompletados'=>$serviciosCompletados,
                'serviciosNoCompletados'=>$serviciosNoCompletados
            );
            echo json_encode($output);
    
            }

        }

    }











    function fetchdatatable(Request $request)
    {
        $id = $request->input('id');
        $rangoInicio = $request->input('rangoInicio');
        $rangoFinal = $request->input('rangoFinal');
        

    if($rangoInicio == null & $rangoFinal == null){

        if($id == 'Todos'){

            $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->get();
    

            
            echo json_encode($join);
    
    
            }
            else{
 
            $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->get();
    
            
            echo json_encode($join);
    
            }

    }else{
        $rangoFinale = $request->input('rangoFinal');
        $rangoFinal = Carbon::parse($rangoFinale)->addHours(24);

        if($id == 'Todos'){


            $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->get();
    

            echo json_encode($join);
    
    
            }
            else{


            $join = DB::table('servicios')->join('users', 'users.id', '=', 'servicios.id_usuario')->where('servicios.id_usuario', '=', $id)->whereBetween('servicios.fecha_inicio', [$rangoInicio, $rangoFinal])
            ->join('clientes', 'clientes.id', '=', 'servicios.id_cliente')
            ->select('servicios.id as idServicio', 'servicios.id_usuario', 'servicios.id_cliente', 'servicios.referencia', 'servicios.tipo_equipo', 'servicios.tipo_servicio', 'servicios.imagen_inicio', 'servicios.imagen_fin', 'servicios.id_reporte', 'servicios.pdf_reporte', 'servicios.fecha_inicio', 'servicios.fecha_final', 'servicios.status', 'users.*', 'clientes.*')->get();
    

           
            echo json_encode($join);
    
            }

        }

    }
    
    
    public function postdataPos(Request $request)
    {
       
        $myId = Auth::user()->id;
        $long = $request->long;
        $lat = $request->lat;

        $data = User::find($myId);
        $data->long = $long;
        $data->lat = $lat;
        $data->save();   
        
        $options = array(
            'cluster' => 'us3'
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['long' => $long, 'lat' => $lat];
        $pusher->trigger('my-channel2', 'my-event2', $data);
    }


}


