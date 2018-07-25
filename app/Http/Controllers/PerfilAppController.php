<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Empresa;
use App\Modelos\CostoProvee;
use App\Modelos\IngresoConsume;
use App\Modelos\ActividadEmpresa;
use App\Modelos\Actividad;
use App\Modelos\CostoEvento;
use App\Modelos\IngresoEvento;
use App\Modelos\Evento;
use App\Modelos\TipoPresupuesto;
use App\Modelos\Ciudad;
use App\Modelos\Departamento;
use App\Modelos\EventoActividad;
use App\Modelos\Palco;
use App\Modelos\PalcoSub;
use App\Modelos\DireccionActividad;
use App\Modelos\DireccionSub;
use App\Modelos\Agrupacion;
use App\Modelos\Actividadagrupacion;
use App\Modelos\Premio;
use App\Modelos\Participante;
use App\Modelos\Actividadparticipante;
use Carbon\Carbon;
use DB;
use stdClass;

class PerfilAppController extends Controller {


    public function perfilEmpresa(Request $request){
        $actividades = array();
        $user = json_decode($request->user);
        $empresa = Empresa::where('nit' , $user->cedula)->get();
        $ciudad = Ciudad::find($empresa[0]->ciudad);
        $departamento = Departamento::find($empresa[0]->departamento);
        $empresa[0]->nombreCiudad = $ciudad->nombre;
        $empresa[0]->nombreDepartamento = $departamento->nombre;
       
        //Busca Las actividades en las que participó
        $actividadempresa = ActividadEmpresa::where('idEmpresa' , $empresa[0]->idEmpresa)->get();
         //Cuenta en la cantidad de actividades que ha participado
        $empresa->cantActividades = count($actividadempresa);
        $premios = Premio::where('idParticipante' , $empresa[0]->idEmpresa)->where('tipoParticipante' , 1)->get();
        foreach ($premios as $p) {
            $act = Actividad::find($p->idActividad);
            $evento = Evento::find($act->idEvento);
            $p->nombreActividad = $act->nombre;
            $p->nombreEvento = $evento->descripcion;
        }
        $empresa[0]->premios = $premios;

        foreach ($actividadempresa as $a) {
           $act = Actividad::find($a->idActividad);
           $evento = Evento::find($act->idEvento);
           $act->evento = $evento->descripcion;
         
          //TIPOS
           if ($act->tipo == 0) {
                $act->tipoD = "Encuentros y Espectáculos Deportivos";
            }
            if ($act->tipo == 1) {
                 $act->tipoD = "Eventos Religiosos";
            }
            if ($act->tipo == 2) {
                 $act->tipoD = "Congregaciones Políticas";
            }            
            if ($act->tipo == 3) {
                 $act->tipoD = "Conciertos y Presentaciones Musicales";
            } 
            if ($act->tipo == 4) {
                 $act->tipoD = "Ferias, Festivales, Rodeos y Corralejas";
            }
            if ($act->tipo == 5) {
                 $act->tipoD = "Congresos, Simposios, Seminarios o similares";
            } 
            if ($act->tipo == 6) {
                 $act->tipoD = "Teatro";
            } 
            if ($act->tipo == 7) {
                 $act->tipoD = "Exhibiciones (Desfiles de Modas, Exposiciones, etc)";
            } 
            if ($act->tipo == 8) {
                 $act->tipoD = "Atracciones y Entretenimiento (Parques de Atracciones, Ciudades de Hierro, Circos, etc)";
            } 
            if ($act->tipo == 9) {
                 $act->tipoD = "Otros (Marchas, Ventas, etc)";
            } 

          //MODALIDAD
            if ($act->modalidad == 0) {
                $act->modalidadD = "Sin boleta de ingreso";
            }
            if ($act->modalidad == 1) {
                $act->modalidadD = "Con boleta de ingreso";
            }
            if ($act->modalidad == 2) {
                $act->modalidadD = "Con valor comercial";
            }
            
            $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
            //sumar la cantidad de subactividades de todo el evento
            //$cantidadSub += count($sub);
            //$act->cantSub = count($sub);
            //calcular el aforo total y horas de entretenimiento
            $aforo = 0;
            if ($act->lugar == 1) {//mismo lugar
                //calcula aforo
                $palco = Palco::where('idActividad', $act->idActividad)->get();
                
                $act->palco = $palco;

                foreach ($palco as $p) {
                    $aforo += $p->capacidad;
                }

                //calcula hora
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $act->direccion = $direccion ;
                $inicio = new Carbon($direccion[0]->fechaInicio);
                $fin = new Carbon($direccion[0]->fechaFin);
                //$horas += $inicio->diffInHours($fin);
                $act->horas =$inicio->diffInHours($fin);
                //dd($interval);
            }else{//diferentes lugares (buscar en cada sub actividad)
                foreach ($sub as $s) {
                    //calcula aforo
                    $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                    

                    $s->palco = $palco;
                    foreach ($palco as $p) {
                        $aforo += $p->capacidad;
                    }

                    //calcula horas
                    $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                    $s->direccion = $direccion;
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $sub->horas = $inicio->diffInHours($fin);

                    $act->horas += $inicio->diffInHours($fin);
                }
            } 
            $act->sub = $sub;
            $act->aforo = $aforo;
  

           array_push($actividades , $act);

        }
        //Asignar las actividades a la empresa
        $empresa[0]->actividades = $actividades;
        
        //donde es proveedor, patrocinador y consumidor la empresa

        //busco los costos del evento
        $costos = CostoProvee::where('idProveedor', $empresa[0]->idEmpresa)->get();

        $todos = array();

        foreach ($costos as $costo) {
            $c = CostoEvento::find($costo->idCosto);
            $tipoCosto = TipoPresupuesto::find($c->tipo);
            $evento = Evento::find($c->idEvento);
            $costo->evento = $evento->descripcion;
            $costo->nombre = $c->nombre;
            $costo->tipoD = $tipoCosto->nombre;
            array_push($todos, $costo);
        }

        //busco los ingresos del evento
        $ingresos = IngresoConsume::where('idConsumidor', $empresa[0]->idEmpresa)->get();
        foreach ($ingresos as $ingreso) {
            $i = IngresoEvento::find($ingreso->idIngreso);
            $tipoingreso = TipoPresupuesto::find($i->tipo);
            $evento = Evento::find($i->idEvento);
            $ingreso->evento = $evento->descripcion;
            $ingreso->nombre = $i->nombre;
            $ingreso->subsidio = 3;
            $ingreso->tipoD = $tipoingreso->nombre;
            array_push($todos, $ingreso);       
        }
        $empresa[0]->historial = $todos;
        return response()->json(['error'=>false, 'empresa' =>$empresa]);
    } 
       
    public function perfilAgrupacion(Request $request){
        $horasTotal = 0;
        $aforoTotal = 0;
        $actividades = array();
        $user = json_decode($request->user);
        $agrupacion = Agrupacion::where('nit' , $user->cedula)->get();
        $ciudad = Ciudad::find($agrupacion[0]->ciudad);
        $departamento = Departamento::find($agrupacion[0]->departamento);
        $agrupacion[0]->nombreCiudad = $ciudad->nombre;
        $agrupacion[0]->nombreDepartamento = $departamento->nombre;

        //Busca Las actividades en las que participó
        $actividadagrupacion = Actividadagrupacion::where('idAgrupacion' , $agrupacion[0]->idAgrupacion)->get();
         //Cuenta en la cantidad de actividades que ha participado
        $agrupacion[0]->cantActividades = count($actividadagrupacion);
        
        $premios = Premio::where('idParticipante' , $agrupacion[0]->idAgrupacion)->where('tipoParticipante' , 2)->get();
        foreach ($premios as $p) {
            $act = Actividad::find($p->idActividad);
            $evento = Evento::find($act->idEvento);
            $p->nombreActividad = $act->nombre;
            $p->nombreEvento = $evento->descripcion;
        }
        $agrupacion[0]->premios = $premios;

         foreach ($actividadagrupacion as $a) {
           $act = Actividad::find($a->idActividad);
           $evento = Evento::find($act->idEvento);
           $act->evento = $evento->descripcion;
        
           //TIPOS
           if ($act->tipo == 0) {
                $act->tipoD = "Encuentros y Espectáculos Deportivos";
            }
            if ($act->tipo == 1) {
                 $act->tipoD = "Eventos Religiosos";
            }
            if ($act->tipo == 2) {
                 $act->tipoD = "Congregaciones Políticas";
            }            
            if ($act->tipo == 3) {
                 $act->tipoD = "Conciertos y Presentaciones Musicales";
            } 
            if ($act->tipo == 4) {
                 $act->tipoD = "Ferias, Festivales, Rodeos y Corralejas";
            }
            if ($act->tipo == 5) {
                 $act->tipoD = "Congresos, Simposios, Seminarios o similares";
            } 
            if ($act->tipo == 6) {
                 $act->tipoD = "Teatro";
            } 
            if ($act->tipo == 7) {
                 $act->tipoD = "Exhibiciones (Desfiles de Modas, Exposiciones, etc)";
            } 
            if ($act->tipo == 8) {
                 $act->tipoD = "Atracciones y Entretenimiento (Parques de Atracciones, Ciudades de Hierro, Circos, etc)";
            } 
            if ($act->tipo == 9) {
                 $act->tipoD = "Otros (Marchas, Ventas, etc)";
            } 

          //MODALIDAD
            if ($act->modalidad == 0) {
                $act->modalidadD = "Sin boleta de ingreso";
            }
            if ($act->modalidad == 1) {
                $act->modalidadD = "Con boleta de ingreso";
            }
            if ($act->modalidad == 2) {
                $act->modalidadD = "Con valor comercial";
            }
            
            $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
            //sumar la cantidad de subactividades de todo el evento
            //$cantidadSub += count($sub);
            //$act->cantSub = count($sub);
            //calcular el aforo total y horas de entretenimiento
            $aforo = 0;
            if ($act->lugar == 1) {//mismo lugar
                //calcula aforo
                $palco = Palco::where('idActividad', $act->idActividad)->get();
                
                $act->palco = $palco;

                foreach ($palco as $p) {
                    $aforo += $p->capacidad;
                    $aforoTotal += $aforo;
                }

                //calcula hora
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $act->direccion = $direccion ;
                $inicio = new Carbon($direccion[0]->fechaInicio);
                $fin = new Carbon($direccion[0]->fechaFin);
                //$horas += $inicio->diffInHours($fin);
                $act->horas =$inicio->diffInHours($fin);
                $horasTotal += $act->horas;
                //dd($interval);
            }else{//diferentes lugares (buscar en cada sub actividad)
                foreach ($sub as $s) {
                    //calcula aforo
                    $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                    

                    $s->palco = $palco;
                    foreach ($palco as $p) {
                        $aforo += $p->capacidad;
                        $aforoTotal += $aforo;
                    }

                    //calcula horas
                    $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                    $s->direccion = $direccion;
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $sub->horas = $inicio->diffInHours($fin);
                    $horasTotal += $sub->horas;
                    $act->horas += $inicio->diffInHours($fin);
                }
            } 
            $act->sub = $sub;
            $act->aforo = $aforo;
           array_push($actividades , $act);

        }
         //Asignar las actividades a la empresa
        $agrupacion[0]->actividades = $actividades;
        $agrupacion[0]->horas = $horasTotal;
        $agrupacion[0]->aforo = $aforoTotal;

       
        return response()->json(['error'=>false, 'agrupacion' =>$agrupacion]);
    }

     public function perfilParticipante(Request $request){
        $horasTotal = 0;
        $aforoTotal = 0;
        $actividades = array();
        $user = json_decode($request->user);
        $participante = Participante::where('cedula' , $user->cedula)->get();
        $ciudad = Ciudad::find($participante[0]->ciudad);
        $departamento = Departamento::find($participante[0]->departamento);
        $participante[0]->nombreCiudad = $ciudad->nombre;
        $participante[0]->nombreDepartamento = $departamento->nombre;

        //Busca Las actividades en las que participó
        $actividadparticipante = Actividadparticipante::where('idParticipante' , $participante[0]->idParticipante)->get();
         //Cuenta en la cantidad de actividades que ha participado
        $participante[0]->cantActividades = count($actividadparticipante);
        $premios = Premio::where('idParticipante' , $participante[0]->idParticipante)->where('tipoParticipante' , 0)->get();
        foreach ($premios as $p) {
            $act = Actividad::find($p->idActividad);
            $evento = Evento::find($act->idEvento);
            $p->nombreActividad = $act->nombre;
            $p->nombreEvento = $evento->descripcion;
        }
        $participante[0]->premios = $premios;

        foreach ($actividadparticipante as $a) {
           $act = Actividad::find($a->idActividad);
           $evento = Evento::find($act->idEvento);
           
           $act->evento = $evento->descripcion;
          
           //TIPOS
           if ($act->tipo == 0) {
                $act->tipoD = "Encuentros y Espectáculos Deportivos";
            }
            if ($act->tipo == 1) {
                 $act->tipoD = "Eventos Religiosos";
            }
            if ($act->tipo == 2) {
                 $act->tipoD = "Congregaciones Políticas";
            }            
            if ($act->tipo == 3) {
                 $act->tipoD = "Conciertos y Presentaciones Musicales";
            } 
            if ($act->tipo == 4) {
                 $act->tipoD = "Ferias, Festivales, Rodeos y Corralejas";
            }
            if ($act->tipo == 5) {
                 $act->tipoD = "Congresos, Simposios, Seminarios o similares";
            } 
            if ($act->tipo == 6) {
                 $act->tipoD = "Teatro";
            } 
            if ($act->tipo == 7) {
                 $act->tipoD = "Exhibiciones (Desfiles de Modas, Exposiciones, etc)";
            } 
            if ($act->tipo == 8) {
                 $act->tipoD = "Atracciones y Entretenimiento (Parques de Atracciones, Ciudades de Hierro, Circos, etc)";
            } 
            if ($act->tipo == 9) {
                 $act->tipoD = "Otros (Marchas, Ventas, etc)";
            } 

          //MODALIDAD
            if ($act->modalidad == 0) {
                $act->modalidadD = "Sin boleta de ingreso";
            }
            if ($act->modalidad == 1) {
                $act->modalidadD = "Con boleta de ingreso";
            }
            if ($act->modalidad == 2) {
                $act->modalidadD = "Con valor comercial";
            }
            
            $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
            //sumar la cantidad de subactividades de todo el evento
            //$cantidadSub += count($sub);
            //$act->cantSub = count($sub);
            //calcular el aforo total y horas de entretenimiento
            $aforo = 0;
            if ($act->lugar == 1) {//mismo lugar
                //calcula aforo
                $palco = Palco::where('idActividad', $act->idActividad)->get();
                
                $act->palco = $palco;

                foreach ($palco as $p) {
                    $aforo += $p->capacidad;
                    $aforoTotal += $aforo;
                }

                //calcula hora
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $act->direccion = $direccion ;
                $inicio = new Carbon($direccion[0]->fechaInicio);
                $fin = new Carbon($direccion[0]->fechaFin);
                //$horas += $inicio->diffInHours($fin);
                $act->horas =$inicio->diffInHours($fin);
                $horasTotal += $act->horas;
                //dd($interval);
            }else{//diferentes lugares (buscar en cada sub actividad)
                foreach ($sub as $s) {
                    //calcula aforo
                    $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                    

                    $s->palco = $palco;
                    foreach ($palco as $p) {
                        $aforo += $p->capacidad;
                        $aforoTotal += $aforo;
                    }

                    //calcula horas
                    $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                    $s->direccion = $direccion;
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $sub->horas = $inicio->diffInHours($fin);
                    $horasTotal += $sub->horas;
                    $act->horas += $inicio->diffInHours($fin);
                }
            } 
            $act->sub = $sub;
            $act->aforo = $aforo;
           array_push($actividades , $act);

        }
         //Asignar las actividades a la empresa
        $participante[0]->actividades = $actividades;
        $participante[0]->horas = $horasTotal;
        $participante[0]->aforo = $aforoTotal;
 
        return response()->json(['error'=>false, 'participante' =>$participante]);
    }

 
}
