<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
   

    public function index(Request $request)
    {

        if (Auth::check())
        {
          $user = Auth::User();
          //dd($user);
          return view('admin.index')->with('user', $user);
        
        }else{
          
          if ($request->has("email")) {
            if (Auth::attempt(['correo' => $request->email, 'password' => $request->password], true))
            {
                    $user = Auth::User();
                    return view('admin.index')->with('user', $user);
                   
            }else{
                 return view('admin.login')->with('mensaje' , 'correo y contraseña incorrectos, por favor inténtelo nuevamente'); 
                //return response()->json(['user'=>false]);
            }
          }else{
             return view('admin.login')->with('mensaje' , ''); 
          }
            

        }
         
 }
public function logout(Request $request){
       Auth::logout();      
       return view('admin.login')->with('mensaje' , '');
}


 public function prueba(Request $request){
    dd($request);
 }
 
}
