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
use App\Modelos\SubParticipa;
use App\Modelos\CostoProvee;
use App\Modelos\IngresoConsume;
use App\Modelos\Empresa;
use DB;
use stdClass;

class PresupuestoRealController extends Controller {

    //trae todos los palcos de las actividad 
    public function allActividad(Request $request){
        $actividad = Actividad::find($request->idActividad);
        if ($actividad->lugar==1) {//mismo lugar
            //busco los palcos en la ctividad
            $actividad->palcos = Palco::where('idActividad', $request->idActividad)->get();
        }else{//lugares diferentes
            //busco las subactividades y busco los palcos en la subactividad
            $actividad->subActividad = EventoActividad::where('idActividad', $request->idActividad)->get();

            foreach ($actividad->subActividad as $sub) {
                $sub->palcos = PalcoSub::where('idActividad', $sub->idEventoActividad)->get();
            }
        }

        return response()->json(['error'=>false, 'actividad' => $actividad]);
    }
    
    //actualizar los datos de los palcos de una actividad 
    public function updateActividad(Request $request){
        
        $actividad = json_decode($request->actividad);
        if ($actividad->lugar==1) {//mismo lugar
            //busco los palcos en la actividad y actualizo las cantidades reales 
            foreach ($actividad->palcos as $p) {
                $palco = Palco::find($p->idPalco);
                $palco->cantidadReal = $p->cantidadReal;
                $palco->save();
            }
            
        }else{//lugares diferentes
            //busco los palcos de la subactividad para actualizar las cantidades reales
            foreach ($actividad->subActividad as $sub) {
                foreach ($sub->palcos as $p) {
                    $palco = PalcoSub::find($p->idPalco);   
                    $palco->cantidadReal = $p->cantidadReal;
                    $palco->save();
                }
            }
        }
        return response()->json(['error'=>false, 'actividad' => $actividad]);
    }

    //actualizar el costo real de una actividad 
    public function updateCosto(Request $request){
        $actividad = Actividad::find($request->idActividad);
        $actividad->costoReal = $request->costoReal;
        $actividad->save();
        
        return response()->json(['error'=>false, 'actividad' => $actividad]);
    }

    //trae todos los costos provee de un costo
    public function allCosto(Request $request){
        $costos = CostoProvee::where('idCosto', $request->idCosto)->get();
        foreach ($costos as $costo) {
            $empresa = Empresa::find($costo->idProveedor);
            $costo->empresa = $empresa->nombre;
        }
        return response()->json(['error'=>false, 'costos' => $costos]);
    }

    //guarda un costo provee de un costo
    public function createCosto(Request $request){
        $costo = new CostoProvee();
        $costo->idCosto = $request->idCosto;
        $costo->idProveedor = $request->idProveedor;
        $costo->subsidio = $request->subsidio;
        $costo->costo = $request->costo;
        $costo->save();

        return response()->json(['error'=>false, 'costos' => $costo]);
    }
    
    //elimina un costo provee de un costo
    public function deleteCosto(Request $request){
        $costo = CostoProvee::find($request->id);
        $costo->delete();
        return response()->json(['error'=>false,'costos' => $costo]);
    }

    //trae todos los consumidores de los ingresos
    public function allIngreso(Request $request){
        $ingresos = IngresoConsume::where('idIngreso', $request->idIngreso)->get();
        foreach ($ingresos as $ingreso) {
            $empresa = Empresa::find($ingreso->idConsumidor);
            $ingreso->empresa = $empresa->nombre;
        }
        return response()->json(['error'=>false, 'ingresos' => $ingresos]);
    }

    //guarda un consumidor de un ingreso
    public function createIngreso(Request $request){
        $ingreso = new IngresoConsume();
        $ingreso->idIngreso = $request->idIngreso;
        $ingreso->idConsumidor = $request->idConsumidor;
        $ingreso->costo = $request->costo;
        $ingreso->save();

        return response()->json(['error'=>false, 'ingreso' => $ingreso]);
    }

    //elimina un costo provee de un costo
    public function deleteIngreso(Request $request){
        $ingreso = IngresoConsume::find($request->id);
        $ingreso->delete();
        return response()->json(['error'=>false,'ingreso' => $ingreso]);
    }


    //trae todos los datos del presupuesto
    public function all(Request $request){
        //comienza buscando los datos de las actividades del evento con todos sus datos 
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        //por cada actividad voy a buscar su sub activadades, palcos y premios si los tiene 
        foreach ($actividades as $actividad) {
            $ingresoP = 0;
            $ingresoR = 0;
            if ($actividad->lugar == 1) {
                // es en el mismo lugar debo buscar los palcos y las subactividades no tienen palco
                $actividad->palco = Palco::where('idActividad', $actividad->idActividad)->get();
                //calcular el ingreso de presupuesto y el real
                foreach ($actividad->palco as $palco) {
                    $ingresoP += $palco->capacidad * $palco->costo;
                    $ingresoR += $palco->cantidadReal * $palco->costo;

                }

                $actividad->subactividad = EventoActividad::where('idActividad', $actividad->idActividad)->get();
                $actividad->ingresoPresupuesto = $ingresoP;
                $actividad->ingresoReal = $ingresoR;

            }else{
                //debo buscar los palcos de cada subactividad
                $subactividad = EventoActividad::where('idActividad', $actividad->idActividad)->get();
                foreach ($subactividad as $sub) {
                    $sub->palco = PalcoSub::where('idActividad', $sub->idEventoActividad)->get();
                    foreach ($sub->palco as $palco) {
                        $ingresoP += $palco->capacidad * $palco->costo;
                        $ingresoR += $palco->cantidadReal * $palco->costo;

                    }
                }
                $actividad->subactividad = $subactividad;
                $actividad->ingresoPresupuesto = $ingresoP;
                $actividad->ingresoReal = $ingresoR;
            }

            if ($actividad->premio == 1) {
                //buscar los premios de la actividad
                $actividad->premio = Premio::where('idActividad', $actividad->idActividad)->get();
            }

        }

        //buscar los costos 
        $costos = CostoEvento::where('idEvento', $request->idEvento)->get();
        foreach ($costos as $costo) {
            $costoR = 0;
            $tipo = TipoPresupuesto::find($costo->tipo);
            $costo->tipoNombre = $tipo->nombre;
            $costoProvee = costoProvee::where('idCosto', $costo->idCosto)->get();
            foreach ($costoProvee as $c) {
                $costoR += $c->costo;
            }
            $costo->costoReal = $costoR;
        }

        //buscar los ingresos
        $ingresos = IngresoEvento::where('idEvento', $request->idEvento)->get();
        foreach ($ingresos as $ingreso) {
            $ingresoR = 0;
            $tipo = TipoPresupuesto::find($ingreso->tipo);
            $ingreso->tipoNombre = $tipo->nombre;
            $ingresoConsume = IngresoConsume::where('idIngreso', $ingreso->idIngreso)->get();
            foreach ($ingresoConsume as $i) {
                $ingresoR += $i->costo;
            }
            $ingreso->ingresoReal = $ingresoR;
        }

        //debe retornar los datos de las actividades, costos e ingresos
        return response()->json(['error'=>false,'actividades' => $actividades, 'costos' => $costos, 'ingresos' => $ingresos]);        

    }



}
