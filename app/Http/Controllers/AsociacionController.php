<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\SubParticipa;
use App\Modelos\Actividad;
use App\Modelos\EventoActividad;
use App\Modelos\Premio;
use App\Modelos\Participante;
use App\Modelos\Actividadagrupacion;
use App\Modelos\Actividadempresa;
use App\Modelos\Actividadparticipante;
use App\Modelos\Agrupacion;
use App\Modelos\Empresa;
use stdClass;
use DB;

class AsociacionController extends Controller {

    public function all(Request $request){
         $actividades = Actividad::where('idEvento', $request->idEvento)->get();
         foreach ($actividades as $act) {
            $subactividad = EventoActividad::where('idActividad', $act->idActividad)->get();
            $premio = Premio::where('idActividad' , $act->idActividad)->get();
            $act->subactividad = $subactividad;
            $act->premios = $premio;
         }

        return response()->json(['error'=>false,'actividades' => $actividades]);
    }
    public function desasociar (Request $request){
        $act = json_decode($request->actividad);
         
        if ($request->tipo == 0) {
            $asociacion = Actividadparticipante::find($request->id);
            $asociacion->delete();
            return response()->json(['error'=>false,'asociacion' => $asociacion , 'mensaje' => 'Se ha eliminado a asociación correctamente']); 
        }elseif ($request->tipo == 1) {
            $asociacion = Actividadempresa::find($request->id);
            $asociacion->delete();
            return response()->json(['error'=>false,'asociacion' => $asociacion , 'mensaje' => 'Se ha eliminado a asociación correctamente']); 
        }elseif ($request->tipo == 2) {
            $asociacion = Actividadagrupacion::find($request->id);
            $asociacion->delete();
            return response()->json(['error'=>false,'asociacion' => $asociacion , 'mensaje' => 'Se ha eliminado a asociación correctamente']); 
        }

    }

    public function buscarAsociar (Request $request){//Busca los que no están asociados

        $participantesArray = array();
        $empresasArray = array();
        $agrupacionesArray = array();
        $act = json_decode($request->actividad);

            //Busca a los participantes
            $participante = Participante::all();    
            foreach ($participante as $p ) {//Recorre a los participantes
               
                $existe = Actividadparticipante::where('idParticipante' , $p->idParticipante)->where('idActividad' , $act->idActividad)->get(); //Verifica si ya estan asociados
                if (count($existe) == 0) {//Si no estan asociados los guarda en el arreglo
                    array_push($participantesArray , $p);
                }
            }

            //Busca a las empresas          
            $empresa =  Empresa::all();
            foreach ($empresa as $e ) {//recorre a las empresas
                $existe = Actividadempresa::where('idEmpresa' , $e->idEmpresa)->where('idActividad' , $act->idActividad)->get();//Verifica que no esten asociados
                if (count($existe) == 0) {//Si no estan asociados los guarda en el arreglo
                    array_push($empresasArray , $e);
                
                }

            }

            //Busca a todas las agrupaciones
            $agrupacion =  Agrupacion::all();
            foreach ($agrupacion as $a ) {
                $existe = Actividadagrupacion::where( 'idAgrupacion' , $a->idAgrupacion)->where('idActividad' , $act->idActividad)->get();//Verifica que no esten asociados
                if (count($existe) == 0) {//Si no estan asociados los guarda en el arreglo
                  array_push($agrupacionesArray , $a);
                }
            }
        
        return response()->json(['error'=>false,'participantes' => $participantesArray , 'empresas' => $empresasArray , 'agrupaciones' => $agrupacionesArray]);
    }

    public function all2 (Request $request){//Esta función busca a los participantes o a las empresas o a las agrupaciones que ya están asociadas a la actividad.
     //   dd($request->actividad , $request->tipo);
        $mensaje = '';
        $act = json_decode($request->actividad);
        $participantesArray = array();
        $empresasArray = array();
        $agrupacionesArray = array();
        
        $participantes = Actividadparticipante::where('idActividad', $act->idActividad)->get();//Busca a los participantes que esten asociados
            if (isset($participantes[0])) {//Verifica que traiga algo
               if(count($participantes) == 1){//Si hay uno sólo
                    $participante = Participante::where('idParticipante' , $participantes[0]->idParticipante)->get();//Se busca el participante en la tabla de participante para devolverlo
                    $participante[0]->idAsociacion = $participantes[0]->id;
                   array_push($participantesArray , $participante[0]);  //Se asigna la asociacion
               }else{
                foreach ($participantes as $p) {//Si hay varios registros
                    $participante = Participante::where('idParticipante' , $p->idParticipante)->get();//Se busca a los participantes y se asigna en la asociacion
                    $participante[0]->idAsociacion = $p->id; 
                    array_push($participantesArray , $participante[0]);               
                }
               }
            
            }else{
                $mensaje = '"No hay Participantes asociados"';

            }

            $empresas = Actividadempresa::where('idActividad', $act->idActividad)->get();
            if (isset($empresas[0])) {
                if(count($empresas) == 1){
                    $empresa = Empresa::where('idEmpresa' , $empresas[0]->idEmpresa)->get();
                    $empresa[0]->idAsociacion = $empresas[0]->id;
                    array_push($empresasArray , $empresa[0]);
               }else{
                foreach ($empresas as $e) {
                    $empresa = Empresa::where('idEmpresa' , $e->idEmpresa)->get();
                    $empresa[0]->idAsociacion = $e->id;
                    array_push($empresasArray , $empresa[0]);                   
                }
               }
            }else{
                $mensaje = '"No hay Empresas asociadas"';
            }
            $agrupaciones = Actividadagrupacion::where('idActividad', $act->idActividad)->get();
            if (isset($agrupaciones[0])) {
                if(count($agrupaciones) == 1){

                    $agrupacion = Agrupacion::where('idAgrupacion' , $agrupaciones[0]->idAgrupacion)->get();
                    $agrupacion[0]->idAsociacion = $agrupaciones[0]->id;
                    array_push($agrupacionesArray , $agrupacion[0]);
               }else{
                foreach ($agrupaciones as $a) {
                    $agrupacion = Agrupacion::where('idAgrupacion' , $a->idAgrupacion)->get();
                    $agrupacion[0]->idAsociacion = $a->id;
                    array_push($agrupacionesArray , $agrupacion[0]);                 
                }
               }
            }else{
                $mensaje = '"No hay Agrupaciones asociadas"';
            }
        
  
        return response()->json(['error'=>false,'participantes' => $participantesArray , 'empresas' => $empresasArray ,  'agrupaciones' => $agrupacionesArray , 'mensaje' => $mensaje]);
    }
    public function buscarPremio (Request $request){
        
        $premios = Premio::where('idActividad' , $request->idActividad)->get();
        return response()->json(['error'=>false,'premios' => $premios ]);
    }
    public function buscarPremiado (Request $request){
        $actividad = json_decode($request->actividad);

        if ($actividad->tipoPoblacion == 0) {
            $resultado = Participante::all();
            $resultado->tipoPoblacion = 0;
        }elseif ($actividad->tipoPoblacion == 1) {
            $resultado = Empresa::all();
            $resultado->tipoPoblacion = 1;
        }elseif ($actividad->tipoPoblacion == 2) {
            $resultado = Agrupacion::all();
            $resultado->tipoPoblacion = 2;
        }
        return response()->json(['error'=>false,'resultado' => $resultado]);
    }
    public function guardarPremiado (Request $request) {
        $actividad = json_decode($request->actividad);
        $premio = json_decode($request->premio);
        $persona = json_decode($request->persona);
       if ($persona->idParticipante) {
            $editado = Premio::where('idPremio' , $premio->idPremio)->where('idActividad' , $actividad->idActividad)->get();
            $editado[0]->idParticipante = $persona->idParticipante;
            $editado[0]->tipoParticipante = 0;
            $editado[0]->save();
       }elseif ($persona->idEmpresa) {
           $editado = Premio::where('idPremio' , $premio->idPremio)->where('idActividad' , $actividad->idActividad)->get();
            $editado[0]->idParticipante = $persona->idEmpresa;
            $editado[0]->tipoParticipante = 1;
            $editado[0]->save();
       }elseif ($persona->idAgrupacion) {
            $editado = Premio::where('idPremio' , $premio->idPremio)->where('idActividad' , $actividad->idActividad)->get();
            $editado[0]->idParticipante = $persona->idAgrupacion;
            $editado[0]->tipoParticipante = 2;
            $editado[0]->save();
       }
   
       return response()->json(['error'=>false,'mensaje' => 'Fue asignado un ganador con exito']);
        
    }
    public function nuevoAsociar (Request $request) {
        $actividad = json_decode($request->actividad);
        $nuevo = json_decode($request->nuevo);
    
        if ($request->tipo == 0 ) {
            $datos = new Actividadparticipante();
            $datos->idParticipante = $nuevo->idParticipante;
            $datos->idActividad = $actividad->idActividad;
            $datos->save();
        }elseif ($request->tipo == 1) {
            $datos = new Actividadempresa();
            $datos->idEmpresa = $nuevo->idEmpresa;
            $datos->idActividad = $actividad->idActividad;
            $datos->save();
        }elseif ($request->tipo == 2) {
            $datos = new Actividadagrupacion();
            $datos->idAgrupacion = $nuevo->idAgrupacion;
            $datos->idActividad = $actividad->idActividad;
            $datos->save();
        }
        return response()->json(['error'=>false,'mensaje' => 'La asociación fue realizada con éxito']);
    }
    public function Asociar (Request $request) {

        $participante = json_decode($request->participante);
        $actividad = json_decode($request->actividad);
        $subparticipa = SubParticipa::where('idAsociacion' , $actividad->idActividad)->where('idParticipante', $participante->idParticipante)->where('tipo' , $request->tipo)->get();
        if (isset($subparticipa[0])) {
            return response()->json(['error'=>false,'mensaje' => 'Ya existe']);
        }else{
            $datos = new SubParticipa();
            $datos->idAsociacion = $actividad->idActividad;
            $datos->idParticipante = $participante->idParticipante;
            $datos->tipoParticipante = $participante->tipo;
            $datos->tipo = $request->tipo;
            $datos->save();
            return response()->json(['error'=>false,'mensaje' => 'La asociación fue realizada con éxito']);
        }

    }
    public function Allsub () {

        $asociaciones = SubParticipa::all();
        foreach ($asociaciones as $a) {
            $participante = Participante::where('idParticipante' , $a->idParticipante)->get();
                $a->nombre = $participante[0]->nombre;
                $a->apellido = $participante[0]->apellido;
                $a->cedula = $participante[0]->cedula;
        }
        return response()->json(['error'=>false,'participantesA' => $asociaciones]);
    }

    public function Delete(Request $request){

        $asociacion = SubParticipa::find($request->idParticipa);
        $asociacion->delete();
        return response()->json(['error'=>false,'asociacion' => $asociacion , 'mensaje' => 'Se ha eliminado a asociación correctamente  ']); 

    }


}
