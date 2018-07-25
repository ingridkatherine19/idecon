<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Evento;
use App\Modelos\Empresa;
use App\Modelos\CostoEvento;
use App\Modelos\CostoProvee;
use App\Modelos\IngresoEvento;
use App\Modelos\IngresoConsume;
use App\Modelos\Actividad;
use App\Modelos\Palco;
use App\Modelos\PalcoSub;
use App\Modelos\Agrupacion;
use App\Modelos\Genero;
use App\Modelos\Participante;
use App\Modelos\Premio;
use App\Modelos\EventoActividad;
use App\Modelos\Hotel;
use App\Modelos\Restaurante;
use App\Modelos\Lugar;
use App\Modelos\DireccionSub;
use App\Modelos\DireccionActividad;
use DB;
use stdClass;
use Carbon\Carbon;

class ResumenAppController extends Controller {
  

     public function inicioEmpresa(Request $request){
        //TOTAL DE EVENTO
        $eventos = Evento::all()->count();
        //TOTAL DE EMPRESA
        $empresas = Empresa::all()->count();
        //totales 
        $hoteles = Hotel::count();
        $restaurantes = Restaurante::count();
        $agrupaciones = Agrupacion::count();
        $participantes = Participante::count();

        //cantidad de empresas por tipo del sector que pertenecen
        $tipoEmpresa = new stdClass();
        $tipoEmpresa->micro = Empresa::where('sector', 0)->count();
        $tipoEmpresa->promMicro = ($tipoEmpresa->micro * 100)/ $empresas;
        $tipoEmpresa->pequena = Empresa::where('sector', 1)->count();
        $tipoEmpresa->promPequena = ($tipoEmpresa->pequena * 100)/ $empresas;
        $tipoEmpresa->mediana = Empresa::where('sector', 2)->count();
        $tipoEmpresa->promMediana = ($tipoEmpresa->mediana * 100)/ $empresas;
        $tipoEmpresa->grande = Empresa::where('sector', 3)->count();
        $tipoEmpresa->promGrande = ($tipoEmpresa->grande * 100)/ $empresas;

        //cantidad de empresas patrocinadoras, proveedoras y consumidoras de servicios
        $patrocinadoras = CostoProvee::where('subsidio', 1)->get();
        $proveedoras = CostoProvee::where('subsidio', 0)->get();
        $consumidoras = IngresoConsume::all();
        $p = array();
        $pr = array();
        $c = array();

        //recorrer para sacar las empresas que se repiten
        foreach ($patrocinadoras as $patro) {
            $aux = false;
            if (!isset($p[0])) {//si esta vacio mete el registro
                array_push($p, $patro);
            }else{//comprueba que ya la empresa no exista como patrocinadora
                foreach ($p as $pa) {
                    if ($pa->idProveedor == $patro->idProveedor) {
                        $aux = true;//si lo encuentra sice true
                    }
                }
                if ($aux == false) {
                    array_push($p, $patro);//si no lo consigue lo ingresa
                }
            }
        }
        foreach ($proveedoras as $provee) {
            $aux = false;
            if (!isset($pr[0])) {//si esta vacio mete el registro
                array_push($pr, $provee);
            }else{//comprueba que ya la empresa no exista como proveedora
                foreach ($pr as $pro) {
                    if ($pro->idProveedor == $provee->idProveedor) {
                        $aux = true;//si lo encuentra sice true
                    }
                }
                if ($aux == false) {
                    array_push($pr, $provee);//si no lo consigue lo ingresa
                }
            }
        }
        foreach ($consumidoras as $consume) {
            $aux = false;
            if (!isset($c[0])) {//si esta vacio mete el registro
                array_push($c, $consume);
            }else{//comprueba que ya la empresa no exista como Consumidora
                foreach ($c as $con) {
                    if ($con->idConsumidor == $consume->idConsumidor) {
                        $aux = true;//si lo encuentra sice true
                    }
                }
                if ($aux == false) {
                    array_push($c, $consume);//si no lo consigue lo ingresa
                }
            }
        }

        $cantidadEmpresa = new stdClass();
        $cantidadEmpresa->proveedoras = count($pr);
        $cantidadEmpresa->patrocinadoras = count($p);
        $cantidadEmpresa->consumidoras = count($c);

        /*cantidad de empleos generados por eventos*/
        $cantidadEmpleos = Actividad::all()->sum('empleo');

        /*cantidad de personas proyectadas, la capacidad de todos los palcos*/
        $palco = Palco::all()->sum('capacidad');
        $palcoSub = PalcoSub::all()->sum('capacidad');
        $capacidad = $palco + $palcoSub;

        //calcular las horas de entretenimiento pasadas y por venir
        $date = Carbon::now();
        $eventoPasado = Evento::where('fechaFin' ,'<', $date)->get();
        $eventoProximo = Evento::where('fechaFin' ,'>', $date)->get();
        $horasPasadas = 0;
        $horasProximas = 0;
        foreach ($eventoProximo as $evento) {
            $actividades = Actividad::where('idEvento', $evento->idEvento)->get();
        
        
            foreach ($actividades as $act) {
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                //calcular el aforo total y horas de entretenimiento
                if ($act->lugar == 1) {//mismo lugar
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasProximas += $inicio->diffInHours($fin);
                }else{//diferentes lugares (buscar en cada sub actividad)
                    foreach ($sub as $s) {
                        //calcula horas
                        $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                        $inicio = new Carbon($direccion[0]->fechaInicio);
                        $fin = new Carbon($direccion[0]->fechaFin);
                        $horasProximas += $inicio->diffInHours($fin);
                        
                    }
                } 
            }
        }

        foreach ($eventoPasado as $evento) {
            $actividades = Actividad::where('idEvento', $evento->idEvento)->get();
        
        
            foreach ($actividades as $act) {
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                //calcular el aforo total y horas de entretenimiento
                if ($act->lugar == 1) {//mismo lugar
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasPasadas += $inicio->diffInHours($fin);
                }else{//diferentes lugares (buscar en cada sub actividad)
                    foreach ($sub as $s) {
                        //calcula horas
                        $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                        $inicio = new Carbon($direccion[0]->fechaInicio);
                        $fin = new Carbon($direccion[0]->fechaFin);
                        $horasPasadas += $inicio->diffInHours($fin);
                        
                    }
                } 
            }
        }
       

        return response()->json(['error'=>false,'eventos' => $eventos, 'empresas' => $empresas, 'tipoEmpresa' => $tipoEmpresa, 'cantidadEmpresa' => $cantidadEmpresa, 'cantidadEmpleos' => $cantidadEmpleos, 'capacidad' => $capacidad, 'hoteles' => $hoteles, 'restaurantes' => $restaurantes, 'agrupaciones' => $agrupaciones, 'participantes' => $participantes, 'horasPasadas' => $horasPasadas, 'horasProximas' => $horasProximas]);
    }

    public function inicioAgrupacion(Request $request){
        //TOTAL DE EVENTO
        $eventos = Evento::all()->count();
        
        //TOTAL DE AGRUPACIONES
        $agrupaciones = Agrupacion::all()->count();
        //TOTAL DE ARTISTAS
        $artistas = Agrupacion::all()->sum('nempleados');
        //totales 
        $hoteles = Hotel::count();
        $restaurantes = Restaurante::count();
        $empresas = Empresa::count();
        $participantes = Participante::count();
        
        /*cantidad de personas proyectadas, la capacidad de todos los palcos*/
        $palco = Palco::all()->sum('capacidad');
        $palcoSub = PalcoSub::all()->sum('capacidad');
        $capacidad = $palco + $palcoSub;
        
        //genero de las agrupaciones musicales
        $genero = Genero::all();
        $nombreGenero = array();
        $cantidadGenero = array();
        
        foreach ($genero as $g) {

            $cant = Agrupacion::where('genero' , $g->idGenero)->count();
            //los nombres en un arreglo formato para la grafia
            array_push($nombreGenero, $g->nombre);
            //array dentro de array con las cantidades formato para las graficas
            $aux = array();
            array_push($aux, $cant);
            array_push($cantidadGenero, $aux);

        }

        //promedio de mujeres y hombres dentro de las agrupaciones
        $agrupa = Agrupacion::all();
        $cantPersonas = 0;
        $cantHombres = 0;
        $cantMujeres = 0;
        $promHombres = 0;
        $promMujeres = 0;
        foreach ($agrupa as $agrupacion) {
            $cantPersonas += $agrupacion->nempleados;
            $cantHombres += $agrupacion->cantHombres;
            $cantMujeres+= $agrupacion->cantMujeres;
        }

        $promHombres = ($cantHombres*100)/$cantPersonas;
        $promMujeres = ($cantMujeres*100)/$cantPersonas;

        //calcular las horas de entretenimiento pasadas y por venir
        $date = Carbon::now();
        $eventoPasado = Evento::where('fechaFin' ,'<', $date)->get();
        $eventoProximo = Evento::where('fechaFin' ,'>', $date)->get();
        $horasPasadas = 0;
        $horasProximas = 0;
        foreach ($eventoProximo as $evento) {
            $actividades = Actividad::where('idEvento', $evento->idEvento)->get();
        
        
            foreach ($actividades as $act) {
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                //calcular el aforo total y horas de entretenimiento
                if ($act->lugar == 1) {//mismo lugar
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasProximas += $inicio->diffInHours($fin);
                }else{//diferentes lugares (buscar en cada sub actividad)
                    foreach ($sub as $s) {
                        //calcula horas
                        $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                        $inicio = new Carbon($direccion[0]->fechaInicio);
                        $fin = new Carbon($direccion[0]->fechaFin);
                        $horasProximas += $inicio->diffInHours($fin);
                        
                    }
                } 
            }
        }

        foreach ($eventoPasado as $evento) {
            $actividades = Actividad::where('idEvento', $evento->idEvento)->get();
        
        
            foreach ($actividades as $act) {
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                //calcular el aforo total y horas de entretenimiento
                if ($act->lugar == 1) {//mismo lugar
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasPasadas += $inicio->diffInHours($fin);
                }else{//diferentes lugares (buscar en cada sub actividad)
                    foreach ($sub as $s) {
                        //calcula horas
                        $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                        $inicio = new Carbon($direccion[0]->fechaInicio);
                        $fin = new Carbon($direccion[0]->fechaFin);
                        $horasPasadas += $inicio->diffInHours($fin);
                        
                    }
                } 
            }
        }


        return response()->json(['error'=>false,'eventos' => $eventos, 'empresas' => $empresas,'capacidad' => $capacidad, 'agrupaciones' => $agrupaciones, 'artistas' => $artistas, 'genero' => $nombreGenero, 'cantidadGenero' => $cantidadGenero, 'promHombres' => $promHombres, 'promMujeres' => $promMujeres, 'participantes' => $participantes, 'hoteles' => $hoteles, 'restaurantes' => $restaurantes, 'horasPasadas' => $horasPasadas, 'horasProximas' => $horasProximas]);
    }

    public function inicioParticipante(Request $request){
        //TOTAL DE EVENTO
        $eventos = Evento::all()->count();
        //participantes juridicos
        $juridicos = Participante::where('tipo', 1)->count();
        //participantes naturales
        $naturales = Participante::where('tipo', 0)->count();
        //total de participantes
        $participantes = Participante::all()->count();
        //cantidad de premios
        $premio = Premio::all()->count();
        //totales 
        $hoteles = Hotel::count();
        $restaurantes = Restaurante::count();
        $empresas = Empresa::count();
        $agrupaciones = Agrupacion::count();
        
        
        /*cantidad de personas proyectadas, la capacidad de todos los palcos*/
        $palco = Palco::all()->sum('capacidad');
        $palcoSub = PalcoSub::all()->sum('capacidad');
        $capacidad = $palco + $palcoSub;

        //promedio de edad, hombres y mujeres
        $parti = Participante::all();
        $cantParticipante = Participante::count();
        $totalEdad=0;

       
        $cantMujeres = Participante::where('sexo' , 0)->count();
        $cantHombres = Participante::where('sexo' , 1)->count();
            
        $promHombres = ($cantHombres * 100) / $cantParticipante;
        $promMujeres = ($cantMujeres * 100) / $cantParticipante;

        //calcular las horas de entretenimiento pasadas y por venir
        $date = Carbon::now();
        $eventoPasado = Evento::where('fechaFin' ,'<', $date)->get();
        $eventoProximo = Evento::where('fechaFin' ,'>', $date)->get();
        $horasPasadas = 0;
        $horasProximas = 0;
        foreach ($eventoProximo as $evento) {
            $actividades = Actividad::where('idEvento', $evento->idEvento)->get();
        
        
            foreach ($actividades as $act) {
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                //calcular el aforo total y horas de entretenimiento
                if ($act->lugar == 1) {//mismo lugar
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasProximas += $inicio->diffInHours($fin);
                }else{//diferentes lugares (buscar en cada sub actividad)
                    foreach ($sub as $s) {
                        //calcula horas
                        $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                        $inicio = new Carbon($direccion[0]->fechaInicio);
                        $fin = new Carbon($direccion[0]->fechaFin);
                        $horasProximas += $inicio->diffInHours($fin);
                        
                    }
                } 
            }
        }

        foreach ($eventoPasado as $evento) {
            $actividades = Actividad::where('idEvento', $evento->idEvento)->get();
        
        
            foreach ($actividades as $act) {
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                //calcular el aforo total y horas de entretenimiento
                if ($act->lugar == 1) {//mismo lugar
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasPasadas += $inicio->diffInHours($fin);
                }else{//diferentes lugares (buscar en cada sub actividad)
                    foreach ($sub as $s) {
                        //calcula horas
                        $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                        $inicio = new Carbon($direccion[0]->fechaInicio);
                        $fin = new Carbon($direccion[0]->fechaFin);
                        $horasPasadas += $inicio->diffInHours($fin);
                        
                    }
                } 
            }
        }
        

        return response()->json(['error'=>false,'eventos' => $eventos,'capacidad' => $capacidad, 'juridicos' => $juridicos, 'naturales' => $naturales, 'participantes' => $participantes, 'hombres' => $promHombres, 'mujeres' => $promMujeres, 'premio' => $premio, 'agrupaciones' => $agrupaciones, 'hoteles' => $hoteles, 'restaurantes' => $restaurantes, 'empresas' => $empresas, 'horasPasadas' => $horasPasadas, 'horasProximas' => $horasProximas]);
    }

    public function inicioPublico(Request $request){
        //TOTAL DE EVENTO
        $eventos = Evento::all()->count();

        //cantidad de actividades
        $act = Actividad::count();
        $sub = EventoActividad::count();
        $activi = $act + $sub;
        
        /*cantidad de personas proyectadas, la capacidad de todos los palcos*/
        $palco = Palco::all()->sum('capacidad');
        $palcoSub = PalcoSub::all()->sum('capacidad');
        $capacidad = $palco + $palcoSub;

        //cantidad de hoteles restaurantes, agrupaciones y lugares
        $hoteles = Hotel::count();
        $restaurantes = Restaurante::count();
        $lugares = Lugar::count();
        $agrupaciones = Agrupacion::count();


        //calcular las horas de entretenimiento pasadas y por venir
        $date = Carbon::now();
        $eventoPasado = Evento::where('fechaFin' ,'<', $date)->get();
        $eventoProximo = Evento::where('fechaFin' ,'>', $date)->get();
        $horasPasadas = 0;
        $horasProximas = 0;
        foreach ($eventoProximo as $evento) {
            $actividades = Actividad::where('idEvento', $evento->idEvento)->get();
        
        
            foreach ($actividades as $act) {
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                //calcular el aforo total y horas de entretenimiento
                if ($act->lugar == 1) {//mismo lugar
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasProximas += $inicio->diffInHours($fin);
                }else{//diferentes lugares (buscar en cada sub actividad)
                    foreach ($sub as $s) {
                        //calcula horas
                        $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                        $inicio = new Carbon($direccion[0]->fechaInicio);
                        $fin = new Carbon($direccion[0]->fechaFin);
                        $horasProximas += $inicio->diffInHours($fin);
                        
                    }
                } 
            }
        }

        foreach ($eventoPasado as $evento) {
            $actividades = Actividad::where('idEvento', $evento->idEvento)->get();
        
        
            foreach ($actividades as $act) {
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                //calcular el aforo total y horas de entretenimiento
                if ($act->lugar == 1) {//mismo lugar
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horasPasadas += $inicio->diffInHours($fin);
                }else{//diferentes lugares (buscar en cada sub actividad)
                    foreach ($sub as $s) {
                        //calcula horas
                        $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                        $inicio = new Carbon($direccion[0]->fechaInicio);
                        $fin = new Carbon($direccion[0]->fechaFin);
                        $horasPasadas += $inicio->diffInHours($fin);
                        
                    }
                } 
            }
        }
        
        

        return response()->json(['error'=>false,'eventos' => $eventos,'capacidad' => $capacidad, 'actividades' => $activi, 'hoteles' => $hoteles, 'restaurantes' => $restaurantes, 'lugares' => $lugares, 'agrupaciones' => $agrupaciones, 'horasPasadas' => $horasPasadas, 'horasProximas' => $horasProximas]);
    }


}
