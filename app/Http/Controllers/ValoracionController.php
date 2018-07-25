<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Valoracionevento;
use DB;
use stdClass;

class ValoracionController extends Controller {

    public function create(Request $request){
    	try {
            $verificar = Valoracionevento::where('idEvento' , $request->idEvento)->where('idPersona' , $request->idUsuario)->get();
            if (count($verificar) == 0) {
                $valoracion = new Valoracionevento();
                $valoracion->idEvento = $request->idEvento; 
                $valoracion->valor = $request->valor;
                $valoracion->idPersona = $request->idUsuario;
                $valoracion->tipoPersona = $request->tipoPersona; 
                $valoracion->save();
                return response()->json(['error'=>false,'valoracion' => $valoracion]);
            }else{
                $verificar[0]->idEvento = $request->idEvento; 
                $verificar[0]->valor = $request->valor;
                $verificar[0]->idPersona = $request->idUsuario;
                $verificar[0]->tipoPersona = $request->tipoPersona; 
                $verificar[0]->save();
                return response()->json(['error'=>false,'valoracion' => $verificar]);
            }
    	} catch (Exception $e) {
    		return response()->json(['error'=>true,'mensaje' => $e]);
    	}

    }

    public function Buscar(Request $request){
        $valoracion = Valoracionevento::where('idEvento' , $request->idEvento)->where('idPersona' , $request->idUsuario)->get();
        return response()->json(['error'=>false,'valoracion' => $valoracion]);
    }

    public function Promedio(Request $request){
        $valoracion = Valoracionevento::where('idEvento' , $request->idEvento)->sum('valor');
    
        return response()->json(['error'=>false,'valoracion' => $valoracion]);
    }

}
