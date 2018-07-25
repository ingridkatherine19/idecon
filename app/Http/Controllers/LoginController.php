<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Auth;
use View;
use App\User;
use Validator;
use App\Modelos\Factura;


class LoginController extends Controller
 {
    
    static public function index() {
        if (Auth::check())  //Verifica si el usuario ya esta logueado
        {
            $user = Auth::user();
			return response()->json(['user'=>true]);
        }else{
            return response()->json(['user'=>false]);
        }

    }

    public function verificarAdmin(Request $request)
    {
        if (Auth::attempt(['email' => $request->correo, 'password' => bcrypt($request->pass)]))
        {
            $user = Auth::user();
            if ($user->tipo == 2) {
                return response()->json(['user'=>true, 'cliente' => $user]);
            }else{
                return response()->json(['user'=>false, 'mensaje' => 'El usuaio no es un administrador']);
            }
                 
        }else{
            //dd(bcrypt($request->pass));
            return response()->json(['user'=>false]);
        }
        
    }
    
    public function verificar(Request $request)
    {
         if (Auth::attempt(['correo' => $request->correo, 'password' => $request->pass]))
            {
            $user = Auth::User();
            return response()->json(['user'=>true, 'usuario' => $user]);     
        }else{
            //dd(bcrypt($request->pass));
            return response()->json(['user'=>false]);
        }
        
    }
    
    public function logout(Request $request)
    {
           Auth::logout(); 
           return redirect('/');     
    }



}
   