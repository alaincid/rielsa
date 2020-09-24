<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Clientes;
use DataTables;
use DB;


class ClientesController extends Controller
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

        return view('pages/clientes', ['userss'=>$userss], ['users'=>$users]);
    }

    function getdata()
    {
     $clientes = Clientes::select('id','nombre_cliente', 'rfc_cliente', 'direccion_cliente', 'telefono_cliente', 'email_cliente');
     return DataTables::of($clientes)
        ->addColumn('action', function($cliente){
            return '<a href="#" class="btn btn-xs btn-editarServicio edit" id="'.$cliente->id.'"><img src="/img/editar.svg" width="24px" height="24px"></a><a href="#" class="btn btn-xs btn-editarServicioDanger delete" id="'.$cliente->id.'"><img src="/img/eliminar.svg" width="24px" height="24px"></a>';
        })
        ->make(true);
    }

    function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nombre_cliente' => 'required',
            'rfc_cliente'  => 'required',
            'direccion_cliente'  => 'required',
            'telefono_cliente'  => 'required',
            'email_cliente'  => 'required',
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
                $cliente = new Clientes([
                    'nombre_cliente'    =>  $request->get('nombre_cliente'),
                    'rfc_cliente'    =>  $request->get('rfc_cliente'),
                    'direccion_cliente'    =>  $request->get('direccion_cliente'),
                    'telefono_cliente'    =>  $request->get('telefono_cliente'),
                    'email_cliente'    =>  $request->get('email_cliente'),
                ]);
                $cliente->save();
                $success_output = '<div class="alertaTables alert alert-success">Cliente Añadido</div>';
            }

            if($request->get('button_action') == 'update')
            {
                $cliente = Clientes::find($request->get('cliente_id'));
                $cliente->nombre_cliente = $request->get('nombre_cliente');
                $cliente->rfc_cliente = $request->get('rfc_cliente');
                $cliente->direccion_cliente = $request->get('direccion_cliente');
                $cliente->telefono_cliente = $request->get('telefono_cliente');
                $cliente->email_cliente = $request->get('email_cliente');
                $cliente->save();
                $success_output = '<div class="alertaTables alert alert-success">Cliente Actualizado</div>';
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
        $cliente = Clientes::find($id);
        $output = array(
            'nombre_cliente' => $cliente->nombre_cliente,
            'rfc_cliente' => $cliente->rfc_cliente,
            'direccion_cliente' => $cliente->direccion_cliente,
            'telefono_cliente' => $cliente->telefono_cliente,
            'email_cliente' => $cliente->email_cliente
        );
        echo json_encode($output);
    }

    function removedata(Request $request)
    {
        $cliente = Clientes::find($request->input('id'));
        if($cliente->delete()){
            echo 'Cliente eliminado';
        }
    }

}


