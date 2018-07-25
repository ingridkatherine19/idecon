<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Empresa;
use DB;
use stdClass;

class EmpresaController extends Controller {
/*
 0: Microempresa ;
 1: Pequeñas Empresas; 
 2: Medianas Empresas; 
 3: Grandes Empresas
 */  
    public function all(Request $request){
        $empresa = Empresa::all();
        return response()->json(['error'=>false,'empresa' => $empresa]);
    }
    public function allDepartamento(Request $request){
        $empresa = Empresa::where('departamento' , $request->idDepartamento)->get();
        return response()->json(['error'=>false,'empresa' => $empresa]);
    }

    public function create(Request $request) {
       // dd($request->ciudad);
      //  $ciudad = json_decode($request->ciudad);
        $empresa = Empresa::where('nit' , $request->nit)->get();
          if (isset($empresa[0])) {
              return response()->json(['error'=>false,'empresa' => $empresa, 'mensaje' => 'Ya se encuentra una empresa guardada con ese nit' ]);
          }else{
            $empresa = new Empresa();
            $empresa->nombre = $request->nombre;
            $empresa->nit = $request->nit;
            $empresa->sector = $request->sector;
            $empresa->gerente = $request->gerente;
            $empresa->departamento = $request->departamento;
            $empresa->ciudad = $request->ciudad;
            $empresa->direccion = $request->direccion;
            $empresa->telefono1 = $request->telefono1;
            $empresa->telefono2 = $request->telefono2;
            $empresa->nempleados = $request->nempleados;
            $empresa->cantMujeres = $request->cantMujeres;
            $empresa->cantHombres = $request->cantHombres;
            $empresa->correo = $request->correo;
            $empresa->facebook = $request->facebook;
            $empresa->twitter = $request->twitter;
            $empresa->youtube = $request->youtube;
            $empresa->instagram = $request->instagram;
            $empresa->lat = $request->lat;
            $empresa->lng = $request->lng;
            $empresa->save();

              return response()->json(['error'=>false,'empresa' => $empresa, 'mensaje' => 'La empresa fue registrada exitosamente' ]);
          }
        
    }


    public function update(Request $request) {
    
        $empresa = Empresa::find($request->idEmpresa);
        $empresa->nombre = $request->nombre;
        $empresa->nit = $request->nit;
        $empresa->sector = $request->sector;
        $empresa->gerente = $request->gerente;
        $empresa->telefono1 = $request->telefono1;
        $empresa->telefono2 = $request->telefono2;
        $empresa->correo = $request->correo;
        $empresa->save();
        return response()->json(['error'=>false,'empresa' => $empresa , 'mensaje' =>'La empresa fue actualizada exitosamente']);
    }

    public function delete(Request $request){
        $empresa = Empresa::find($request->idEmpresa);
        $empresa->delete();
        return response()->json(['error'=>false,'empresa' => $empresa , 'mensaje' => 'La empresa ha sido eliminada']); 
   }

   public function ReporteEmpresa (){
   /* 0: Microempresa ; 1: Pequeñas Empresas; 2: Medianas Empresas; 3: Grandes Empresas*/
        $cantPersonas = 0; 
        $cantHombres = 0;
        $cantMujeres = 0;
        $promMujeres = 0;
        $promHombres = 0;
        $cantEmpresas = Empresa::count();
        $reporte = new stdClass();
        $empresas = Empresa::all();
        $sectorArray = array();
        foreach ($empresas as $empresa) {
          
            $cantPersonas += $empresa->nempleados;
            $cantHombres += $empresa->cantHombres;
            $cantMujeres += $empresa->cantMujeres;
            $promHombres = ($cantHombres*100)/$cantPersonas;
            $promMujeres = ($cantMujeres*100)/$cantPersonas;
        }

        $microempresa = Empresa::where('sector', 0)->count();
        $promMicro = ($microempresa * 100)/ $cantEmpresas;
        
        $pequenaEmpresa = Empresa::where('sector', 1)->count();
        $promPequena = ($pequenaEmpresa * 100)/ $cantEmpresas;
        $medianaEmpresa = Empresa::where('sector', 2)->count();
        $promMediana = ($medianaEmpresa * 100)/ $cantEmpresas;
        $grandeEmpresa = Empresa::where('sector', 3)->count();
        $promGrande = ($grandeEmpresa * 100)/ $cantEmpresas;
        if ($microempresa != 0) {

            $obj =  new stdClass();
             $obj->numero = 0;
             $obj->nombre = 'Microempresa';
             $obj->cantidad = $microempresa;
             $obj->promedio = $promMicro;
             $obj->color = '#3c8dbc'; 
             array_push($sectorArray, $obj);

        }
        if ($pequenaEmpresa != 0) {
             $obj =  new stdClass();
             $obj->numero = 1;
             $obj->nombre = 'Pequeña Empresa';
             $obj->cantidad = $pequenaEmpresa;
             $obj->promedio = $promPequena; 
             $obj->color = '#00a65a'; 
             array_push($sectorArray, $obj);
        }

        if ($medianaEmpresa != 0) {
             $obj =  new stdClass();
             $obj->numero = 2;
             $obj->nombre = 'Mediana Empresa';
             $obj->cantidad = $medianaEmpresa;
             $obj->promedio = $promMediana; 
             $obj->color = '#D81B60';
             array_push($sectorArray, $obj);
        }
        if ($medianaEmpresa != 0) {
            $obj =  new stdClass();
             $obj->numero = 3;
             $obj->nombre = 'Grande Empresa';
             $obj->cantidad = $grandeEmpresa;
             $obj->promedio = $promGrande; 
             $obj->color = '#605ca8';
             array_push($sectorArray, $obj);
        }

        $reporte->cantPersonas = $cantPersonas;
        $reporte->cantHombres = $cantHombres;
        $reporte->cantMujeres = $cantMujeres;
        $reporte->promHombres = $promHombres;
        $reporte->promMujeres = $promMujeres;
        $reporte->cantEmpresas = $cantEmpresas;


        return response()->json(['error'=>false,'reporte' => $reporte , 'sectorArray' => $sectorArray]);


   }


}
