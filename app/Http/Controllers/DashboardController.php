<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Actividad;
use App\Modelos\EventoActividad;
use App\Modelos\Evento;
use App\Modelos\Palco;
use App\Modelos\Premio;
use App\Modelos\DireccionActividad;
use App\Modelos\DireccionSub;
use App\Modelos\PalcoSub;
use App\Modelos\Colormodalidad;
use App\Modelos\Empresa;
use App\Modelos\Agrupacion;
use App\Modelos\Participante;
use App\Modelos\CostoEvento;
use App\Modelos\IngresoEvento;
use App\Modelos\CostoProvee;
use App\Modelos\IngresoConsume;
use App\Modelos\Consumopalco;
use App\Modelos\Consumocalle;
use App\Modelos\Junta;
use App\Modelos\Actividadagrupacion;
use App\Modelos\Actividadparticipante;
use App\Modelos\Actividadempresa;
use DB;
use stdClass;
use Carbon\Carbon;

class DashboardController extends Controller {

    public function all(Request $request){
        $mapa = array();
        $horasPasadas = 0;
        $horasProximas = 0;
        $cantidadEmpleos = 0;
        $aforo = 0;
        $sum = new stdClass();
        $totalAgrupacion = new stdClass();
        $totalParticipante = new stdClass();
        $actividades = array();
        $cantSub = 0;
        $palco = 0;
        $palcoSub = 0;
        $sum->nempleados = 0;
        $sum->cantMujeres = 0;
        $sum->cantHombres = 0;
        $costos = array();
        $ingresos = array();
        $consumopalco = array();
        $consumocalle = array();  
        //calcular las horas de entretenimiento pasadas y por venir
        $date = Carbon::now();
        $eventoPasado = Evento::where('fechaFin' ,'<', $date)->count();
        $eventoProximo = Evento::where('fechaFin' ,'>', $date)->count();
        $eventos = Evento::all();
        //buscar los participantes del evento de los diferentes tipos, agrupaciones. participantes y empresas
        $agrupacionesAsociadas = array();
        $participantesAsociados = array();
        $empresasAsociadas = array();
        foreach ($eventos as $evento) {
            //costos del evento contiene otros costos agregados
            $costo = CostoEvento::where('idEvento', $evento->idEvento)->get();
            foreach ($costo as $c) {
                array_push($costos, $c);
            }
            //ingresoos agregados al evento
            $ingreso = IngresoEvento::where('idEvento', $evento->idEvento)->get();
            foreach ($ingreso as $i) {
                array_push($ingresos, $i);
            }
            //consumo por palcos del evento
            $consumopalcoEvento = Consumopalco::where('idEvento', $evento->idEvento)->get();
            foreach ($consumopalcoEvento as $c) {
                array_push($consumopalco, $c);
            }
            //consumo en la calle del evento
            $consumocalleEvento = Consumocalle::where('idEvento', $evento->idEvento)->get();
            foreach ($consumocalleEvento as $c) {
                array_push($consumocalle, $c);
            }
            //sumar los empleos de los organizadores
            $organizadores = Junta::where('idEvento', $evento->idEvento)->get();
            //dd($organizadores);
            $sum->nempleados += count($organizadores);
            foreach ($organizadores as $o) {
                if($o->sexo == 0){
                    $sum->cantHombres ++;
                }else{
                    $sum->cantMujeres ++;
                }
                    
            }
        
            //buscando las actividades
            $act = Actividad::where('idEvento', $evento->idEvento)->get();
            foreach ($act as $a) {
                //ingresas las actividadddes 
                array_push($actividades, $a);
                //suma las sub actividades
                $sub = EventoActividad::where('idActividad', $a->idActividad)->get();
                //suma de las sub actividades
                $cantSub += count($sub);
                /*Suma la cantidad de empleados por eventos*/
                $sum->nempleados += $a->empleo;
                $sum->cantMujeres += $a->cantMujeres;
                $sum->cantHombres += $a->cantHombres;

                if($a->lugar == 1){//mismo lugar 
                    /*cantidad de personas proyectadas, la capacidad de todos los palcos*/
                    $palco += Palco::where('idActividad', $a->idActividad)->sum('capacidad');
                
                }else{//diferentes lugares
                    foreach ($sub as $s) {
                        /*cantidad de personas proyectadas, la capacidad de todos los palcos*/
                        $palcoSub += PalcoSub::where('idActividad', $s->idEventoActividad)->sum('capacidad');
                    }
                }

                //las agrupaciones asociadas a la actividad 
                $aa = Actividadagrupacion::where('idActividad', $a->idActividad)->get();
                foreach ($aa as $a) {
                    # code...
                    array_push($agrupacionesAsociadas, $a);
                }
                //los participantes asociados a la actividad 
                $pa = Actividadparticipante::where('idActividad', $a->idActividad)->get();
                foreach ($pa as $p) {
                    # code...
                    array_push($participantesAsociados, $p);
                }
                //las empresas asociadas a la actividad 
                $ea = Actividadempresa::where('idActividad', $a->idActividad)->get();
                foreach ($ea as $e) {
                    # code...
                    array_push($empresasAsociadas, $e);
                }
                      
            }
            
        }
        //total de actividades
        $cantActividades = count($actividades);
        /*cantidad de personas proyectadas, la capacidad de todos los palcos*/
        $capacidad = $palco + $palcoSub;
        
        $modalidad = Colormodalidad::all();
        foreach ($modalidad as $m) {
            $m->aforo = 0;
            $m->horas = 0;
        }

        /*Totales de las agrupaciones */
        $totalAgrupacion->cantidad = count($agrupacionesAsociadas);//se debe filtrar por localidad
        $totalAgrupacion->miembros = 0;
        $totalAgrupacion->mujeres = 0;
        $totalAgrupacion->hombres = 0;
        //cantidad de artistas
        //dd($agrupacionesAsociadas );
        foreach ($agrupacionesAsociadas as $a) {
            $agrupacion = Agrupacion::find($a->idAgrupacion);
            //dd($agrupacion);
            $totalAgrupacion->miembros += $agrupacion->nempleados;
            $totalAgrupacion->mujeres += $agrupacion->cantMujeres;
            $totalAgrupacion->hombres += $agrupacion->cantHombres;
        }

        /*Totales participantes */
        $totalParticipante->cantidad = count($participantesAsociados);
        $totalParticipante->mujeres = 0;
        $totalParticipante->hombres = 0;
        $totalParticipante->natural = 0;
        $totalParticipante->juridico = 0;
        foreach ($participantesAsociados as $p) {
            //busca el participantes
            $participante = Participante::find($p->idParticipante);
            //calcula participantes por sexo
            if ($participante->sexo == 0) {
                # code...
                $totalParticipante->mujeres++;
            }else{
                $totalParticipante->hombres ++;
            }
            //calcula participantes naturales y juridicos
            if ($participante->tipo == 0) {
                # code...
                $totalParticipante->natural ++;
            }else{
                $totalParticipante->juridico ++;
            }
            
        }
        /*Suma de ingresos y egresos de los eventos , y de la cantidad de empleados*/
        //$sum->costos = CostoEvento::sum('costo');
        //$sum->ingresos = IngresoEvento::sum('costo');
        
        //calcular ingresos y egresos totales (por actividades, otros, hora, minutos)

        $ingresosxact = 0;
        $otrosIngresos = 0;
        $costosxact = 0;
        $otrosCostos = 0;
        //recorro las actividades para sumar los costos 
        foreach ($actividades as $actividad) {
            //le sumo al total el costo general de la actividad
            $costosxact += $actividad->costo;
            //calcular ingresos
            if ($actividad->lugar == 1) {//el mismo lugar
                //quiere decir que la actividad tiene su palco
                $palco = Palco::where('idActividad', $actividad->idActividad)->get();
                foreach ($palco as $p) {
                    $ingresosxact += $p->costo * $p->capacidad;
                }
            }else{//varios lugares
                $sub = EventoActividad::where('idActividad', $actividad->idActividad)->get();
                foreach ($sub as $s) {
                    $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                    foreach ($palco as $p) {
                        $ingresosxact += $p->costo * $p->capacidad;
                    }
                }

            }
        }

        //recorro los costos y los agrego al presupuesto
        foreach ($costos as $costo) {
            $otrosCostos += $costo->costo;
        }
        //rocorro los ingresos y los agrego al presupuesto
        foreach ($ingresos as $ingreso) {
            $otrosIngresos += $ingreso->costo;
        }

        $totalIngresos = $ingresosxact + $otrosIngresos;
        $totalCostos = $costosxact + $otrosCostos;

        //totales de ingresos y costos 
        $ingCos = new stdClass();
        $ingCos->totalIngresos = $totalIngresos;
        $ingCos->ingresosxact = $ingresosxact;
        $ingCos->otrosIngresos = $otrosIngresos;
        $ingCos->totalCostos = $totalCostos;
        $ingCos->costosxact = $costosxact;
        $ingCos->otrosCostos = $otrosCostos;
        
        //calcular las bebidas, snacks y comidas por palco y calle
        //PALCO
        $totalPalco = 0;
        $palcoBebidas = 0;
        $palcoSnacks = 0;
        $palcoComidas = 0;
        foreach ($consumopalco as $consumo) {   
            $totalPalco += $consumo->consumo * $consumo->venta;
            //si es snack
            if ($consumo->producto == 7) {
                $palcoSnacks += $consumo->consumo * $consumo->venta;
            }
            //si es bebidas
            if ($consumo->producto != 7 && $consumo->producto != 8 && $consumo->producto != 9 && $consumo->producto != 10) {
                $palcoBebidas += $consumo->consumo * $consumo->venta;
            }
            //si es comidas
            if ($consumo->producto == 7 || $consumo->producto == 8 || $consumo->producto == 9 || $consumo->producto == 10) {
                $palcoComidas += $consumo->consumo * $consumo->venta;
            }
        }
        //CALLE
        $totalCalle = 0;
        $calleBebidas = 0;
        $calleSnacks = 0;
        $calleComidas = 0;
        foreach ($consumocalle as $consumo) {
            $totalCalle += $consumo->consumo * $consumo->venta;
            //si es snack
            if ($consumo->producto == 7) {
                $calleSnacks += $consumo->consumo * $consumo->venta;
            }
            //si es bebidas
            if ($consumo->producto != 7 && $consumo->producto != 8 && $consumo->producto != 9 && $consumo->producto != 10) {
                $calleBebidas += $consumo->consumo * $consumo->venta;
            }
            //si es comidas
            if ($consumo->producto == 7 || $consumo->producto == 8 || $consumo->producto == 9 || $consumo->producto == 10) {
                $calleComidas += $consumo->consumo * $consumo->venta;
            }
        }
        $consumoT = new stdClass();
        $consumoT->totalPalco = $totalPalco;
        $consumoT->bebidasPalco = $palcoBebidas;
        $consumoT->snacksPalco = $palcoSnacks;
        $consumoT->comidasPalco = $palcoComidas;
        $consumoT->totalCalle = $totalCalle;
        $consumoT->bebidascalle = $calleBebidas;
        $consumoT->snackscalle = $calleSnacks;
        $consumoT->comidascalle = $calleComidas;
        $consumoT->totalBebidas = $palcoBebidas + $calleBebidas;
        $consumoT->totalSnacks = $palcoSnacks + $calleSnacks;
        $consumoT->totalComidas = $palcoComidas + $calleComidas;
        
        
        foreach ($actividades as $act) {
            if ($act->lugar == 1) {//mismo lugar
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $data = new stdClass();
                $data->nombre = $act->nombre;
                if ($direccion[0]) {
                    $data->direccion = $direccion[0];
                }else{
                    $data->direccion = '';
                }
                array_push($mapa, $data);
                //HORAS DE ENTRETENIMIENTO
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $inicio = new Carbon($direccion[0]->fechaInicio);
                $fin = new Carbon($direccion[0]->fechaFin);
                $horasProximas += $inicio->diffInHours($fin);
                $cantidadEmpleos += $act->empleo;
                //buscar aforo por modalidad
                $aforoAct = 0; 
                $palco = Palco::where('idActividad', $act->idActividad)->get();
                foreach ($palco as $p) {
                    $aforoAct += $p->capacidad;
                }
                //calcula modalidad
                foreach ($modalidad as $m) {
                    if ($act->modalidad == $m->idModalidad) {
                        $m->cantidad++;
                        $m->horas += $inicio->diffInHours($fin);
                        $m->aforo += $aforoAct;
                    }
                }
                //buscar las subactividades para calcular la cantidad de horas por modalidad
                /*$sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                foreach ($sub as $s) {
                    //calcula modalidad
                    foreach ($modalidad as $m) {
                        if ($act->modalidad == $m->idModalidad) {
                            $m->cantidad++;
                            $m->horas += $inicio->diffInHours($fin);
                            $m->aforo += $aforoAct;
                        }
                    }
                }*/

            }else{
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                foreach ($sub as $s) {
                    $aforoAct = 0;
                    $direccion = DireccionSub::where('idActividad' , $s->idEventoActividad)->get();
                    $data = new stdClass();
                    $data->nombre = $s->nombre;
                    $data->direccion = $direccion[0];
                    array_push($mapa, $data);
                   //HORAS DE ENTRETENIMIENTO
                    $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasProximas += $inicio->diffInHours($fin);
                    $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                    
                    //AFORO POR MODALIDAD
                    foreach ($palco as $p) {
                        $aforo += $p->capacidad;
                        $aforoAct = $p->capacidad;
                    }

                    //calcula modalidad
                    foreach ($modalidad as $m) {
                        if ($s->modalidad == $m->idModalidad) {
                            $m->cantidad++;
                            $m->horas += $inicio->diffInHours($fin);
                            $m->aforo += $aforoAct;
                        }
                    }
                }
            }
         }
        //calcular el consumo en la calle  y en los palcos
        //$consumopalco = Consumopalco::all();
        $totalPalco = 0;
        foreach ($consumopalco as $consumo) {
            $totalPalco += $consumo->consumo * $consumo->venta;
        }
        //$consumocalle = Consumocalle::all();
        $totalCalle = 0;
        foreach ($consumocalle as $consumo) {
            $totalCalle += $consumo->consumo * $consumo->venta;
        }

        $totales = new stdClass();
        $totales->empresas = Empresa::count();
        $totales->participantes = Participante::count();
        $totales->agrupaciones = Agrupacion::count();
        $totales->palco = $totalPalco;
        $totales->calle = $totalCalle;
        
        //calculo de empresas
        $patrocinio = 0;
        $provee = 0;
        $consumo = 0;
        $cantP = 0;
        $cantProvee = 0;
        $cantC = 0;
        //$costos = CostoEvento::all();
        //$ingresos = IngresoEvento::all();
        //calcula provee y patrocinio
        foreach ($costos as $costo) {
            $proveedores = CostoProvee::where('idCosto', $costo->idCosto)->get();
            foreach ($proveedores as $p) {
                if ($p->subsidio == 1) {//patrocinio
                    $patrocinio += $p->costo;
                    $cantP++;
                }else{
                    $provee += $p->costo;
                    $cantProvee++;
                }
            }
        }
        //calcula consumo
        foreach ($ingresos as $ingreso) {
            $consumidores = IngresoConsume::where('idIngreso', $ingreso->idIngreso)->get();
            foreach ($consumidores as $c) {
                $consumo += $c->costo;
                $cantC++;
            }
        }
        $totalEmpresa = new stdClass();
        $totalEmpresa->patrocinio = $patrocinio;
        $totalEmpresa->provee = $provee;
        $totalEmpresa->consumo = $consumo;
        $totalEmpresa->cantPatrocinio = $cantP;
        $totalEmpresa->cantProvee = $cantProvee;
        $totalEmpresa->cantConsumo = $cantC;
        //dd($totales);
        return response()->json(['error'=>false,'actividad' => $mapa, 'totales' => $totales, 'totalEmpresa' => $totalEmpresa, 'horas' => $horasProximas , 'cantidadEmpleos' => $cantidadEmpleos , 'cantActividades' => $cantActividades , 'capacidad' => $capacidad ,'cantSub' => $cantSub , 'totalAgrupacion' => $totalAgrupacion , 'totalParticipante' => $totalParticipante , 'sum' => $sum, 'modalidad' => $modalidad, 'ingCos' =>$ingCos, 'consumo' => $consumoT]);
    }

    public function allDepartamento(Request $request){

        $mapa = array();
        $horasPasadas = 0;
        $horasProximas = 0;
        $cantidadEmpleos = 0;
        $cantActividades = 0;
        $aforo = 0;
        $sum = new stdClass();//Objeto que guarda varias sumas de totales
        $sum->costos = 0;
        $sum->ingresos = 0;
        $sum->nempleados = 0;
        $sum->cantMujeres = 0;
        $sum->cantHombres = 0;
        $ingresosxact = 0;
        $otrosIngresos = 0;
        $costosxact = 0;
        $otrosCostos = 0;
        $totalPalco = 0;
        $palcoBebidas = 0;
        $palcoComidas = 0;
        $totalCalle = 0;
        $calleBebidas = 0;
        $calleSnacks = 0;
        $calleComidas = 0;
        $palcoSnacks = 0;
        $totalPalco = 0;
        $totalCalle = 0;
        //calculo de empresas
        $patrocinio = 0;
        $provee = 0;
        $consumoC = 0;
        $cantP = 0;
        $cantProvee = 0;
        $cantC = 0;

        $totalAgrupacion = new stdClass();
        $totalParticipante = new stdClass();
        //calcular las horas de entretenimiento pasadas y por venir
        $date = Carbon::now();
        $eventoPasado = Evento::where('idDepartamento' , $request->idDepartamento)->where('fechaFin' ,'<', $date)->get();
        $eventoProximo = Evento::where('idDepartamento' , $request->idDepartamento)->where('fechaFin' ,'>', $date)->get();
        $evento = Evento::where('idDepartamento', $request->idDepartamento)->get();
        $modalidad = Colormodalidad::all();
        foreach ($modalidad as $m) {
            $m->aforo = 0;
            $m->horas = 0;
        }
        $cantSub = 0; //Guarda la cantidad de las subactividades

        /*Totales de las agrupaciones */

        $totalAgrupacion->cantidad = Agrupacion::where('departamento' , $request->idDepartamento)->count();
        $totalAgrupacion->miembros = Agrupacion::where('departamento' , $request->idDepartamento)->sum('nempleados');
        $totalAgrupacion->mujeres = Agrupacion::where('departamento' , $request->idDepartamento)->sum('cantMujeres');
        $totalAgrupacion->hombres = Agrupacion::where('departamento' , $request->idDepartamento)->sum('cantHombres');
        if ($totalAgrupacion->miembros == null) {
            $totalAgrupacion->miembros = 0;
        }
        if ($totalAgrupacion->mujeres == null) {
            $totalAgrupacion->mujeres = 0;
        }
        if ($totalAgrupacion->hombres == null) {
            $totalAgrupacion->hombres = 0;
        }
        /*Totales participantes */
        $totalParticipante->cantidad = Participante::where('departamento' , $request->idDepartamento)->count();
        $totalParticipante->mujeres = Participante::where('departamento' , $request->idDepartamento)->where('sexo' , 0)->count();
        $totalParticipante->hombres = Participante::where('departamento' , $request->idDepartamento)->where('sexo' , 1)->count();
        $totalParticipante->natural = Participante::where('departamento' , $request->idDepartamento)->where('tipo' , 0)->count();
        $totalParticipante->juridico = Participante::where('departamento' , $request->idDepartamento)->where('tipo' , 1)->count();

        foreach ($evento as $e) {

            $actividades = Actividad::where('idEvento' , $e->idEvento)->get();
            $cantActividades += count($actividades);
            
            /*Suma de ingresos y egresos de los eventos , y de la cantidad de empleados*/
            $sum->costos += CostoEvento::where('idEvento' , $e->idEvento)->sum('costo');
            $sum->ingresos += IngresoEvento::where('idEvento' , $e->idEvento)->sum('costo');
            
            //ingresoos agregados al evento
            $ingresos = IngresoEvento::where('idEvento' , $e->idEvento)->get();
            $costos = CostoEvento::where('idEvento' , $e->idEvento)->get();
            //Busca los consumos por palcos segun el idEvento
            $consumopalco = Consumopalco::where('idEvento' , $e->idEvento)->get();
            //Busca los consumos en la calle segun el idEvento
            $consumocalle = Consumocalle::where('idEvento' , $e->idEvento)->get();
            //sumar los empleos de los organizadores
            $organizadores = Junta::where('idEvento', $e->idEvento)->get();
            $sum->nempleados += count($organizadores);
            foreach ($organizadores as $o) {
                if($o->sexo == 0){
                    $sum->cantHombres ++;
                }else{
                    $sum->cantMujeres ++;
                }
                    
            }
            
            

            foreach ($actividades as $act) {

                    $costosxact += $act->costo;
                    $sub = EventoActividad::where('idActividad' , $act->idActividad)->get();
                    /*cantidad de personas proyectadas, la capacidad de todos los palcos*/
                    $palco = Palco::where('idActividad' , $act->idActividad)->sum('capacidad');
                    $getPalco = Palco::where('idActividad' , $act->idActividad)->get();
                    foreach ($getPalco as $p) {
                        $ingresosxact += $p->costo * $p->capacidad;

                    }

                    $palcoSub = PalcoSub::where('idActividad' , $act->idActividad)->sum('capacidad');
                    $capacidad = $palco + $palcoSub;
                    if ($capacidad == null) {
                       $capacidad = 0;
                    }
                    
                    $sum->nempleados += $act->empleo;
                    $sum->cantMujeres += $act->cantMujeres;
                    $sum->cantHombres += $act->cantHombres;
                    

                if ($act->lugar == 1) {//mismo lugar
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $data = new stdClass();
                    $palco = Palco::where('idActividad', $act->idActividad)->get();
                    foreach ($palco as $p) {
                        $ingresosxact += $p->costo * $p->capacidad;
                    }
                    $data->nombre = $act->nombre;
                    if ($direccion[0]) {
                        $data->direccion = $direccion[0];
                    }else{
                        $data->direccion = '';
                    }
                    array_push($mapa, $data);
                    //HORAS DE ENTRETENIMIENTO
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasProximas += $inicio->diffInHours($fin);
                    $cantidadEmpleos += $act->empleo;
                    //buscar aforo por modalidad
                    $aforoAct = 0; 
                    $palco = Palco::where('idActividad', $act->idActividad)->get();
                    foreach ($palco as $p) {
                        $aforoAct += $p->capacidad;
                    }
                     //buscar las subactividades para calcular la cantidad de horas por modalidad
                    $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                    foreach ($sub as $s) {
                        //calcula modalidad
                        foreach ($modalidad as $m) {
                            if ($act->modalidad == $m->idModalidad) {
                                $m->cantidad++;
                                $m->horas += $inicio->diffInHours($fin);
                                $m->aforo += $aforoAct;
                            }
                        }
                    }
                }else{
                    $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                    foreach ($sub as $s) {
                        $direccion = DireccionSub::where('idActividad' , $s->idEventoActividad)->get();
                        $data = new stdClass();
                        $data->nombre = $s->nombre;
                        $data->direccion = $direccion[0];
                        array_push($mapa, $data);
                       //HORAS DE ENTRETENIMIENTO
                        $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                        $inicio = new Carbon($direccion[0]->fechaInicio);
                        $fin = new Carbon($direccion[0]->fechaFin);
                        $horasProximas += $inicio->diffInHours($fin);
                        $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                        foreach ($palco as $p) {
                            $ingresosxact += $p->costo * $p->capacidad;
                        }
                            //AFORO POR MODALIDAD
                        foreach ($palco as $p) {
                            $aforo += $p->capacidad;
                            $aforoAct = $p->capacidad;
                        }

                        //calcula modalidad
                        foreach ($modalidad as $m) {
                            if ($s->modalidad == $m->idModalidad) {
                                $m->cantidad++;
                                $m->horas += $inicio->diffInHours($fin);
                                $m->aforo += $aforoAct;
                            }
                        }
                    }

                }
            $cantSub += count($sub); //llena la cantidad de subactividades
            }//Fin foreach actividades

            foreach ($costos as $costo) {
                $otrosCostos += $costo->costo;
            }
            //rocorro los ingresos y los agrego al presupuesto
            foreach ($ingresos as $ingreso) {
                $otrosIngresos += $ingreso->costo;
            }
            //Calculo del consumo 
            //PALCOS
            foreach ($consumopalco as $consumo) {   
                $totalPalco += $consumo->consumo * $consumo->venta;
                //si es snack
                if ($consumo->producto == 7) {
                    $palcoSnacks += $consumo->consumo * $consumo->venta;
                }
                //si es bebidas
                if ($consumo->producto != 7 && $consumo->producto != 8 && $consumo->producto != 9 && $consumo->producto != 10) {
                    $palcoBebidas += $consumo->consumo * $consumo->venta;
                }
                //si es comidas
                if ($consumo->producto == 7 || $consumo->producto == 8 || $consumo->producto == 9 || $consumo->producto == 10) {
                    $palcoComidas += $consumo->consumo * $consumo->venta;
                }
            }
            //CALLE
            foreach ($consumocalle as $consumo) {
                $totalCalle += $consumo->consumo * $consumo->venta;
                //si es snack
                if ($consumo->producto == 7) {
                    $calleSnacks += $consumo->consumo * $consumo->venta;
                }
                //si es bebidas
                if ($consumo->producto != 7 && $consumo->producto != 8 && $consumo->producto != 9 && $consumo->producto != 10) {
                    $calleBebidas += $consumo->consumo * $consumo->venta;
                }
                //si es comidas
                if ($consumo->producto == 7 || $consumo->producto == 8 || $consumo->producto == 9 || $consumo->producto == 10) {
                    $calleComidas += $consumo->consumo * $consumo->venta;
                }
            }

            //calcular el consumo en la calle  y en los palcos
            
            foreach ($consumopalco as $consumo) {
                $totalPalco += $consumo->consumo * $consumo->venta;
            }
           
            foreach ($consumocalle as $consumo) {
                $totalCalle += $consumo->consumo * $consumo->venta;
            }
            foreach ($costos as $costo) {
                $proveedores = CostoProvee::where('idCosto', $costo->idCosto)->get();
                foreach ($proveedores as $p) {
                    if ($p->subsidio == 1) {//patrocinio
                        $patrocinio += $p->costo;
                        $cantP++;
                    }else{
                        $provee += $p->costo;
                        $cantProvee++;
                    }
                }
            }
            //calcula consumo
            foreach ($ingresos as $ingreso){
                $consumidores = IngresoConsume::where('idIngreso', $ingreso->idIngreso)->get();
                foreach ($consumidores as $c) {
                    $consumoC += $c->costo;
                    $cantC++;
                }
            }
       }//Fin de foreach eventos

       //Total de los consumos
        $consumoT = new stdClass();
        $consumoT->totalPalco = $totalPalco;
        $consumoT->bebidasPalco = $palcoBebidas;
        $consumoT->snacksPalco = $palcoSnacks;
        $consumoT->comidasPalco = $palcoComidas;
        $consumoT->totalCalle = $totalCalle;
        $consumoT->bebidascalle = $calleBebidas;
        $consumoT->snackscalle = $calleSnacks;
        $consumoT->comidascalle = $calleComidas;
        $consumoT->totalBebidas = $palcoBebidas + $calleBebidas;
        $consumoT->totalSnacks = $palcoSnacks + $calleSnacks;
        $consumoT->totalComidas = $palcoComidas + $calleComidas;
        
        
        $totalIngresos = $ingresosxact + $otrosIngresos;
        $totalCostos = $costosxact + $otrosCostos;

        //totales de ingresos y costos 
        $ingCos = new stdClass();
        $ingCos->totalIngresos = $totalIngresos;
        $ingCos->ingresosxact = $ingresosxact;
        $ingCos->otrosIngresos = $otrosIngresos;
        $ingCos->totalCostos = $totalCostos;
        $ingCos->costosxact = $costosxact;
        $ingCos->otrosCostos = $otrosCostos;
        
        $totales = new stdClass();
        $totales->empresas = Empresa::where('departamento' , $request->idDepartamento)->count();
        $totales->participantes = Participante::where('departamento' , $request->idDepartamento)->count();
        $totales->agrupaciones = Agrupacion::where('departamento' , $request->idDepartamento)->count();
        $totales->palco = $totalPalco;
        $totales->calle = $totalCalle;
       
        // $costos = CostoEvento::all();
        //$ingresos = IngresoEvento::all();
        //calcula provee y patrocinio
       
        $totalEmpresa = new stdClass();
        $totalEmpresa->patrocinio = 0;
        $totalEmpresa->provee = 0;
        $totalEmpresa->consumo = 0;
        $totalEmpresa->cantPatrocinio = 0;
        $totalEmpresa->cantProvee = 0;
        $totalEmpresa->cantConsumo = 0;
        $totalEmpresa->patrocinio = $patrocinio;
        $totalEmpresa->provee = $provee;
        $totalEmpresa->consumo = $consumoC;
        $totalEmpresa->cantPatrocinio = $cantP;
        $totalEmpresa->cantProvee = $cantProvee;
        $totalEmpresa->cantConsumo = $cantC;

    //    dd($capacidad);
        return response()->json(['error'=>false,'actividad' => $mapa, 'totales' => $totales, 'totalEmpresa' => $totalEmpresa, 'horas' => $horasProximas , 'cantidadEmpleos' => $cantidadEmpleos , 'cantActividades' => $cantActividades , 'cantSub' => $cantSub , 'totalAgrupacion' => $totalAgrupacion , 'totalParticipante' => $totalParticipante, 'sum' => $sum , 'ingCos' => $ingCos , 'consumo' => $consumoT , 'modalidad' => $modalidad , 'capacidad' => $capacidad ]);
    }
    


    public function ActividadesAll(Request $request){
        $mapa = array();
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        
        foreach ($actividades as $act) {
            if ($act->lugar == 1) {//mismo lugar
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $data = new stdClass();
                $data->nombre = $act->nombre;
                $data->direccion = $direccion[0];
                
                array_push($mapa, $data);
              
               
            }else{
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                foreach ($sub as $s) {
                    $direccion = DireccionSub::where('idActividad' , $s->idEventoActividad)->get();
                    $data = new stdClass();
                    $data->nombre = $s->nombre;
                    $data->direccion = $direccion[0];
                    array_push($mapa, $data);
                }
            }
         }
        
       // dd($horasProximas , $cantidadEmpleos , $cantActividades, $capacidad);
        return response()->json(['error'=>false,'actividad' => $mapa]);
    }

  

}
