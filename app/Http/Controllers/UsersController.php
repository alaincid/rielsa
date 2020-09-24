<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;


class UsersController extends Controller
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

        return view('pages/usuarios', ['userss'=>$userss], ['users'=>$users]);
    }

    function getdata()
        {
        $usuarios = User::select('id','name', 'email', 'telefono', 'rol');
        return DataTables::of($usuarios)
           ->addColumn('action', function($usuario){
               return '<a href="#" class="btn btn-xs btn-editarServicio edit" id="'.$usuario->id.'"><img src="/img/editar.svg" width="24px" height="24px"></a><a href="#" class="btn btn-xs btn-editarServicioDanger delete" id="'.$usuario->id.'"><img src="/img/eliminar.svg" width="24px" height="24px"></a>';
           })
           ->make(true);
       }

       function postdata(Request $request)
       {
           $validation = Validator::make($request->all(), [
               'name' => 'required',
               'email'  => 'required',
               'telefono'  => 'required',
               'rol'  => 'required',
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
                   $usuario = User::find($request->get('usuario_id'));
                   $usuario->name = $request->get('name');
                   $usuario->email = $request->get('email');
                   $usuario->telefono = $request->get('telefono');
                   $usuario->rol = $request->get('rol');
                   $usuario->save();
                   $success_output = '<div class="alertaTables alert alert-success">Usuario Actualizado</div>';
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
           $usuario = User::find($id);
           $output = array(
               'name' => $usuario->name,
               'email' => $usuario->email,
               'telefono' => $usuario->telefono,
               'rol' => $usuario->rol
           );
           echo json_encode($output);
       }


       function removedata(Request $request)
       {
           $usuario = User::find($request->input('id'));
           if($usuario->delete()){
               echo 'Usuario eliminado';
           }
       }


}
