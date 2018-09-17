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
use App\Modelos\Hotel;
use App\Modelos\Restaurante;
use App\Modelos\Lugar;
use App\Modelos\Info;
use App\Modelos\Junta;
use App\Modelos\Cargo;
use App\Modelos\CostoProvee;
use App\Modelos\CostoEvento;
use App\Modelos\Empresa;
use App\Modelos\IngresoEvento;
use App\Modelos\IngresoConsume;
use App\Modelos\TipoPresupuesto;
use App\Modelos\Costoactividad;
use DB;
use stdClass;
use Carbon\Carbon;

class EventoAppController extends Controller {

    
    //trae todo los datos  del evento
    public function EventoInicio(Request $request){
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        $cantidadAct = count($actividades);
        $junta = junta::where('idEvento', $request->idEvento)->get();
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

        //cantidad de empresas patrocinadoras

        //busco los costos del evento
        $costos = CostoEvento::where('idEvento', $request->idEvento)->get();
        $patrocinadoras = array();
        foreach ($costos as $costo) {
            $cos = CostoProvee::where('idCosto', $costo->idCosto)->where('subsidio', 1)->get();

            //recorrer para sacar las empresas que se repiten
            foreach ($cos as $c) {
                $aux = false;
                if (!isset($patrocinadoras[0])) {//si esta vacio mete el registro
                    array_push($patrocinadoras,$c);
                }else{//comprueba que ya la empresa no exista como patrocinadora
                    foreach ($patrocinadoras as $p) {
                        if ($p->idProveedor == $c->idProveedor) {
                            $aux = true;//si lo encuentra dice true
                        }
                    }
                    if ($aux == false) {
                        array_push($patrocinadoras, $c);//si no lo consigue lo ingresa
                    }
                }
            }

        }

        //cantidad de empresas proveerdoras y consumidora de servicios 

        //busco los costos del evento
        $costos2 = CostoEvento::where('idEvento', $request->idEvento)->get();
        //busco los ingresos del evento
        $ingresos = IngresoEvento::where('idEvento', $request->idEvento)->get();
        $colaboradoras = array();

        //ingresar a las empresas que nos surten
        foreach ($costos2 as $costo) {
            $cos = CostoProvee::where('idCosto', $costo->idCosto)->where('subsidio', 0)->get();

            //recorrer para sacar las empresas que se repiten
            foreach ($cos as $c) {
                $aux = false;
                if (!isset($colaboradoras[0])) {//si esta vacio mete el registro
                    array_push($colaboradoras,$c);
                }else{//comprueba que ya la empresa no exista como patrocinadora
                    foreach ($colaboradoras as $p) {
                        if ($p->idProveedor == $c->idProveedor || $p->idConsumidor == $c->idProveedor) {
                            $aux = true;//si lo encuentra dice true
                        }
                    }
                    if ($aux == false) {
                        array_push($colaboradoras, $c);//si no lo consigue lo ingresa
                    }
                }
            }

        }
        //ingresar a las empresas que consumen alguno de nuestros servicios
        foreach ($ingresos as $ingreso) {
            $ing = IngresoConsume::where('idIngreso', $ingreso->idIngreso)->get();

            //recorrer para sacar las empresas que se repiten
            foreach ($ing as $i) {
                $aux = false;
                if (!isset($colaboradoras[0])) {//si esta vacio mete el registro
                    array_push($colaboradoras,$i);
                }else{//comprueba que ya la empresa no exista como patrocinadora
                    foreach ($colaboradoras as $p) {
                        if ($p->idProveedor == $i->idConsumidor|| $p->idConsumidor == $i->idConsumidor ) {
                            $aux = true;//si lo encuentra dice true
                        }
                    }
                    if ($aux == false) {
                        array_push($colaboradoras, $i);//si no lo consigue lo ingresa
                    }
                }
            }

        }

        //cantidad de cosas de interes para el usuario 
        
        $cantCosto = CostoEvento::where('idEvento', $request->idEvento)->where('tipo','<>', 2)->count();
        //todo lo que ofrecemos que las empresas puedan adquirir (ingresos)
        $cantIngreso = IngresoEvento::where('idEvento', $request->idEvento)->count();
       

        $total = new stdClass();
        $total->actividad = $cantidadAct;
        $total->sub = $cantidadSub;
        $total->aforo = $aforo;
        $total->horas = $horas;
        $total->empleo = $empleo;
        $total->junta =  count($junta);
        $total->interes = $cantCosto + $cantIngreso + $cantidadAct;
        $total->empresasp = count($patrocinadoras);
        $total->empresasc = count($colaboradoras);
        return response()->json(['error'=>false, 'total' =>$total]);
    }

    //todos los hoteles cercano al evento
    public function AllHoteles(Request $request){

        $hoteles = Hotel::where('departamento', $request->departamento)->where('ciudad', $request->ciudad)->get();

        foreach ($hoteles as $hotel) {
            if ($hotel->categoria == 1) {
                $hotel->tipoC = "Hotel";
            }
            if ($hotel->categoria == 2) {
                $hotel->tipoC = "Apartamentos y suites";
            }
            if ($hotel->categoria == 3) {
                $hotel->tipoC = "Hostal";
            }
            if ($hotel->categoria == 4) {
                $hotel->tipoC = "Residencia";
            }
            if ($hotel->categoria == 5) {
                $hotel->tipoC = "Casas";
            }
            if ($hotel->categoria == 6) {
                $hotel->tipoC = "Hotel Boutique";
            }
            if ($hotel->categoria == 7) {
                $hotel->tipoC = "Complejo";
            }
            if ($hotel->categoria == 8) {
                $hotel->tipoC = "Fincas";
            }
            if ($hotel->categoria == 9) {
                $hotel->tipoC = "Posada";
            }
            if ($hotel->categoria == 10) {
                $hotel->tipoC = "Centro Turístico";
            }
        }

        return response()->json(['error'=>false, 'hoteles' =>$hoteles]);
    }

    //todos los restaurantes cercano al evento
    public function AllRestaurantes(Request $request){

        $restaurantes = Restaurante::where('departamento', $request->departamento)->where('ciudad', $request->ciudad)->get();

        return response()->json(['error'=>false, 'restaurantes' =>$restaurantes]);
    }

    //todos los lugares turisticos cercano al evento
    public function AllLugares(Request $request){

        $lugares = Lugar::where('departamento', $request->departamento)->where('ciudad', $request->ciudad)->get();

        foreach ($lugares as $lugar) {
            if($lugar->tipo == 0){
                $lugar->tipoD = "Edificaciones";
            }
            if($lugar->tipo == 1){
                $lugar->tipoD = "Edificios y Expresiones Religiosos";
            }
            if($lugar->tipo == 2){
                $lugar->tipoD = "Realizaciones técnico cientificas";
            }
            if($lugar->tipo == 3){
                $lugar->tipoD = "Parque Natural";
            }
            if($lugar->tipo == 4){
                $lugar->tipoD = "Monumentos";
            }
            if($lugar->tipo == 5){
                $lugar->tipoD = "Rios";
            }
            if($lugar->tipo == 6){
                $lugar->tipoD = "Arroyos";
            }
            if($lugar->tipo == 7){
                $lugar->tipoD = "Actividad Turística";
            }
            if($lugar->tipo == 8){
                $lugar->tipoD = "Festivales y Fiestas";
            }
            if($lugar->tipo == 9){
                $lugar->tipoD = "Expresiones Religiosas";
            }
            if($lugar->tipo == 10){
                $lugar->tipoD = "Ferias y Exposiciones";
            }
            if($lugar->tipo == 11){
                $lugar->tipoD = "Gastronomía";
            }
            if($lugar->tipo == 12){
                $lugar->tipoD = "Grupos Culturales";
            }
            if($lugar->tipo == 13){
                $lugar->tipoD = "Pueblos indigenas";
            }
            if($lugar->tipo == 14){
                $lugar->tipoD = "Balneario";
            }
            if($lugar->tipo == 15){
                $lugar->tipoD = "Artesania";
            }
            if($lugar->tipo == 16){
                $lugar->tipoD = "Museo";
            }
            if($lugar->tipo == 17){
                $lugar->tipoD = "Tradiciones-Cuentos-Bailes";
            }
            if($lugar->tipo == 18){
                $lugar->tipoD = "Eco Turismo";
            }
            if($lugar->tipo == 19){
                $lugar->tipoD = "Acequia";
            }
            if($lugar->tipo == 20){
                $lugar->tipoD = "Humedades";
            }
            if($lugar->tipo == 21){
                $lugar->tipoD = "Quebradas";
            }
            if($lugar->tipo == 22){
                $lugar->tipoD = "Cienagas";
            }
            if($lugar->tipo == 23){
                $lugar->tipoD = "Biblioteca";
            }
            if($lugar->tipo == 24){
                $lugar->tipoD = "escuelas";
            }
            
        }

        return response()->json(['error'=>false, 'lugares' =>$lugares]);
    }

    //todos los puntos de informacion cercano al evento
    public function AllInfo(Request $request){

        $info = Info::where('idEvento', $request->idEvento)->get();

        return response()->json(['error'=>false, 'info' =>$info]);
    }

    //crear un punto de informacion cercano al evento
    public function CreateInfo(Request $request){

        $info = new Info;
        $info->idEvento = $request->idEvento;
        $info->nombre = $request->nombre;
        $info->direccion = $request->direccion;
        $info->lat = $request->lat;
        $info->lng = $request->lng;
        $info->save();

        return response()->json(['error'=>false, 'info' =>$info]);
    }

    //eliminar un punto de informacion cercano al evento
    public function DeleteInfo(Request $request){

        $info = Info::find($request->idInfo);
        $info->delete();
        
        return response()->json(['error'=>false, 'info' =>$info]);
    }
    //todos los puntos de informacion cercano al evento
    public function AllJunta(Request $request){

        $junta = junta::where('idEvento', $request->idEvento)->get();
        foreach ($junta as $j) {
            $cargo = Cargo::where('idEvento', $request->idEvento)->where('idCargo', $j->cargo)->get();
            $j->cargoD = $cargo[0]->nombre;
        }
        return response()->json(['error'=>false, 'junta' =>$junta]);
    }

    public function AllEmpresasP(Request $request){

        //cantidad de empresas patrocinadoras

        //busco los costos del evento
        $costos = CostoEvento::where('idEvento', $request->idEvento)->get();
        $patrocinadoras = array();
        foreach ($costos as $costo) {
            $cos = CostoProvee::where('idCosto', $costo->idCosto)->where('subsidio', 1)->get();

            //recorrer para sacar las empresas que se repiten
            foreach ($cos as $c) {
                $aux = false;
                if (!isset($patrocinadoras[0])) {//si esta vacio mete el registro
                    //busca el nombre de la empresa
                    $empresa = Empresa::find($c->idProveedor);
                    $c->empresa = $empresa->nombre;
                   
                    if($empresa->sector == 0){
                        $c->empresaTipo = "Microempresa";
                    }
                    if($empresa->sector == 1){
                        $c->empresaTipo = "Pequeñas Empresas";
                    }
                    if($empresa->sector == 2){
                        $c->empresaTipo = "Medianas Empresas";
                    }
                    if($empresa->sector == 3){
                        $c->empresaTipo = "Grandes Empresas";
                    }
                    array_push($patrocinadoras,$c);
                }else{//comprueba que ya la empresa no exista como patrocinadora
                    foreach ($patrocinadoras as $p) {
                        if ($p->idProveedor == $c->idProveedor) {
                            $aux = true;//si lo encuentra dice true
                        }
                    }
                    if ($aux == false) {
                        //busca el nombre de la empresa
                        $empresa = Empresa::find($c->idProveedor);
                        $c->empresa = $empresa->nombre;
                        if($empresa->sector == 0){
                            $c->empresaTipo = "Microempresa";
                        }
                        if($empresa->sector == 1){
                            $c->empresaTipo = "Pequeñas Empresas";
                        }
                        if($empresa->sector == 2){
                            $c->empresaTipo = "Medianas Empresas";
                        }
                        if($empresa->sector == 3){
                            $c->empresaTipo = "Grandes Empresas";
                        }
                        array_push($patrocinadoras, $c);//si no lo consigue lo ingresa
                    }
                }
            }

        }

        return response()->json(['error'=>false, 'patrocinadoras' =>$patrocinadoras]);


        
    }

    public function AllEmpresasC(Request $request){
        //cantidad de empresas proveerdoras y consumidora de servicios 

        //busco los costos del evento
        $costos = CostoEvento::where('idEvento', $request->idEvento)->get();
        //busco los ingresos del evento
        $ingresos = IngresoEvento::where('idEvento', $request->idEvento)->get();
        $colaboradoras = array();

        //ingresar a las empresas que nos surten
        foreach ($costos as $costo) {
            $cos = CostoProvee::where('idCosto', $costo->idCosto)->where('subsidio', 0)->get();

            //recorrer para sacar las empresas que se repiten
            foreach ($cos as $c) {
                $aux = false;
                if (!isset($colaboradoras[0])) {//si esta vacio mete el registro
                    //busca el nombre de la empresa
                    $empresa = Empresa::find($c->idProveedor);
                    $c->empresa = $empresa->nombre;
                    $c->tipo = "Proveedor de Bienes y Servicios";
                    if($empresa->sector == 0){
                        $c->empresaTipo = "Microempresa";
                    }
                    if($empresa->sector == 1){
                        $c->empresaTipo = "Pequeñas Empresas";
                    }
                    if($empresa->sector == 2){
                        $c->empresaTipo = "Medianas Empresas";
                    }
                    if($empresa->sector == 3){
                        $c->empresaTipo = "Grandes Empresas";
                    }
                    array_push($colaboradoras,$c);
                }else{//comprueba que ya la empresa no exista como patrocinadora
                    foreach ($colaboradoras as $p) {
                        if ($p->idProveedor == $c->idProveedor || $p->idConsumidor == $c->idProveedor) {
                            $aux = true;//si lo encuentra dice true
                        }
                    }
                    if ($aux == false) {
                        //busca el nombre de la empresa
                        $empresa = Empresa::find($c->idProveedor);
                        $c->empresa = $empresa->nombre;
                        $c->tipo = "Proveedor de Bienes y Servicios";
                        if($empresa->sector == 0){
                            $c->empresaTipo = "Microempresa";
                        }
                        if($empresa->sector == 1){
                            $c->empresaTipo = "Pequeñas Empresas";
                        }
                        if($empresa->sector == 2){
                            $c->empresaTipo = "Medianas Empresas";
                        }
                        if($empresa->sector == 3){
                            $c->empresaTipo = "Grandes Empresas";
                        }
                        array_push($colaboradoras, $c);//si no lo consigue lo ingresa
                    }
                }
            }

        }
        //ingresar a las empresas que consumen alguno de nuestros servicios
        foreach ($ingresos as $ingreso) {
            $ing = IngresoConsume::where('idIngreso', $ingreso->idIngreso)->get();

            //recorrer para sacar las empresas que se repiten
            foreach ($ing as $i) {
                $aux = false;
                if (!isset($colaboradoras[0])) {//si esta vacio mete el registro
                    //busca el nombre de la empresa
                    $empresa = Empresa::find($i->idConsumidor);
                    $i->empresa = $empresa->nombre;
                    $i->tipo = "Consumidor de Bienes y Servicios";
                    if($empresa->sector == 0){
                        $i->empresaTipo = "Microempresa";
                    }
                    if($empresa->sector == 1){
                        $i->empresaTipo = "Pequeñas Empresas";
                    }
                    if($empresa->sector == 2){
                        $i->empresaTipo = "Medianas Empresas";
                    }
                    if($empresa->sector == 3){
                        $i->empresaTipo = "Grandes Empresas";
                    }
                    array_push($colaboradoras,$i);
                }else{//comprueba que ya la empresa no exista como patrocinadora
                    foreach ($colaboradoras as $p) {
                        if ($p->idProveedor == $i->idConsumidor|| $p->idConsumidor == $i->idConsumidor ) {
                            $aux = true;//si lo encuentra dice true
                        }
                    }
                    if ($aux == false) {
                        //busca el nombre de la empresa
                        $empresa = Empresa::find($i->idConsumidor);
                        $i->empresa = $empresa->nombre;
                        $i->tipo = "Consumidor de Bienes y Servicios";
                        
                        if($empresa->sector == 0){
                            $i->empresaTipo = "Microempresa";
                        }
                        if($empresa->sector == 1){
                            $i->empresaTipo = "Pequeñas Empresas";
                        }
                        if($empresa->sector == 2){
                            $i->empresaTipo = "Medianas Empresas";
                        }
                        if($empresa->sector == 3){
                            $i->empresaTipo = "Grandes Empresas";
                        }
                        array_push($colaboradoras, $i);//si no lo consigue lo ingresa
                    }
                }
            }

        }
        return response()->json(['error'=>false, 'colaboradoras' =>$colaboradoras]);
    }

    public function AllActividades(Request $request){
        //todas las actividades del evento
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        
        foreach ($actividades as $act) {
            //Tipo

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

            //Modalidad
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
            $act->detalle = 0;
        }
        return response()->json(['error'=>false, 'actividades' =>$actividades]);
    }


    public function InteresEmpresa(Request $request){
        //todos los consumos necesarios para el evento (costos del evento) 
        $interesCostos = array();
        $costos = CostoEvento::where('idEvento', $request->idEvento)->where('app',1)->get();
        
        foreach ($costos as $c) {
            # code...
            $tipo = TipoPresupuesto::where('idTipo', $c->tipo)->get();
            $c->tipoD = $tipo[0]->nombre;
            array_push($interesCostos, $c);
        }
        //buscamos las actividades del evento para buscar costos que queremos que se muestren en la app
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        foreach ($actividades as $actividad) {
            $costosAct = Costoactividad::where('idActividad', $actividad->idActividad)->where('app',1)->get();
            foreach ($costosAct as $c) {
                $c->tipoD = "Actividad " . $actividad->nombre;
                array_push($interesCostos, $c);
            }
        }

        //todo lo que ofrecemos que las empresas puedan adquirir (ingresos)

        $ingresos = IngresoEvento::where('idEvento', $request->idEvento)->get();
        
        foreach ($ingresos as $ingreso) {
            $tipo = TipoPresupuesto::where('idTipo', $ingreso->tipo)->get();
            $ingreso->tipoD = $tipo[0]->nombre;    
        }

        //dd($ingresos);
        
        //0:participante, 1: empresa, 2: grupos artisticos
        //todas las actividades del evento que la participacion sea juridica
        $actividades = Actividad::where('idEvento', $request->idEvento)->get();
        
        foreach ($actividades as $act) {

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
            $act->detalle = 0;
        }

        return response()->json(['error'=>false, 'costos' =>$interesCostos, 'ingresos' => $ingresos, 'actividades' => $actividades]);
    }

    public function InteresAgrupacion(Request $request){
        //0:participante, 1: empresa, 2: grupos artisticos
        //todas las actividades del evento que la participacion sea juridica
        $actividades = Actividad::where('idEvento', $request->idEvento)->where('tipoPoblacion', 2)->get();
        
        foreach ($actividades as $act) {

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
            $act->detalle = 0;
        }

        return response()->json(['error'=>false,'actividades' => $actividades]);
    }

    public function InteresParticipante(Request $request){
        //0:participante, 1: empresa, 2: grupos artisticos
        //todas las actividades del evento que la participacion sea juridica
        $actividades = Actividad::where('idEvento', $request->idEvento)->where('tipoPoblacion', 0)->get();
        
        foreach ($actividades as $act) {

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
                $act->horas =$inicio->diffInHours($fin , false , false);
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
            $act->detalle = 0;
        }

        return response()->json(['error'=>false,'actividades' => $actividades]);
    }


}
