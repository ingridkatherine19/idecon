<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Departamento;
use App\Modelos\Evento;
use DB;
use stdClass;

class DepartamentoController extends Controller {

    public function all(Request $request){
        $departamentos = Departamento::all();
        return response()->json(['error'=>false,'departamentos' => $departamentos]);
    }

  	public function Buscar(Request $request){
  		$departamentos = array();
        $eventos = Evento::all();
 

        foreach ($eventos as $e) {
        	$aux = false;
            $departamento = Departamento::find($e->idDepartamento);	
        	
			if (count($departamentos) == 0) {
				array_push($departamentos, $departamento);
			}else{
				foreach ($departamentos as $ds) {
					if ($departamento->idDepartamento == $ds->idDepartamento) {
						$aux = true;
					}
				}
                if ($aux == false) {
                   array_push($departamentos, $departamento);
                }
				
			}
		
        }
        return response()->json(['error'=>false,'departamentos' => $departamentos]);
    }


}
