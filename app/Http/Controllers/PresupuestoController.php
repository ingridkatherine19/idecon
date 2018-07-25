<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Actividad;
use App\Modelos\CostoEvento;
use App\Modelos\IngresoEvento;
use App\Modelos\Premio;
use App\Modelos\Palco;
use App\Modelos\EventoActividad;
use App\Modelos\PalcoSub;
use App\Modelos\TipoPresupuesto;
use App\Modelos\Costoactividad;
use DB;
use stdClass;

class PresupuestoController extends Controller {

    //trae todos los tipos de presupuesto
    public function allTipo(Request $request){
        $tipo = TipoPresupuesto::all(); 

        return response()->json(['error'=>false,'tipo' => $tipo]);        

    }
    //agrega tipo de presupuesto
    public function createTipo(Request $request){
        $tipo = new TipoPresupuesto();
        $tipo->idSeccion = $request->idSeccion;//si es 0 es costo si es 1 ingreso
        $tipo->nombre = $request->nombre;
        $tipo->save();

        return response()->json(['error'=>false,'tipo' => $tipo]);        

    }
    //agregar nuevo costo al evento
    public function createCosto(Request $request){
        $costo = new CostoEvento();
        $costo->idEvento = $request->idEvento;
        $costo->nombre = $request->nombre;
        $costo->cantidad = $request->cantidad;
        $costo->tipo = $request->tipo;
        $costo->costo = $request->costo;
        $costo->app = $request->app;
        $costo->save();

        return response()->json(['error'=>false,'costo' => $costo]);        

    }

    //agregar nuevo costo a la actividad
    public function createCostoActividad(Request $request){
        $costo = new Costoactividad();
        $costo->idActividad = $request->idActividad;
        $costo->nombre = $request->nombre;
        $costo->cantidad = $request->cantidad;
        $costo->costo = $request->costo;
        $costo->app = $request->app;
        $costo->save();

        $actividad = Actividad::find($request->idActividad);
        $actividad->costo += $request->costo;
        $actividad->save();

        return response()->json(['error'=>false,'costo' => $costo]);
    }

    public function allCostoActividad(Request $request){
        $costos = Costoactividad::where('idActividad', $request->idActividad)->get();
        return response()->json(['error'=>false,'costos' => $costos]);
    }

    //elimina el costo de la actividad
    public function deleteCostoActividad(Request $request){
        $costo = Costoactividad::find($request->idCosto);
        
        $actividad = Actividad::find($request->idActividad);
        $actividad->costo -= $costo->costo;
        $actividad->save();

        $costo->delete();

        return response()->json(['error'=>false,'costo' => $costo]);        

    }


    public function updateCosto(Request $request){
        $costo = CostoEvento::find($request->idCosto);
        $costo->nombre = $request->nombre;
        $costo->cantidad = $request->cantidad;
        $costo->tipo = $request->tipo;
        $costo->costo = $request->costo;
        $costo->app = $request->app;
        $costo->save();

        return response()->json(['error'=>false,'costo' => $costo]);        

    }

    //agregar nuevo ingreso al evento
    public function createIngreso(Request $request){
        $ingreso = new IngresoEvento();
        $ingreso->idEvento = $request->idEvento;
        $ingreso->nombre = $request->nombre;
        $ingreso->cantidad = $request->cantidad;
        $ingreso->tipo = $request->tipo;
        $ingreso->costo = $request->costo;
        $ingreso->save();

        return response()->json(['error'=>false,'ingreso' => $ingreso]);
    }

    public function updateIngreso(Request $request){
        $ingreso = IngresoEvento::find($request->idIngreso);
        //dd($ingreso);
        $ingreso->nombre = $request->nombre;
        $ingreso->cantidad = $request->cantidad;
        $ingreso->tipo = $request->tipo;
        $ingreso->costo = $request->costo;
        $ingreso->save();

        return response()->json(['error'=>false,'ingreso' => $ingreso]);
    }


    //elimina el costo del evento
    public function deleteCosto(Request $request){
        $costo = CostoEvento::find($request->id);
        $costo->delete();

        return response()->json(['error'=>false,'costo' => $costo]);        

    }

    //elimina el ingresos del evento
    public function deleteIngreso(Request $request){
        $ingreso = IngresoEvento::find($request->id);
        $ingreso->delete();

        return response()->json(['error'=>false,'ingreso' => $ingreso]);        

    }

    //se trae lo que tiene el presupuesto
    public function all(Request $request){
         
        //las actividades para sacar el costo de cada actividad
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        //costos del evento contiene otros costos agregados
        $costos = CostoEvento::where('idEvento', $request->idEvento)->get();
        //ingresoos agregados al evento
        $ingresos = IngresoEvento::where('idEvento', $request->idEvento)->get();
        //el arreglo presupuesto que se va llenar con todo
        $presupuestoCosto = array();
        $presupuestoIngreso = array();
        //recorro las actividades para sumar los costos y las premiaciones si tiene
        foreach ($actividades as $actividad) {
            //el total es para la sumatoria del costo total de la actividad
            $totalCosto = 0;
            $totalIngreso =0;
            //cantidad es para guardar el total de sub actividades que tiene esa actividad
            $cantidad = 0;
            //si la actividad tiene premio
            if ($actividad->premio == 1) {
                $premio = Premio::where('idActividad', $actividad->idActividad)->get();
                foreach ($premio as $p) {
                    //por cada premio que tenga voy a sumar al total el costo del premio
                    $totalCosto += $p->costo; 
                }
            }
            //le sumo al total el costo general de la actividad
            $totalCosto += $actividad->costo;

            //ver cuantas sub actividades tiene 
            $cantidad = EventoActividad::where('idActividad', $actividad->idActividad)->get()->count();
            
            //crear la data 
            $datos = new stdClass();
            $datos->nombre = $actividad->nombre;
            $datos->cantidad = $cantidad;
            $datos->tipo = 0; //tipo actividad
            $datos->tipoNombre = 'Actividad'; //tipo actividad
            $datos->costo = $totalCosto;
            $datos->idActividad = $actividad->idActividad;

            //meter en el arreglo de presupuesto

            array_push($presupuestoCosto, $datos);


            //calcular ingresos
            if ($actividad->lugar == 1) {//el mismo lugar
                //quiere decir que la actividad tiene su palco
                $palco = Palco::where('idActividad', $actividad->idActividad)->get();
                foreach ($palco as $p) {
                    $totalIngreso += $p->costo * $p->capacidad;
                }
            }else{//varios lugares
                $sub = EventoActividad::where('idActividad', $actividad->idActividad)->get();
                foreach ($sub as $s) {
                    $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                    foreach ($palco as $p) {
                        $totalIngreso += $p->costo * $p->capacidad;
                    }
                }

            }

            //crear la data 
            $datos2 = new stdClass();
            $datos2->nombre = $actividad->nombre;
            $datos2->cantidad = $cantidad;
            $datos2->tipo = 0; //tipo actividad
            $datos2->tipoNombre = 'Actividad'; //tipo actividad
            $datos2->costo = $totalIngreso;

            //meter en el arreglo de presupuesto

            array_push($presupuestoIngreso, $datos2);
        }
        //recorro los costos y los agrego al presupuesto
        foreach ($costos as $costo) {
            $tipo = TipoPresupuesto::find($costo->tipo);
            
            $costo->tipoNombre = $tipo->nombre;
            array_push($presupuestoCosto, $costo);   
        }
        //rocorro los ingresos y los agrego al presupuesto
        foreach ($ingresos as $ingreso) {
            $tipo = TipoPresupuesto::find($ingreso->tipo);
            $ingreso->tipoNombre = $tipo->nombre;
            array_push($presupuestoIngreso, $ingreso);
        }

        //dd($presupuestoCosto, $presupuestoIngreso);

        return response()->json(['error'=>false,'presupuestoCosto' => $presupuestoCosto, 'presupuestoIngreso' => $presupuestoIngreso]);
    }


}
