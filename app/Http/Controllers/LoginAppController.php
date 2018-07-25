<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class LoginAppController extends Controller
{
   

       public function index(Request $request)
    {

        if (Auth::check())
        {
          $user = Auth::User();
          //dd($user);
          return response()->json(['error'=>false,'user' => $user]);
        
        }else{
          
          if ($request->has("correo")) {
            if (Auth::attempt(['correo' => $request->correo, 'password' => $request->password]))
            {
                    $user = Auth::User();
                    return response()->json(['error'=>false,'user' => $user]);
                   
            }else{
                
              return response()->json(['error'=>false,'mensaje' => 'correo y contraseña incorrectos']);
                //return response()->json(['user'=>false]);
            }
          }else{
              return response()->json(['error'=>false,'mensaje' => '']);
          }
            

        }
         
 }
public function logout(Request $request){
    Auth::logout();      
    return response()->json(['error'=>false,'mensaje' => 'Se ha cerrado la sesión']);
}

 
}
