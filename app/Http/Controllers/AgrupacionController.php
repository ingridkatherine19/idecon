<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Agrupacion;
use App\Modelos\Departamento;
use App\Modelos\Ciudad;
use App\Modelos\Genero;
use DB;
use stdClass;

class AgrupacionController extends Controller {

    

    public function all(Request $request){
        $agrupacion = Agrupacion::all();
        foreach ($agrupacion as $a) {
            $departamento = Departamento::find($a->departamento);
            $a->nombreDep = $departamento->nombre;
            $ciudad = Ciudad::find($a->ciudad);
            $a->nombreCiudad = $ciudad->nombre;
            $genero = Genero::find($a->genero);
            $a->nombreGenero = $genero->nombre;
        }

       return response()->json(['error'=>false,'agrupacion' => $agrupacion]);
    }

    public function allDepartamento(Request $request){
        $agrupacion = Agrupacion::where('departamento', $request->idDepartamento)->get();

        if (isset($agrupacion[0])) {
            foreach ($agrupacion as $a) {
                $departamento = Departamento::find($a->departamento);
                $a->nombreDep = $departamento->nombre;
                $ciudad = Ciudad::find($a->ciudad);
                $a->nombreCiudad = $ciudad->nombre;
                $genero = Genero::find($a->genero);
                $a->nombreGenero = $genero->nombre;
            }

            return response()->json(['error'=>false,'agrupacion' => $agrupacion]);
        }else{
            return response()->json(['error'=>false,'agrupacion' => []]);
        }
    }
    
    public function Create(Request $request) {

        $agrupacion = new Agrupacion();
        $agrupacion->nombre = $request->nombre;
        $agrupacion->representante = $request->representante;
        $agrupacion->nit = $request->nit;
        $agrupacion->departamento = $request->departamento;
        $agrupacion->ciudad = $request->ciudad ;
        $agrupacion->region = $request->region;
        $agrupacion->direccion = $request->direccion;
        $agrupacion->telefono = $request->telefono;
        $agrupacion->telefono2 = $request->telefono2;
        $agrupacion->nempleados = $request->nempleados;
        $agrupacion->cantMujeres = $request->cantMujeres;
        $agrupacion->cantHombres = $request->cantHombres;
        $agrupacion->correo = $request->email;
        $agrupacion->facebook = $request->facebook;
        $agrupacion->twitter = $request->twitter;
        $agrupacion->instagram = $request->instagram;
        $agrupacion->youtube = $request->youtube;
        $agrupacion->genero = $request->genero;
        $agrupacion->lat = $request->lat;
        $agrupacion->lng = $request->lng;
        $agrupacion->save();

        return response()->json(['error'=>false,'agrupacion' => $agrupacion, 'mensaje' => 'La agrupacion fue registrada con éxito' ]);
    }

    public function Update(Request $request) {
        

        $agrupacion = Agrupacion::find($request->idAgrupacion);
        $agrupacion->nombre = $request->nombre;
        $agrupacion->representante = $request->representante;
        $agrupacion->nit = $request->nit;
        $agrupacion->departamento = $request->departamento;
        $agrupacion->ciudad = $request->ciudad;
        $agrupacion->region = $request->region;
        $agrupacion->direccion = $request->direccion;
        $agrupacion->telefono = $request->telefono;
        $agrupacion->telefono2 = $request->telefono2;
        $agrupacion->nempleados = $request->nempleados;
        $agrupacion->cantMujeres = $request->cantMujeres;
        $agrupacion->cantHombres = $request->cantHombres;
        $agrupacion->correo = $request->email;
        $agrupacion->facebook = $request->facebook;
        $agrupacion->twitter = $request->twitter;
        $agrupacion->instagram = $request->instagram;
        $agrupacion->youtube = $request->youtube;
        $agrupacion->genero = $request->genero;
        $agrupacion->save();
        return response()->json(['error'=>false,'agrupacion' => $agrupacion , 'mensaje' =>'La agrupacion fue actualizada con exito']);
    }

    public function Delete(Request $request){
        $agrupacion = Agrupacion::find($request->idAgrupacion);
        $agrupacion->delete();
        return response()->json(['error'=>false,'agrupacion' => $agrupacion , 'mensaje' => 'La agrupacion ha sido eliminada con exito']); 
    }

    public function ReporteGrupo (Request $request){
        $agrupaciones = Agrupacion::all();
        $cantGenero = Genero::count();
        $genero = Genero::all();
        $cantPersonas = 0;
        $cantHombres = 0;
        $cantMujeres = 0;
        $reporte = new stdClass();
        foreach ($agrupaciones as $agrupacion) {
            
            $cantPersonas += $agrupacion->nempleados;
            $cantHombres += $agrupacion->cantHombres;
            $cantMujeres+= $agrupacion->cantMujeres;
            $promHombres = ($cantHombres*100)/$cantPersonas;
            $promMujeres = ($cantMujeres*100)/$cantPersonas;

        }

        $reporte->cantPersonas = $cantPersonas;
        $reporte->cantHombres = $cantHombres;
        $reporte->cantMujeres = $cantMujeres;
        $reporte->promHombres = $promHombres;
        $reporte->promMujeres = $promMujeres;
        foreach ($genero as $g) {

            $cant = Agrupacion::where('genero' , $g->idGenero)->count();
            if ($cant != 0) {
                $g->cant = $cant; 
                $g->prom = ($cant*100)/$cantGenero;
            }else{
                $g->cant = 0;
                $g->prom = 0;
            }
        }
        return response()->json(['error'=>false,'reporte' => $reporte , 'genero' => $genero]); 
    }



    


}
