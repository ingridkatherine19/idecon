<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\UserEvento;
use Auth;
use DB;

class UsuarioController extends Controller {

    public function allUser(Request $request){
        $usuario = User::all();
        return response()->json(['error'=>false,'usuario' => $usuario]);
    }

    public function create(Request $request) {
        $user = user::where('correo' , $request->correo)->get();
          if (isset($user[0])) {
              return response()->json(['error'=>false,'user' => $user, 'mensaje' => 'El usuario no puede ser almacenado porque ya existe en nuestra base de datos' ]);
          }else{
            $usuario = new user();
            $usuario->nombre = $request->nombre;
            $usuario->apellido = $request->apellido;
            $usuario->cedula = $request->cedula;
            $usuario->tipo = $request->tipo;
            $usuario->correo= $request->correo;
            $usuario->password  = bcrypt($request->contrasena);
            
            $usuario->save();
            //notificacion

            
            return response()->json(['error'=>false,'usuario' => $usuario, 'mensaje' => 'El usuario ha sido creado con exito' ]);
          }
        
    }

    public function createEvento(Request $request) {

          
            $usuario = new userEvento();
            $usuario->nombre = $request->nombre;
            $usuario->correo= $request->correo;
            $usuario->password  = bcrypt($request->contrasena);
            
            $usuario->save();
            
            return response()->json(['error'=>false,'usuario' => $usuario, 'mensaje' => 'El usuario ha sido creado con exito' ]);
          
        
    }


    public function update(Request $request) {
        $user = json_decode($request->user);
        $usuario = user::find($user->idUsuario);
      //  dd($usuario);
        $usuario->nombre = $user->nombre;
        $usuario->apellido = $user->apellido;
        $usuario->cedula = $user->cedula;
        $usuario->correo= $user->correo;
        $usuario->save();
        return response()->json(['error'=>false,'usuario' => $usuario , 'mensaje' =>'El usuario ha sido actualizado con exito']);
    }

    public function delete(Request $request){
        $usuario = user::find($request->idUsuario);
        $usuario->delete();
        return response()->json(['error'=>false,'usuario' => $usuario , 'mensaje' => 'El usuario ha sido eliminado']); 


    }

    public function userUpdate (Request $request){//Update del usuario logeado
        $usuario = user::find($request->idUsuario);
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->cedula = $request->cedula;
        $usuario->correo= $request->correo;
        $usuario->save();
        return response()->json(['error'=>false,'usuario' => $usuario , 'mensaje' =>'Has actualizado tus datos con éxito']);


    }

    public function cambiarcontrasena (Request $request){
        if (Auth::attempt(['correo' => $request->email, 'password' => $request->actual]))
            {
                $usuario = user::find($request->idUsuario);
                $usuario->password  = bcrypt($request->password);
                $usuario->save();
                return response()->json(['error'=>false,'usuario' => $usuario , 'mensaje' =>'Has actualizado su contrasena exitosamente']);
           }else{
                return response()->json(['error'=>true,'mensaje' =>'La contraseña actual no es igual']);
           }
    }

    public function Reestablecer (Request $request){

        $usuario = user::find($request->idUsuario);
        $usuario->password  = bcrypt($usuario->cedula);
        $usuario->save();
        return response()->json(['error'=>false,'usuario' => $usuario , 'mensaje' =>'Has reestablecido exitosamente la contraseña']);

    }
    public function Prueba (Request $request){

        $usuario = user::find($request->idUsuario);
        $usuario->token  = $request->token;
        $usuario->save();
        return response()->json(['error'=>false,'usuario' => $usuario , 'mensaje' =>'Has reestablecido exitosamente la contraseña']);
    }
    public function CambiarSwitch (Request $request){
        $usuario = user::find($request->idUsuario);
        if ($request->valor == 1) {
            if ($usuario->notificacion == 0) {
                $usuario->notificacion = 1;
            }else{
                $usuario->notificacion = 0;
            }
            $usuario->save();
        }else{
            if ($usuario->invitacion == 0) {
                $usuario->invitacion = 1;
            }else{
                $usuario->invitacion = 0;
            }
            $usuario->save();
        }

        return response()->json(['error'=>false,'usuario' => $usuario , 'mensaje' =>'Has reestablecido exitosamente la contraseña']);

    }

}
