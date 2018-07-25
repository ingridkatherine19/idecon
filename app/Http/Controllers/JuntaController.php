<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Junta;
use App\Modelos\Evento;
use App\Modelos\Cargo;
use DB;
use Carbon\Carbon; 

class JuntaController extends Controller {

    public function all(Request $request){
        $junta = Junta::where('idEvento', $request->idEvento)->get();
        $cargos = Cargo::where('idEvento', $request->idEvento)->get();
        return response()->json(['error'=>false,'junta' => $junta, 'cargos' => $cargos]);
    }

    public function count(Request $request){
        $junta = Junta::where('idEvento', $request->idEvento)->count();
        return response()->json(['error'=>false,'junta' => $junta]);
    }

    public function create(Request $request){
        $departamento = json_decode($request->departamento);
        $ciudad = json_decode($request->ciudad);

    	try {
    		$junta = new Junta();
    		$junta->idEvento =  $request->idEvento;
    		$junta->nombre = $request->nombre;
    		$junta->apellido = $request->apellido;
    		$junta->fechaNac = $request->fechaNac;
            $junta->edad = Carbon::parse($request->fechaNac)->age;
    		$junta->sexo = $request->sexo;
            $junta->nivel = $request->nivel;
            $junta->Direccion = $request->Direccion;
            $junta->telefono = $request->telefono;
            $junta->cargo = $request->idCargo;
            $junta->instagram = $request->instagram;
            $junta->facebook = $request->facebook;
            $junta->twitter = $request->twitter;
    		$junta->save();
    		return response()->json(['error'=>false,'junta' => $junta]);
    		
    	} catch (Exception $e) {
    		return response()->json(['error'=>true,'mensaje' => $e]);
    	}

    }

    public function update(Request $request){
    	try {
    		$junta = Junta::find($request->idJunta);
	    	$junta->nombre = $request->nombre;
			$junta->apellido = $request->apellido;
			$junta->fechaNac = $request->fechaNac;
			$junta->sexo = $request->sexo;
            $junta->nivel = $request->nivel;
            $junta->Direccion = $request->Direccion;
            $junta->telefono = $request->telefono;
            $junta->cargo = $request->idCargo;
            $junta->instagram = $request->instagram;
            $junta->facebook = $request->facebook;
            $junta->twitter = $request->twitter;
			$junta->save();
			return response()->json(['error'=>false,'junta' => $junta]);
    	} catch (Exception $e) {
    		return response()->json(['error'=>true,'mensaje' => $e]);
    	}

    	
    }


    public function delete(Request $request){
    	$junta = Junta::find($request->idJunta);
    	$junta->delete();
    	return response()->json(['error'=>false,'junta' => $junta]);
    }

    public function createCargo(Request $request){
        $cargo = new Cargo();
        $cargo->idEvento = $request->idEvento;
        $cargo->nombre = $request->nombre;
        $cargo->save();
        return response()->json(['error'=>false,'cargo' => $cargo]);
    }


}
