<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Poblacion;
use App\Modelos\Evento;
use App\Modelos\Actividad;
use App\Modelos\EventoActividad;
use App\Modelos\Palco;
use App\Modelos\PalcoSub;
use App\Modelos\DireccionActividad;
use App\Modelos\DireccionSub;
use App\Modelos\Junta;
use App\Modelos\Cargo;
use App\Modelos\Colormodalidad;
use App\Modelos\CostoEvento;
use App\Modelos\IngresoEvento;
use App\Modelos\CostoProvee;
use App\Modelos\IngresoConsume;
use App\Modelos\Agrupacion;
use App\Modelos\Hotel;
use App\Modelos\Restaurante;
use App\Modelos\Premio;
use App\Modelos\Lugar;
use App\Modelos\Empresa;
use App\Modelos\Info;
use App\Modelos\Genero;
use App\Modelos\Participante;
use App\Modelos\Consumopalco;
use App\Modelos\Consumocalle;
use App\Modelos\Actividadagrupacion;
use App\Modelos\Actividadparticipante;
use App\Modelos\Actividadempresa;
use DB;
use stdClass;
use Carbon\Carbon;

class ReporteController extends Controller {

    //trae todos los datos de poblacion 
    public function allPoblacion(Request $request){
        $mujeres = 0;
        $hombres = 0;
        $total = 0;
        $aforo = 0;
        $evento = Evento::find($request->idEvento);
        $circulante = $evento->poblacionCirculante;
        $objetivo = $evento->poblacion;
        $poblacion = poblacion::where('idEvento', $request->idEvento)->get();

        $hombres = $poblacion[0]->_0a18H + $poblacion[0]->_19a64H + $poblacion[0]->mayor64H + $poblacion[0]->indigenaH + $poblacion[0]->afroColombianaH + $poblacion[0]->raizalH + $poblacion[0]->puebloRomH + $poblacion[0]->mestizaH + $poblacion[0]->palenqueraH + $poblacion[0]->desplazadosH + $poblacion[0]->discapacitadosH + $poblacion[0]->victimasH; 
        
        $mujeres = $poblacion[0]->_0a18M + $poblacion[0]->_19a64M + $poblacion[0]->mayor64M + $poblacion[0]->indigenaM + $poblacion[0]->afroColombianaM + $poblacion[0]->raizalM + $poblacion[0]->puebloRomM + $poblacion[0]->mestizaM + $poblacion[0]->palenqueraM + $poblacion[0]->desplazadosM + $poblacion[0]->discapacitadosM + $poblacion[0]->victimasM;
        $total = $hombres + $mujeres;

        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        foreach ($actividades as $act) {
            if ($act->lugar == 1) {//mismo lugar
                $palco = Palco::where('idActividad', $act->idActividad)->get();
                foreach ($palco as $key => $p) {
                    $aforo += $p->capacidad;
                }
            }else{//otro lugar
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                foreach ($sub as $s) {
                    $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                    foreach ($palco as $key => $p) {
                        $aforo += $p->capacidad;
                    }   
                }
            }
        }


        return response()->json(['error'=>false, 'poblacion' => $poblacion[0], 'hombres' => $hombres, 'mujeres' => $mujeres, 'total' => $total, 'aforo' => $aforo, 'circulante' => $circulante, 'objetivo' => $objetivo]);
    }

    //trae todos los datos de poblacion 
    public function allConsumo(Request $request){
        $consumoT = new stdClass();
        //PALCO
        $consumopalco = Consumopalco::where('idEvento', $request->idEvento)->get();
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
        $consumocalle = Consumocalle::where('idEvento', $request->idEvento)->get();
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
       
        return response()->json(['error'=>false, 'consumo' => $consumoT]);
    }

    public function EmpresasColaboradoras(Request $request){
        $proveedores = array();
        $consumidores = array();
        $patrocinadores = array();
        $cantproveeLocal = 0;
        $cantproveeExterno = 0;
        $cantconsumeLocal = 0;
        $cantconsumeExterno = 0;
        $cantpatroLocal = 0;
        $cantpatroExterno = 0;
        $totales = new stdClass();
        $evento = Evento::find($request->idEvento);
        //buscar todos los costos y las empresas que patrocinan o subsidian los costos del evento
        $costos = CostoEvento::where('idEvento', $request->idEvento)->get();
        foreach ($costos as $c) {
            $costo = CostoProvee::where('idCosto', $c->idCosto)->get();
            foreach ($costo as $co) {
                $empresa = Empresa::find($co->idProveedor);

                if ($co->subsidio == 1) {
                    array_push($patrocinadores, $co);
                    if($empresa->departamento == $evento->idDepartamento && $empresa->ciudad == $evento->idCiudad){
                        $cantpatroLocal++;
                    }else{
                        $cantpatroExterno++;
                    }
                }else{
                    array_push($proveedores, $co);
                    if($empresa->departamento == $evento->idDepartamento && $empresa->ciudad == $evento->idCiudad){
                        $cantproveeLocal++;
                    }else{
                        $cantproveeExterno++;
                    }
                }
            }
        }

        //buscar todos los ingresos y las empresas las cuales consumen los ingresos del evento
        $ingresos = IngresoEvento::where('idEvento', $request->idEvento)->get();
        foreach ($ingresos as $i) {
            $ingreso = IngresoConsume::where('idIngreso', $i->idIngreso)->get();
            foreach ($ingreso as $in) {
                $empresa = Empresa::find($in->idConsumidor);
                array_push($consumidores, $in);
                if($empresa->departamento == $evento->idDepartamento && $empresa->ciudad == $evento->idCiudad){
                    $cantconsumeLocal++;
                }else{
                    $cantconsumeExterno++;
                }   
            }
        }
        if (count($consumidores)!=0) {
            # code...
            $totales->consumidores = count($consumidores);
            $totales->consumeLocal = $cantconsumeLocal*100/$totales->consumidores;
            $totales->consumeExtreno = $cantconsumeExterno*100/$totales->consumidores;
        }else{
            $totales->consumidores = 0;
            $totales->consumeLocal = 0;
            $totales->consumeExtreno = 0;    
        }

        if (count($proveedores)!=0) {
            # code...
            $totales->proveedores = count($proveedores);
            $totales->proveeLocal = $cantproveeLocal*100/$totales->proveedores;
            $totales->proveeExtreno = $cantproveeExterno*100/$totales->proveedores;
        
        }else{
            $totales->proveedores = 0;
            $totales->proveeLocal = 0;
            $totales->proveeExtreno = 0;
            
        }
        if (count($patrocinadores)!=0) {
            # code...
            $totales->patrocinadores = count($patrocinadores);
            $totales->patroLocal = $cantpatroLocal*100/$totales->patrocinadores;
            $totales->patroExtreno = $cantpatroExterno*100/$totales->patrocinadores;
        
        }else{
            $totales->patrocinadores = 0;
            $totales->patroLocal = 0;
            $totales->patroExtreno = 0;
            
        }
        

        return response()->json(['error'=>false, 'total' => $totales]);
    }
    
    //trae todo los datos de los organizadores del evento
    public function allJunta(Request $request){
        $junta = Junta::where('idEvento', $request->idEvento)->get();
        $cargos = Cargo::where('idEvento', $request->idEvento)->get();
        $nivel = array();
        $mujeres = 0;
        $hombres = 0;
        $total = count($junta);
        $edad = 0;
        $edadH = 0;
        $edadM = 0;
        $edadMin = 0;
        $edadMax = 0;
        $edadMinH = 0;
        $edadMaxH = 0;
        $edadMinM = 0;
        $edadMaxM = 0;
        $e1825 = 0;
        $e2640 = 0;
        $e4155 = 0;
        $eM56 = 0;
        $e1825H = 0;
        $e2640H = 0;
        $e4155H = 0;
        $eM56H = 0;
        $e1825M = 0;
        $e2640M = 0;
        $e4155M = 0;
        $eM56M = 0;
        //dd($junta);
        foreach ($junta as $j) {
            //sumatoria de edades
            $edad += $j->edad;
            //calcular escala de rango de fechas
            if ($j->edad >= 18 & $j->edad <= 25) {
                $e1825++;
            }elseif ($j->edad >= 26 & $j->edad <= 40) {
                $e2640++;
            }elseif ($j->edad >= 41 & $j->edad <= 55) {
                $e4155++;
            }else{
                $eM56++;
            }

            //calcula la edad minima
            if ($edadMin == 0) {
                $edadMin = $j->edad;
            }elseif ($j->edad < $edadMin) {
                $edadMin = $j->edad;
            }

            //calcula la edad maxima
            if ($edadMax == 0) {
                $edadMax = $j->edad;
            }elseif ($j->edad > $edadMax) {
                $edadMax = $j->edad;
            }

            //cargos a los que pertenece la poblacion
            foreach ($cargos as $cargo) {
                if ($j->cargo == $cargo->idCargo) {
                    $cargo->cantidad++;
                }
            }

            //calcula los niveles academicos de los organizadores
            $esta = 0;
            foreach ($nivel as $n) {
                if ($n->idNivel == $j->nivel) {
                    $esta = 1;
                    $n->cantidad++;
                }
            }

            if ($esta == 0) {
                $n = new stdClass();
                $n->idNivel = $j->nivel;
                $n->cantidad = 1;
                if ($j->nivel == 0) {
                    $n->nombre = 'Educación Media';
                    $n->color = '#e0ca7f';
                }elseif ($j->nivel == 1) {
                    $n->nombre = 'Técnico';
                    $n->color = '#f1a64d';
                }elseif ($j->nivel == 2) {
                    $n->nombre ='Técnico Profesional';
                    $n->color = '#f9714c';
                }elseif ($j->nivel == 3) {
                    $n->nombre = 'Tecnólogo';
                    $n->color = '#f39c12';
                }elseif ($j->nivel == 4) {
                    $n->nombre ='Profesional';
                    $n->color = '#f24b45';
                }elseif ($j->nivel == 5) {
                    $n->nombre ='Especialización';
                    $n->color = '#d03b43';
                }elseif ($j->nivel == 6) {
                    $n->nombre ='Maestría';
                    $n->color = '#ab313e';
                }elseif ($j->nivel == 7) {
                    $n->nombre ='Doctorado';
                    $n->color = '#503140';
                    
                }elseif ($j->nivel == 8) {
                    $n->nombre ='Ninguno';
                    $n->color = '#322e3f';
                    
                }
                array_push($nivel, $n);
            }

            //calcular cantidad de mujeres y hombres
            if ($j->sexo == 0) {//hombre
                $hombres++;
                $edadH += $j->edad;
                
                //calcular escala de rango de fechas
                if ($j->edad >= 18 & $j->edad <= 25) {
                    $e1825H++;
                }elseif ($j->edad >= 26 & $j->edad <= 40) {
                    $e2640H++;
                }elseif ($j->edad >= 41 & $j->edad <= 55) {
                    $e4155H++;
                }else{
                    $eM56H++;
                }
                //calcula la edad minima entre los hombres
                if ($edadMinH == 0) {
                    $edadMinH = $j->edad;
                }elseif ($j->edad < $edadMinH) {
                    $edadMinH = $j->edad;
                }

                //calcula la edad maxima entre los hombres
                if ($edadMaxH == 0) {
                    $edadMaxH = $j->edad;
                }elseif ($j->edad > $edadMaxH) {
                    $edadMaxH = $j->edad;
                }                
            }else{//mujer
                $mujeres++;
                $edadM += $j->edad;

                //calcular escala de rango de fechas
                if ($j->edad >= 18 & $j->edad <= 25) {
                    $e1825M++;
                }elseif ($j->edad >= 26 & $j->edad <= 40) {
                    $e2640M++;
                }elseif ($j->edad >= 41 & $j->edad <= 55) {
                    $e4155M++;
                }else{
                    $eM56M++;
                }
                //calcula la edad minima entre las mujeres
                if ($edadMinM == 0) {
                    $edadMinM = $j->edad;
                }elseif ($j->edad < $edadMinM) {
                    $edadMinM = $j->edad;
                }

                //calcula la edad maxima entre las mujeres
                if ($edadMaxM == 0) {
                    $edadMaxM = $j->edad;
                }elseif ($j->edad > $edadMaxM) {
                    $edadMaxM = $j->edad;
                }
            }



        }

        $porcHombre = ($hombres*100)/$total; 
        $porcMujer = ($mujeres*100)/$total;
        $promEdad = $edad/$total;
        if ($hombres != 0) {
            $promEdadH = $edadH/$hombres;    
        }else{
            $promEdadH = 0;
        }
        if ($mujeres != 0) {
            $promEdadM = $edadM/$mujeres;    
        }else{
            $promEdadM = 0;
        }
        

        $poblacion = new stdClass();
        $poblacion->cantidad = $total;
        $poblacion->edadPromedio = $promEdad;
        $poblacion->edadMin = $edadMin;
        $poblacion->edadMax = $edadMax;
        $poblacion->e1825 = $e1825;
        $poblacion->e2640 = $e2640;
        $poblacion->e4155 = $e4155;
        $poblacion->eM56 = $eM56;

        $hombre = new stdClass();
        $hombre->cantidad = $hombres;
        $hombre->porcentaje = $porcHombre;
        $hombre->edadPromedio = $promEdadH;
        $hombre->edadMin = $edadMinH;
        $hombre->edadMax = $edadMaxH;
        $hombre->e1825 = $e1825H;
        $hombre->e2640 = $e2640H;
        $hombre->e4155 = $e4155H;
        $hombre->eM56 = $eM56H;

        $mujer = new stdClass();
        $mujer->cantidad = $mujeres;
        $mujer->porcentaje = $porcMujer;
        $mujer->edadPromedio = $promEdadM;
        $mujer->edadMin = $edadMinM;
        $mujer->edadMax = $edadMaxM;
        $mujer->e1825 = $e1825M;
        $mujer->e2640 = $e2640M;
        $mujer->e4155 = $e4155M;
        $mujer->eM56 = $eM56M;


    
        return response()->json(['error'=>false, 'poblacion' => $poblacion, 'hombres' => $hombre, 'mujeres' => $mujer, 'cargos' => $cargos, 'nivel' => $nivel]);
    }


    //trae todo los datos de las actividades del evento
    public function allActividad(Request $request){
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        $cantidadAct = count($actividades);
        $cantidadSub = 0;
        $aforo = 0;
        $horas = 0;
        $modalidad = ColorModalidad::all();
        foreach ($modalidad as $m) {
            $m->aforo = 0;
        }
        $tipo = array();
        foreach ($actividades as $act) {
            $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
            //calcula actividades por tipo
            
            //sumar la cantidad de subactividades de todo el evento
            $cantidadSub += count($sub);
            //calcular el aforo total y horas de entretenimiento
            if ($act->lugar == 1) {//mismo lugar
                $aforoAct = 0;
                //calcula aforo
                $palco = Palco::where('idActividad', $act->idActividad)->get();
                foreach ($palco as $p) {
                    $aforo += $p->capacidad;
                    $aforoAct += $p->capacidad;
                }
                //calcula hora
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $inicio = new Carbon($direccion[0]->fechaInicio);
                $fin = new Carbon($direccion[0]->fechaFin);
                $horas += $inicio->diffInHours($fin); 
                foreach ($modalidad as $m) {
                    if ($act->modalidad == $m->idModalidad) {
                        $m->cantidad++;
                        $m->horas += $inicio->diffInHours($fin);
                        $m->aforo += $aforoAct;
                    }
                }
                foreach ($sub as $s) {
                    //calcula modalidad
                    /*foreach ($modalidad as $m) {
                        if ($act->modalidad == $m->idModalidad) {
                            $m->cantidad++;
                            $m->horas += $inicio->diffInHours($fin);
                            $m->aforo += $aforoAct;
                        }
                    }*/

                    //calcula los tipo de actividad
                    $esta = 0;
                    foreach ($tipo as $t) {
                        if ($s->tipo == $t->idTipo) {
                            $esta = 1;
                            $t->cantidad++;
                        }
                    }

                    if ($esta == 0) {
                        $t = new stdClass();
                        $t->idTipo = $s->tipo;
                        $t->cantidad = 1;
                        $t->horas = 0;
                        if ($s->tipo == 0) {
                            $t->nombre = 'Encuentros y Espectáculos Deportivos';
                        }elseif ($s->tipo == 1) {
                            $t->nombre = 'Eventos Religiosos';
                        }elseif ($s->tipo == 2) {
                            $t->nombre = 'Congregaciones Políticas';
                        }elseif ($s->tipo == 3) {
                            $t->nombre = 'Conciertos y Presentaciones Musicales';
                        }elseif ($s->tipo == 4) {
                            $t->nombre = 'Ferias, Festivales, Rodeos y Corralejas';
                        }elseif ($s->tipo == 5) {
                            $t->nombre = 'Congresos, Simposios, Seminarios o similares';
                        }elseif ($s->tipo == 6) {
                            $t->nombre = 'Teatro';
                        }elseif ($s->tipo == 7) {
                            $t->nombre = 'Exhibiciones (Desfiles de Modas, Exposiciones, etc)';
                        }elseif ($s->tipo == 8) {
                            $t->nombre = 'Atracciones y Entretenimiento (Parques de Atracciones, Circos, etc)';
                        }elseif ($s->tipo == 9) {
                            $t->nombre = 'Otros (Marchas, Ventas, etc)';
                        }
                        array_push($tipo, $t);
                    } 
                }
                

                
                

            }else{//diferentes lugares (buscar en cada sub actividad)
                
                
                foreach ($sub as $s) {
                    //calcula aforo
                    $aforoAct = 0;
                    $palco = PalcoSub::where('idActividad', $s->idEventoActividad)->get();
                    
                    foreach ($palco as $p) {
                        $aforo += $p->capacidad;
                        $aforoAct += $p->capacidad;
                    }

                    //calcula horas
                    $direccion = DireccionSub::where('idActividad', $s->idEventoActividad)->get();
                    $inicio = new Carbon($direccion[0]->fechaInicio);
                    $fin = new Carbon($direccion[0]->fechaFin);
                    $horas += $inicio->diffInHours($fin);

                    //calcula modalidad
                    //dd($s);
                    foreach ($modalidad as $m) {
                        if ($s->modalidad == $m->idModalidad) {
                            $m->cantidad++;
                            $m->horas += $inicio->diffInHours($fin);
                            $m->aforo += $aforoAct;
                        }
                    }

                    //calcula los tipo de actividad
                    $esta = 0;
                    foreach ($tipo as $t) {
                        if ($s->tipo == $t->idTipo) {
                            $esta = 1;
                            $t->cantidad++;
                        }
                    }

                    if ($esta == 0) {
                        $t = new stdClass();
                        $t->idTipo = $s->tipo;
                        $t->cantidad = 1;
                        $t->horas = 0;
                        if ($s->tipo == 0) {
                            $t->nombre = 'Encuentros y Espectáculos Deportivos';
                        }elseif ($s->tipo == 1) {
                            $t->nombre = 'Eventos Religiosos';
                        }elseif ($s->tipo == 2) {
                            $t->nombre = 'Congregaciones Políticas';
                        }elseif ($s->tipo == 3) {
                            $t->nombre = 'Conciertos y Presentaciones Musicales';
                        }elseif ($s->tipo == 4) {
                            $t->nombre = 'Ferias, Festivales, Rodeos y Corralejas';
                        }elseif ($s->tipo == 5) {
                            $t->nombre = 'Congresos, Simposios, Seminarios o similares';
                        }elseif ($s->tipo == 6) {
                            $t->nombre = 'Teatro';
                        }elseif ($s->tipo == 7) {
                            $t->nombre = 'Exhibiciones (Desfiles de Modas, Exposiciones, etc)';
                        }elseif ($s->tipo == 8) {
                            $t->nombre = 'Atracciones y Entretenimiento (Parques de Atracciones, Circos, etc)';
                        }elseif ($s->tipo == 9) {
                            $t->nombre = 'Otros (Marchas, Ventas, etc)';
                        }
                        array_push($tipo, $t);
                    }

                    //calcula tipo
                    foreach ($tipo as $t) {
                        if ($act->tipo == $t->idTipo) {
                            $t->horas += $inicio->diffInHours($fin);
                        }
                    }

                    
                }
            } 
        }
        //dd($modalidad);

        $total = new stdClass();
        $total->cantidad = $cantidadAct;
        $total->cantidadSub = $cantidadSub;
        $total->aforo = $aforo;
        $total->horas = $horas;
        return response()->json(['error'=>false, 'total' =>$total, 'modalidad' => $modalidad, 'tipo' => $tipo]);
    }
    
    public function allSocio(Request $request){
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        $junta = Junta::where('idEvento', $request->idEvento)->get();
        $empleos = 0;
        $empleosAct = 0;
        $empleosJunta = 0;
        $empleosGrupos = 0;
        $empleosH = 0;
        $empleosM = 0;

        //calcula los empleos por actividades
        foreach ($actividades as $act) {
            $empleos += $act->empleo;
            $empleosAct += $act->empleo;
            $empleosH += $act->cantHombres;
            $empleosM += $act->cantMujeres;

            if ($act->tipoPoblacion == 2) {
                $empleosGrupos += $act->poblacion;
            }
        }

        //calcula los empleos por organizadores
        $empleos += count($junta);
        $empleosJunta += count($junta);
        foreach ($junta as $j) {
            if ($j->sexo == 0) {//hombres
                $empleosH++;
            }else{//mujeres
                $empleosM++;
            }
        }
        //calcula los empleos por grupos artisticos contratados
        //????????????????????????????????????????????

        $totalEmpleos = new stdClass();
        $totalEmpleos->act = $empleosAct;
        $totalEmpleos->junta = $empleosJunta;
        $totalEmpleos->grupo = $empleosGrupos;
        $totalEmpleos->mujeres = $empleosM;
        $totalEmpleos->hombres = $empleosH;
        $totalEmpleos->porcHombre = ($empleosH*100)/$empleos; 
        $totalEmpleos->porcMujer = ($empleosM*100)/$empleos;
        $empleos += $empleosGrupos;
        $totalEmpleos->total = $empleos;
         
        //calculo de empresas
        $patrocinio = 0;
        $provee = 0;
        $consumo = 0;
        $cantP = 0;
        $cantProvee = 0;
        $cantC = 0;
        $costos = CostoEvento::where('idEvento', $request->idEvento)->get();
        $ingresos = IngresoEvento::where('idEvento', $request->idEvento)->get();
        
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
        

        return response()->json(['error'=>false, 'empleos' =>$totalEmpleos, 'empresas' => $totalEmpresa]);   
    }
    
    //trae todos los datos de poblacion 
    public function allCultural(Request $request){
        //buscar los participantes del evento de los diferentes tipos, agrupaciones. participantes y empresas
        $agrupacionesAsociadas = array();
        $participantesAsociados = array();
        $empresasAsociadas = array();
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        foreach ($actividades as $act) {
            //las agrupaciones asociadas a la actividad 
            $aa = Actividadagrupacion::where('idActividad', $act->idActividad)->get();
            foreach ($aa as $a) {
                # code...
                array_push($agrupacionesAsociadas, $a);
            }
            //los participantes asociados a la actividad 
            $pa = Actividadparticipante::where('idActividad', $act->idActividad)->get();
            foreach ($pa as $p) {
                # code...
                array_push($participantesAsociados, $p);
            }
            //las empresas asociadas a la actividad 
            $ea = Actividadempresa::where('idActividad', $act->idActividad)->get();
            foreach ($ea as $e) {
                # code...
                array_push($empresasAsociadas, $e);
            }
        }
        //dd($agrupacionesAsociadas, $empresasAsociadas, $participantesAsociados);
        //capacidad hotelera
        $cantHoteles = Hotel::count();//se debe filtrar por localidad
        $cantCama = Hotel::sum('capacidadMax');
        $rtn = Hotel::where('rtn', '!=' , 0)->count();
        $tripadvisor = Hotel::where('tripadvisor', 1)->count(); 
        
        //capacidad de restaurantes
        $cantRestaurantes = Restaurante::count();//se debe filtrar por localidad
        $servicios = 0;
        $proteinas = 0;

        //generos musicales
        $genero = Genero::all();
        $cantGenero = Genero::count();
        
        foreach ($genero as $g) {
            $cant = 0;
            foreach ($agrupacionesAsociadas as $a) {
                $agrupacion = Agrupacion::find($a->idAgrupacion);
                if ($agrupacion->genero == $g->idGenero) {
                    $cant ++;
                }
            }
            if ($cant != 0) {
                $g->cant = $cant; 
                $g->prom = ($cant*100)/$cantGenero;
            }else{
                $g->cant = 0;
                $g->prom = 0;
            }
        }

        //grupos artisticos
        //$agrupaciones = Agrupacion::all();
        $cantGrupos = count($agrupacionesAsociadas);//se debe filtrar por localidad
        $cantArtistas = 0;
        $cantArtistasM = 0;
        $cantArtistasH = 0;
        //cantidad de artistas
        foreach ($agrupacionesAsociadas as $a) {
            $agrupacion = Agrupacion::find($a->idAgrupacion);
            $cantArtistas += $agrupacion->nempleados;
            $cantArtistasM += $agrupacion->cantMujeres;
            $cantArtistasH += $agrupacion->cantHombres;
        }
        //horas de entretenimiento generada por los grupos artisticos 
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        $participantes = 0;
        $participantesM = 0;
        $participantesH = 0;
        $participantesN = 0;
        $participantesJ = 0;
        $participantesL = 0;
        $participantesE = 0;
        $gruposArtisticos = 0;
        $gruposArtisticosL = 0;
        $gruposArtisticosE = 0;
        $interpretaciones = 0;
        $staff = 0;
        $premio = 0;
        foreach ($actividades as $act) {
            /*$participantes += $act->poblacion;
            if ($act->tipoPoblacion == 0) {//Naturales
                $participantesN += $act->poblacion;
            }elseif ($act->tipoPoblacion == 1) {//artisticos
                $participantesJ += $act->poblacion;
            }else{//grupos artiscos
                $gruposArtisticos += $act->poblacion;
            }
            if ($act->premio == 1) {
                $premio += Premio::where('idActividad', $act->idActividad)->count();
            }*/

            $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
            foreach ($sub as $s) {
                $interpretaciones += $s->cantidad;
                $staff += $s->poblacion;
            }

        }

        //calcular la oferta de participantes naturales, juridicos, grupos artisticos , hombres, mujeres, locales y externos
        $evento = Evento::find($request->idEvento);
        $participantes = count($participantesAsociados);
        foreach ($participantesAsociados as $p) {
            //busca el participantes
            $participante = Participante::find($p->idParticipante);
            //calcula participantes por sexo
            if ($participante->sexo == 0) {
                # code...
                $participantesM ++;
            }else{
                $participantesH ++;
            }
            //calcula participantes naturales y juridicos
            if ($participante->tipo == 0) {
                # code...
                $participantesN ++;
            }else{
                $participantesJ ++;
            }
            //calcula participantes locales y externos
            if ($participante->departamento == $evento->idDepartamento) {
                $participantesL++;       
            }else{
                $participantesE++;       
            }
            
        }
        
        $gruposArtisticos = count($agrupacionesAsociadas); 
        //$agru = Agrupacion::all();
        foreach ($agrupacionesAsociadas as $a) {
            $agrupacion = Agrupacion::find($a->idAgrupacion);
            if ($agrupacion->departamento == $evento->idDepartamento) {
                $gruposArtisticosL++;       
            }else{
                $gruposArtisticosE++;                       
            }
        }

        $totalcultural = new stdClass();
        $totalcultural->hoteles = $cantHoteles;
        $totalcultural->lugares = Lugar::count();
        $totalcultural->recursosCulturales = lugar::where('recurso' , 0)->count();
        $totalcultural->destino =  lugar::where('recurso' , 1)->count();
        $totalcultural->festividades = lugar::where('recurso' , 2)->count();
        $totalcultural->info = Info::where('idEvento' , $request->idEvento)->count();
        $totalcultural->premios = $premio;
        $totalcultural->camas = $cantCama;
        $totalcultural->restaurantes = $cantRestaurantes;
        $totalcultural->servicios = $servicios;
        $totalcultural->proteinas = $proteinas;
        $totalcultural->grupos = $cantGrupos;
        $totalcultural->artistas = $cantArtistas;
        $totalcultural->artistasH = $cantArtistasH;
        $totalcultural->artistasM = $cantArtistasM;
        $totalcultural->participantes = $participantes;
        $totalcultural->participantesN = $participantesN;
        $totalcultural->participantesJ = $participantesJ;
        $totalcultural->participantesH = $participantesH;
        $totalcultural->participantesM = $participantesM;
        $totalcultural->participantesL = $participantesL;
        $totalcultural->participantesE = $participantesE;
        $totalcultural->gruposArtisticos = $gruposArtisticos;
        $totalcultural->gruposArtisticosL = $gruposArtisticosL;
        $totalcultural->gruposArtisticosE = $gruposArtisticosE;
        $totalcultural->interpretaciones = $interpretaciones;
        $totalcultural->staff = $staff;
        $totalcultural->rtn = $rtn;
        $totalcultural->tripadvisor = $tripadvisor;
        //dd($totalcultural);

        return response()->json(['error'=>false, 'cultural' => $totalcultural, 'genero' => $genero]);   
    }

}
