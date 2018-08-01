<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Actividad;
use App\Modelos\EventoActividad;
use App\Modelos\Palco;
use App\Modelos\Premio;
use App\Modelos\DireccionActividad;
use App\Modelos\DireccionSub;
use App\Modelos\PalcoSub;
use App\Modelos\Colormodalidad;
use DB;
use stdClass;
use Carbon\Carbon;

class ActividadController extends Controller {

    public function all(Request $request){
        $actividad = Actividad::where('idEvento', $request->idEvento)->get();
        foreach ($actividad as $act) {
            if ($act->lugar == 1) {//mismo lugar
                //calcula aforo
                $act->palco = Palco::where('idActividad', $act->idActividad)->get();
                $act->direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();   
            }
            if ($act->premio == 1) {
                $act->premioD = Premio::where('idActividad', $act->idActividad)->get();
            }
        }
        return response()->json(['error'=>false,'actividad' => $actividad]);
    }
    
    //trae todo los datos de las actividades del evento
    public function reporte(Request $request){
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        $cantidadAct = count($actividades);
        $cantidadSub = 0;
        $aforo = 0;
        $horas = 0;
        $empleo = 0;
        foreach ($actividades as $act) {
            $empleo += $act->empleo;
            $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
            //sumar la cantidad de subactividades de todo el evento
            $cantidadSub += count($sub);
            //calcular el aforo total y horas de entretenimiento
            if ($act->lugar == 1) {//mismo lugar
                //calcula aforo
                $palco = Palco::where('idActividad', $act->idActividad)->get();
                foreach ($palco as $p) {
                    $aforo += $p->capacidad;
                }

                //calcula hora
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $inicio = new Carbon($direccion[0]->fechaInicio);
                $fin = new Carbon($direccion[0]->fechaFin);
                $horas += $inicio->diffInHours($fin);
                //dd($interval);
            }else{//diferentes lugares (buscar en cada sub actividad)
                foreach ($sub as $s) {
                    //calcula aforo
                    $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                    foreach ($palco as $p) {
                        $aforo += $p->capacidad;
                    }

                    //calcula horas
                    $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horas += $inicio->diffInHours($fin);
                    
                }
            } 
        }
        $total = new stdClass();
        $total->cantidad = $cantidadAct;
        $total->cantidadSub = $cantidadSub;
        $total->aforo = $aforo;
        $total->horas = $horas;
        $total->empleo = $empleo;
        return response()->json(['error'=>false, 'total' =>$total]);
    }
    public function Create(Request $request) {
    
   // dd($request->fechaInicio , $request->fechaFin , $request->actividad);
    $actividadN = json_decode($request->actividad);
    
   // dd($actividadN , $request->fechaInicio , $request->fechaFin);
        $actividad = new Actividad();
        $actividad->idEvento = $actividadN->idEvento;
        //$actividad->modalidad = $actividadN->modalidad;
        //$actividad->tipo = $actividadN->tipo;
        $actividad->nombre = $actividadN->nombre;
        $actividad->responsable = $actividadN->responsable;
        $actividad->costo = 0;
        //$actividad->premio = $actividadN->p;
        $actividad->lugar = $actividadN->lugar;
        $actividad->empleo = $actividadN->empleo;
        $actividad->cantHombres = $actividadN->cantHombres;
        $actividad->cantMujeres = $actividadN->cantMujeres;
        $actividad->modalidad = (int)$actividadN->modalidad;
        //$actividad->poblacion = $actividadN->poblacion;
        //$actividad->tipoPoblacion = $actividadN->tipoPoblacion;
        $actividad->save();

        if ($actividad->lugar == 1) {//que la actividad va a ser en el mismo lugar necesita palcos y direccion

            //DIRECCION
            $direccion = new DireccionActividad();
            $direccion->idActividad = $actividad->idActividad;
            $direccion->direccion = $actividadN->direccion;
            $direccion->fechaInicio = $request->fechaInicio;
            $direccion->fechaFin = $request->fechaFin;
            $direccion->lat = $actividadN->lat;
            $direccion->lng = $actividadN->lng;
            $direccion->save();

            //PALCOS
            $palcoD = json_decode($actividadN->palco);
            
            foreach ($palcoD as $p) {
                $palco = new Palco();
                $palco->idActividad = $actividad->idActividad;
                $palco->detalle = $p->detalle;
                $palco->capacidad = $p->capacidad;
                $palco->costo = $p->cu;
                $palco->save();
            }
            
        }

        if ($actividad->premio == 1) {//que tiene premiacion la actividad
            
            //PREMIO
            $premioD = json_decode($actividadN->premio);
            foreach ($premioD as $pr) {
                # code...
                $premio = new Premio();
                $premio->idActividad = $actividad->idActividad;
                $premio->detalle = $pr->detalle;
                $premio->costo = $pr->costo;//valor del premio
                $premio->save();
            }
        }


        return response()->json(['error'=>false,'actividad' => $actividad, 'mensaje' => 'La actividad fue registrada con éxito' ]);
    }

    public function subActividades (Request $request){

        //buscar la actividad a ver si es en el mismo lugar o en diferentes lugares
        $act = Actividad::find($request->idActividad);
        if ($act->lugar == 1) {//mismo lugar
            $actividades = EventoActividad::where('idActividad', $request->idActividad)->get();
        }else{//diferntes  lugares
            $actividades = EventoActividad::where('idActividad', $request->idActividad)->get();
            foreach ($actividades as $a) {
                $direccion = DireccionSub::where('idActividad', $a->idEventoActividad)->get();
                $palco = PalcoSub::where('idActividad', $a->idEventoActividad)->get();
                $a->direccion = $direccion[0];
                $a->palco = $palco;
            }
        }
        
        return response()->json(['error'=>false,'actividad' => $actividades, 'mensaje' => 'La actividad fue registrada con éxito' ]);
    }
    
    public function AgregarPalco(Request $request){
    	//PALCOS
        $palco = json_decode($request->palco);
        
        foreach ($palco as $p) {
            $palco = new Palco();
            $palco->idActividad = $request->idActividad;
            $palco->detalle = $p->detalle;
            $palco->capacidad = $p->capacidad;
            $palco->costo = $p->cu;
            $palco->save();
        }    

        return response()->json(['error'=>false,'palco' => $palco, 'mensaje' => 'El palco fue registrada con éxito' ]);
    }
    
    public function AgregarPalcoSub(Request $request){
        //PALCOS
        $palco = json_decode($request->palco);
        
        foreach ($palco as $p) {
            $palco = new PalcoSub();
            $palco->idActividad = $request->idActividad;
            $palco->detalle = $p->detalle;
            $palco->capacidad = $p->capacidad;
            $palco->costo = $p->cu;
            $palco->save();
        }    

        return response()->json(['error'=>false,'palco' => $palco, 'mensaje' => 'El palco fue registrada con éxito' ]);
    }

    public function actCalendario(Request $request){
        //trae las actividades que se van a pintar en el calendario
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        $calendario = array();
        //solo las que tienen direcciones se mostraran en el calendario
        foreach ($actividades as $act) {
            $color = Colormodalidad::where('idModalidad', 0)->get();
            if ($act->lugar == 1) {//la actividad tiene una direcion
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $act->direccion = $direccion;
                $act->color = $color[0]->color;
                array_push($calendario, $act);
            }else{//las sub actividades tienen una direccion
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                foreach ($sub as $act) {
                    $direccion = DireccionSub::where('idActividad', $act->idEventoActividad)->get();
                    $act->direccion = $direccion;
                $act->color = $color[0]->color;
                    array_push($calendario, $act);
                }
            }
        }
      
        return response()->json(['error'=>false,'calendario' => $calendario, 'mensaje' => 'La actividad fue registrada con éxito' ]);   
    }

    public function createSub(Request $request){
        
        $sub = json_decode($request->sub);
        $actividad = new EventoActividad();
        $actividad->idActividad = $sub->idActividad;
        $actividad->nombre = $sub->nombre;
        $actividad->modalidad = $sub->modalidad;
        $actividad->tipo = $sub->tipo;
        $actividad->tipoPoblacion = $sub->tipoPoblacion;
        $actividad->cantidad = $sub->cantidad;
        $actividad->save();

        if ($sub->lugar == 0) {//entonces tiene direccion y palcos
            //DIRECCION
            $direccion = new DireccionSub();
            $direccion->idActividad = $actividad->idEventoActividad;
            $direccion->direccion = $sub->direccion;
            $direccion->fechaInicio = $request->fechaInicio;
            $direccion->fechaFin = $request->fechaFin;
            $direccion->lat = $sub->lat;
            $direccion->lng = $sub->lng;
            $direccion->save();

            //PALCOS
            $palcoD = json_decode($sub->palco);
            
            foreach ($palcoD as $p) {
                $palco = new PalcoSub();
                $palco->idActividad = $actividad->idEventoActividad;
                $palco->detalle = $p->detalle;
                $palco->capacidad = $p->capacidad;
                $palco->costo = $p->cu;
                $palco->save();
            }
           
        }

        return response()->json(['error'=>false,'actividad' => $actividad, 'mensaje' => 'La actividad fue registrada con éxito' ]);
    }

    public function Update(Request $request) {
        $actividadN = json_decode($request->actividad);

        $actividad = Actividad::find($actividadN->idActividad);

        //$actividad->modalidad = $actividadN->modalidad;
        //$actividad->tipo = $actividadN->tipo;
        $actividad->nombre = $actividadN->nombre;
        $actividad->responsable = $actividadN->responsable;
        $actividad->costo = $actividadN->costo;
        //$actividad->premio = $actividadN->premio;
        $actividad->lugar = $actividadN->lugar;
        $actividad->empleo = $actividadN->empleo;
        $actividad->cantHombres = $actividadN->cantHombres;
        $actividad->cantMujeres = $actividadN->cantMujeres;
        //$actividad->poblacion = $actividadN->poblacion;
        //$actividad->tipoPoblacion = $actividadN->tipoPoblacion;
        $actividad->save();

        if ($actividad->lugar == 1) {//que la actividad va a ser en el mismo lugar necesita palcos y direccion

            //DIRECCION
            $direccion = DireccionActividad::find($actividadN->direccion[0]->idDireccion);
            $direccion->direccion = $actividadN->direccion[0]->direccion;
            $direccion->fechaInicio = $actividadN->direccion[0]->fechaInicio;
            $direccion->fechaFin = $actividadN->direccion[0]->fechaFin;
            $direccion->save();

            //PALCOS
            $palcoD = $actividadN->palco;
            
            foreach ($palcoD as $p) {
                $palco = Palco::find($p->idPalco);
                $palco->detalle = $p->detalle;
                $palco->capacidad = $p->capacidad;
                $palco->costo = $p->costo;
                $palco->save();
            }
            
        }

        if ($actividad->premio == 1) {//que tiene premiacion la actividad
            
            //PREMIO
            $premioD = $actividadN->premioD;
            foreach ($premioD as $pr) {
                # code...
                $premio =Premio::find($pr->idPremio);
                $premio->detalle = $pr->detalle;
                $premio->costo = $pr->costo;//valor del premio
                $premio->save();
            }
        }
        return response()->json(['error'=>false,'actividad' => $actividad , 'mensaje' =>'La actividad fue actualizada con exito']);
    }

    public function UpdateSub(Request $request) {
        $actividadN = json_decode($request->actividad);
        $actividad = EventoActividad::find($actividadN->idEventoActividad);
        //dd($actividadN, $actividad);

        $actividad->modalidad = $actividadN->modalidad;
        $actividad->tipo = $actividadN->tipo;
        $actividad->nombre = $actividadN->nombre;
        $actividad->cantidad = $actividadN->cantidad;
        $actividad->tipoPoblacion = $actividadN->tipoPoblacion;
        $actividad->save();
        //dd($actividadN->direccion);
        if (isset($actividadN->direccion)) {//que la sub actividad tiene su propia direccion

            //DIRECCION
            $direccion = DireccionSub ::find($actividadN->direccion->idDireccion);
            //dd($direccion);
            $direccion->direccion = $actividadN->direccion->direccion;
            $direccion->fechaInicio = $actividadN->direccion->fechaInicio;
            $direccion->fechaFin = $actividadN->direccion->fechaFin;
            $direccion->save();
            $actividad->direccion = $direccion;

            //PALCOS
            $palcoD = $actividadN->palco;
            
            foreach ($palcoD as $p) {
                $palco = PalcoSub::find($p->idPalco);
                $palco->detalle = $p->detalle;
                $palco->capacidad = $p->capacidad;
                $palco->costo = $p->costo;
                $palco->save();
            }

            $actividad->palco = $palcoD;
            
        }

        
        return response()->json(['error'=>false,'actividad' => $actividad , 'mensaje' =>'La Sub actividad fue actualizada con exito']);
    }

    public function DeletePalco(Request $request){
        $palco = Palco::find($request->idPalco);
        $palco->delete();
        return response()->json(['error'=>false,'palco' => $palco , 'mensaje' =>'Fue eliminado con exito']);
    }

    public function DeletePalcoSub(Request $request){
        $palco = PalcoSub::find($request->idPalco);
        $palco->delete();
        return response()->json(['error'=>false,'palco' => $palco , 'mensaje' =>'Fue eliminado con exito']);
    }

    public function DeletePremio(Request $request){
        $premio = Premio::find($request->idPremio);
        //si ccambio se pone en uno es que se elino el ultimo premio de esa actividad entonces se actualiza la actividad y se debe modificar la vista 
        $cambio = 0;
        $cantidad = Premio::where('idActividad', $premio->idActividad)->count();
        if ($cantidad == 1) {
            $actividad = Actividad::find($premio->idActividad);
            $actividad->premio = 0;
            $actividad->save();
            $cambio = 1;
        }
        $premio->delete();
        return response()->json(['error'=>false,'cambio'=> $cambio,'premio' => $premio , 'mensaje' =>'Fue eliminado con exito']);
    }



    //eliminar actividad
    public function DeleteAct(Request $request){
        $actividad = Actividad::find($request->idActividad);
        //eliminar direccion y palcos si los tiene
        if ($actividad->lugar == 1){
            //direccion
            $direccion = DireccionActividad::where('idActividad', $actividad->idActividad)->get();
            $direccion[0]->delete();
            //palcos
            $palcos = Palco::where('idActividad', $actividad->idActividad)->get();
            foreach ($palcos as $palco) {
                $palco->delete();
            }

        }
       
        //eliminar subactividades si las tiene
        $subs = EventoActividad::where('idActividad', $actividad->idActividad)->get();
        foreach ($subs as $sub) {
            //eliminar direccion y palcos si los tiene
            if ($actividad->lugar == 0){
                //direccion
                $direccion = DireccionSub::where('idActividad', $sub->idEventoActividad)->get();
                $direccion[0]->delete();
                //palcos
                $palcos = PalcoSub::where('idActividad', $sub->idEventoActividad)->get();
                foreach ($palcos as $palco) {
                    $palco->delete();
                }

            }
            //eliminar la sub actividad
            $sub->delete();
        }

        //eliminar actividad
        $actividad->delete();
        return response()->json(['error'=>false,'actividad' => $actividad , 'mensaje' => 'La actividad ha sido eliminada con exito']); 

    }

    //eliminar subactividad
    public function DeleteSub(Request $request){
        $sub = EventoActividad::find($request->idEventoActividad);
        $actividad = Actividad::find($sub->idActividad);
        //eliminar direccion y palcos si los tiene
        if ($actividad->lugar == 0){
            //direccion
            $direccion = DireccionSub::where('idActividad', $sub->idEventoActividad)->get();
            $direccion[0]->delete();
            //palcos
            $palcos = PalcoSub::where('idActividad', $sub->idEventoActividad)->get();
            foreach ($palcos as $palco) {
                $palco->delete();
            }

        }
        //eliminar la sub actividad
        $sub->delete();
        return response()->json(['error'=>false,'actividad' => $sub , 'mensaje' => 'La subActividad ha sido eliminada con exito']); 
    }



  
}
