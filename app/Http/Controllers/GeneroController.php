<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Genero;
use DB;

class GeneroController extends Controller {

    public function all(Request $request){
        $genero = Genero::all();
        return response()->json(['error'=>false,'genero' => $genero]);
    }

    public function Create(Request $request) {
     
        $genero = new Genero();
        $genero->nombre = $request->nombre;
        $genero->save();
        return response()->json(['error'=>false,'genero' => $genero, 'mensaje' => 'El genero fue insertado con exito' ]);
    }




}
