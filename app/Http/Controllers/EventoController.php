<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Evento;
use App\Modelos\Actividad;
use App\Modelos\EventoActividad;
use App\Modelos\Palco;
use App\Modelos\Premio;
use App\Modelos\DireccionActividad;
use App\Modelos\DireccionSub;
use App\Modelos\Poblacion;
use App\Modelos\Empresa;
use App\Modelos\Participante;
use App\Modelos\Ciudad;
use App\Modelos\Agrupacion;
use Carbon\Carbon;
use stdClass;
use DB;

class EventoController extends Controller {

    public function all(Request $request){
        $eventos = Evento::all();
        foreach ($eventos as  $evento) {

            $evento->creado = $evento->created_at->toFormattedDateString();
            $inicio = new Carbon($evento->fechaInicio);
            $fin = new Carbon($evento->fechaFin);
            $evento->inicio = $inicio->toFormattedDateString();
            $evento->fin = $fin->toFormattedDateString();
            $evento->dias = $inicio->diffInDays($fin );
            $evento->horas = false;
            if ($evento->dias == 0) {
                $evento->dias = $inicio->diffInHours($fin );
                $evento->horas = true;
                $evento->mismo = true;           
            }else{
                $evento->mismo = false;
            }

            
        }

        $dias = array('Dom','Lun','Mar','Mie','Jue','Vie','Sab', 'Dom');
        $semanal  = array();
        

        //contabilizar las actividades por dias de semanas
        $actividades = Actividad::all();
        foreach ($actividades as $act) {
            if ($act->lugar == 1) {//mismo lugar
                $existe = false;
                $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                $dia = (int) date('N', strtotime($direccion[0]->fechaInicio));
                foreach ($semanal as $s) {
                    if ($s->id == $dia) {
                        $existe = true;
                        $s->cantidad++;        
                    }
                }
                if (!$existe) {
                    $diasClass = new stdClass();
                    $diasClass->id = $dia;
                    $diasClass->cantidad = 1;
                    $diasClass->dia = $dias[date('N', strtotime($direccion[0]->fechaInicio))];
                    array_push($semanal, $diasClass);
                    
                }
                
                        
            }else{// diferentes lugares
                $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                foreach ($sub as $su) {
                    $existe = false;
                    $direccion = DireccionSub::where('idActividad', $su->idEventoActividad)->get();
                    //dd($sub, $direccion);
                    $dia = (int) date('N', strtotime($direccion[0]->fechaInicio));
                    foreach ($semanal as $s) {
                        if ($s->id == $dia) {
                            $existe = true;
                            $s->cantidad++;        
                        }
                    }
                    if (!$existe) {
                        $diasClass = new stdClass();
                        $diasClass->id = $dia;
                        $diasClass->cantidad = 1;
                        $diasClass->dia = $dias[date('N', strtotime($direccion[0]->fechaInicio))];
                        array_push($semanal, $diasClass);
                        
                    }
                }
            }
        }
            
        return response()->json(['error'=>false,'eventos' => $eventos, 'semanal' => $semanal]);
    }

    public function allDepartamento(Request $request){

        $eventos = Evento::where('idDepartamento' , $request->idDepartamento)->get();
        $dias = array('Dom','Lun','Mar','Mie','Jue','Vie','Sab', 'Dom');
        $semanal  = array();
        foreach ($eventos as  $evento) {
            $inicio = new Carbon($evento->fechaInicio);
            $fin = new Carbon($evento->fechaFin);
            $evento->inicio = $inicio->toFormattedDateString();
            $evento->fin = $fin->toFormattedDateString();
             $evento->creado = $evento->created_at->toFormattedDateString();
            $inicio = new Carbon($evento->fechaInicio);
            $fin = new Carbon($evento->fechaFin);
            $evento->inicio = $inicio->toFormattedDateString();
            $evento->fin = $fin->toFormattedDateString();
            $evento->dias = $inicio->diffInDays($fin );
            $evento->horas = false;
            if ($evento->dias == 0) {
                $evento->dias = $inicio->diffInHours($fin );
                $evento->horas = true;
                $evento->mismo = true;           
            }else{
                $evento->mismo = false;
            }

            //contabilizar las actividades por dias de semanas
            $actividades = Actividad::where('idEvento' , $evento->idEvento)->get();
            foreach ($actividades as $act) {
                if ($act->lugar == 1) {//mismo lugar
                    $existe = false;
                    $direccion = DireccionActividad::where('idActividad', $act->idActividad)->get();
                    $dia = (int) date('N', strtotime($direccion[0]->fechaInicio));
                    foreach ($semanal as $s) {
                        if ($s->id == $dia) {
                            $existe = true;
                            $s->cantidad++;        
                        }
                    }
                    if (!$existe) {
                        $diasClass = new stdClass();
                        $diasClass->id = $dia;
                        $diasClass->cantidad = 1;
                        $diasClass->dia = $dias[date('N', strtotime($direccion[0]->fechaInicio))];
                        array_push($semanal, $diasClass);
                        
                    }
                    
                            
                }else{// diferentes lugares
                    $sub = EventoActividad::where('idActividad', $act->idActividad)->get();
                    foreach ($sub as $su) {
                        $existe = false;
                        $direccion = DireccionSub::where('idActividad', $su->idEventoActividad)->get();
                        //dd($sub, $direccion);
                        $dia = (int) date('N', strtotime($direccion[0]->fechaInicio));
                        foreach ($semanal as $s) {
                            if ($s->id == $dia) {
                                $existe = true;
                                $s->cantidad++;        
                            }
                        }
                        if (!$existe) {
                            $diasClass = new stdClass();
                            $diasClass->id = $dia;
                            $diasClass->cantidad = 1;
                            $diasClass->dia = $dias[date('N', strtotime($direccion[0]->fechaInicio))];
                            array_push($semanal, $diasClass);
                            
                        }
                    }
                }
            }

        }

        return response()->json(['error'=>false,'eventos' => $eventos , 'semanal' => $semanal]);
    }




    public function totales(Request $request){
        $total =  new stdClass();
        $total->eventos = Evento::all()->count();
        $total->empresas = Empresa::all()->count();
        $total->participantes = Participante::all()->count();
        $total->agrupaciones = Agrupacion::all()->count();
        $eventos = Evento::all();
        $total->sinvalor = 0;
        $total->conboleta = 0;
        $total->convalor = 0;
        foreach ($eventos as $evento) {
            $actividad = Actividad::where('idEvento', $evento->idEvento)->get();
            foreach ($actividad as $a) {
                $sub = EventoActividad::where('idActividad', $a->idActividad)->get();
                foreach ($sub as $s) {
                    if ($s->modalidad == 0) {
                        $total->sinvalor ++;
                    }
                    if ($s->modalidad == 1) {
                        $total->conboleta ++;
                    }
                    if ($s->modalidad == 2) {
                        $total->convalor ++;
                    }
                }
                
            }
        }
        return response()->json(['error'=>false, 'total' => $total]);
    }

    //todos los totales pero por departamento
    public function totalesDep(Request $request){
        //dd($request->idDepartamento);
        $eventos = Evento::where('idDepartamento', $request->idDepartamento)->get();
        foreach ($eventos as  $evento) {
            $inicio = new Carbon($evento->fechaInicio);
            $fin = new Carbon($evento->fechaFin);
            $evento->inicio = $inicio->toFormattedDateString();
            $evento->fin = $fin->toFormattedDateString();
            $ciudad = Ciudad::find($evento->idCiudad);
            $evento->ciudad = $ciudad->nombre;
            
        }
        $total =  new stdClass();
        $total->eventos = count($eventos);
        $total->empresas = Empresa::where('departamento' , $request->idDepartamento)->count();

        $total->participantes = Participante::where('departamento' , $request->idDepartamento)->count();
        $total->agrupaciones = Agrupacion::where('departamento' , $request->idDepartamento)->count();
        $total->sinvalor = 0;
        $total->conboleta = 0;
        $total->convalor = 0;
        foreach ($eventos as $evento) {
            $actividad = Actividad::where('idEvento', $evento->idEvento)->get();
            foreach ($actividad as $a) {
                $sub = EventoActividad::where('idActividad', $a->idActividad)->get();
                foreach ($sub as $s) {
                    if ($s->modalidad == 0) {
                        $total->sinvalor ++;
                    }
                    if ($s->modalidad == 1) {
                        $total->conboleta ++;
                    }
                    if ($s->modalidad == 2) {
                        $total->convalor ++;
                    }
                }
                
            }
        }
        
        //dd($eventos, $total);
        return response()->json(['error'=>false, 'total' => $total, 'eventos' => $eventos]);
    }

    public function find(Request $request){
        $evento = Evento::find($request->idEvento);

        return response()->json(['error'=>false,'evento' => $evento]);
    }

    public function send(){
        /*$to="elUx9zwxTUY:APA91bHlG8wjwywJMj87w4ZFHxr7dT8w9Tg9mS46-m9RFZ7EFmokhMU-D4E9-iLD6rYPXC6-ubyCVqtU3EKi4fDz2XocgBZb-EDCh_Dq9dtaJQeYXP7gVNe-9N7uGrp7vNEyPW0pegGN";
        $title="This is my title";
        $message="This is my message Push Notification";


        // API access key from Google API's Console
        // replace API
        define( 'API_ACCESS_KEY', 'AIzaSyDB_0qC5K6wJNzn6n5H9C0R_XVtUNFHURw');
        $registrationIds = array($to);
        $msg = array
        (

        'title' => $title,
        'message' => $message,
        'vibrate' => 1,
        'sound' => 1

        // you can also add images, additionalData
        );
        $fields = array
        (
        'registration_ids' => $registrationIds,
        'data' => $msg
        );
        $headers = array
        (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        echo $result;*/
        $ID_DEL_DISPOSITIVO ="elUx9zwxTUY:APA91bHlG8wjwywJMj87w4ZFHxr7dT8w9Tg9mS46-m9RFZ7EFmokhMU-D4E9-iLD6rYPXC6-ubyCVqtU3EKi4fDz2XocgBZb-EDCh_Dq9dtaJQeYXP7gVNe-9N7uGrp7vNEyPW0pegGN";
        $API_ACCESS_KEY='AIzaSyDB_0qC5K6wJNzn6n5H9C0R_XVtUNFHURw';
        $registrationIds=array($ID_DEL_DISPOSITIVO);
        $fields=array( 
            'registration_ids'=>$registrationIds,
            'data'=>array(
                "hello"=> "This is a Firebase Cloud Messaging Device Group Message!", 
                'message'=>'TEXTO DEL MENSAJE',
                'title'=>'TITULO DEL MENSAJE',
                'vibrate'=>1,
                'sound'=>'default'
            )
        );
        $headers=array( 
            'Authorization: key='.$API_ACCESS_KEY,
            'Content-Type: application/json' 
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec( $ch );
        curl_close( $ch );

    }

   
    public function create(Request $request){
        $even = json_decode($request->evento);
        
    	try {

    		$evento = new Evento();
    		$evento->descripcion = $even->nombre;
            $evento->idUsuario = $even->usuario;
    		$evento->idDepartamento =  $even->departamento;
    		$evento->idRegion = $even->region;
    		$evento->idCiudad = $even->ciudad;
    		$evento->nit = $even->nit;
    		$evento->codigoPostal = $even->codigo;
    		$evento->direccion = $even->direccion;
    		$evento->telefono = $even->telefono;
    		$evento->telefono2 = $even->telefono2;
    		$evento->correo2 = $even->correo2;
    		$evento->correo = $even->correo;
    		$evento->fundado = $even->fundado;
    		$evento->version = $even->version;
    		$evento->fechaInicio = $even->inicio;
    		$evento->fechaFin = $even->fin;
    		$evento->poblacion = $even->poblacion;
            $evento->poblacionCirculante = $even->poblacionCirculante;
    		$evento->website = $even->web;
    		$evento->facebook = $even->facebook;
    		$evento->instagram = $even->instagram;
    		$evento->twitter = $even->twitter;
            $evento->otro = $even->otro;
            $evento->save();
    		

            if ($request->file('file') != null){
            
              $request->file('file')->move('img/evento/', $evento->idEvento . '.' . $request->file('file')->getClientOriginalExtension());
              $evento->imagen = 'img/evento/' . $evento->idEvento . '.' . $request->file('file')->getClientOriginalExtension();
              $evento->save();

            }else{
               $evento->save();
            }

            //crear el usuario para el evento
            $usuario = new user();
            $usuario->nombre = $even->nombre;
            $usuario->apellido = 'no posee';
            $usuario->cedula = '000';
            $usuario->tipo = 5;
            $usuario->correo= $even->correo;
            $usuario->password  = bcrypt($even->pass);
            $usuario->idEvento = $evento->idEvento;
            $usuario->save();

            //enviar notificaciones a todos los usuarios que esten en la app y tengan las notificaciones activas 
            $usuarios = User::all();
            foreach ($usuarios as $usuario) {
                if ($usuario->token && $usuario->notificacion == 1) {//que tiene token y tiene las notificaciones activas
                    $to= $usuario->token;
                    $title="Nuevo Evento ".$evento->descripcion." Revisalo";
                    $message="This is my message Push Notification";
                    $API_ACCESS_KEY = 'AIzaSyDB_0qC5K6wJNzn6n5H9C0R_XVtUNFHURw';
                    //define( 'API_ACCESS_KEY', 'AIzaSyDB_0qC5K6wJNzn6n5H9C0R_XVtUNFHURw');
                    $registrationIds = array($to);
                    $msg = array
                    (
                    'message' => $message,
                    'title' => $title,
                    'vibrate' => 1,
                    'sound' => 1

                    // you can also add images, additionalData
                    );
                    $fields = array
                    (
                    'registration_ids' => $registrationIds,
                    'data' => $msg
                    );
                    $headers = array
                    (
                    'Authorization: key=' . $API_ACCESS_KEY,
                    'Content-Type: application/json'
                    );
                    $ch = curl_init();
                    curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
                    curl_setopt( $ch,CURLOPT_POST, true );
                    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                    $result = curl_exec($ch );
                    curl_close( $ch );
                    //echo $result;
                    
                }
            }

        

    		return response()->json(['error'=>false,'evento' => $evento , 'mensaje' =>'El evento ha sido creado con éxito']);
    		
    	} catch (Exception $e) {
    		return response()->json(['error'=>true,'mensaje' => $e]);
    	}
    }

    public function delete(Request $request){
        $evento = Evento::find($request->idEvento);
        $actividades = Actividad::where('idEvento', $request->idEvento);
        foreach ($actividades as $actividad) {
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
            //falta eliminar los premios si tiene
           
            //eliminar subactividades si las tiene
            $subs = EventoActividad::where('idActividad', $actividad->idActividad)->get();
            foreach ($subs as $sub) {
                //eliminar direccion y palcos si los tiene
                if ($actividad->lugar == 0){
                    //direccion
                    $direccion = DireccionActividad::where('idActividad', $sub->idEventoActividad)->get();
                    $direccion[0]->delete();
                    //palcos
                    $palcos = Palco::where('idActividad', $sub->idEventoActividad)->get();
                    foreach ($palcos as $palco) {
                        $palco->delete();
                    }

                }
                //eliminar la sub actividad
                $sub->delete();
            }

            //eliminar actividad
            $actividad->delete();
        }
        $evento->delete();

        return response()->json(['error'=>false,'evento' => $evento]);
        
    }


    //buscar la poblacion de un evento
    public function buscarPoblacion(Request $request){

        $poblacion = Poblacion::where('idEvento', $request->idEvento)->get();
        if (isset($poblacion[0])) {
            $aux = $poblacion[0];
        }else{
            $aux = $poblacion;
        }
        return response()->json(['error'=>false,'poblacion' => $aux]);
    }

    //actualizar poblacion de un evento
    public function updatePoblacion(Request $request){
        $poblacion = Poblacion::find($request->idinfo);
        //dd($poblacion->mestizaM, (int)$request->mestizaM);
        $poblacion->_0a18H = (int)$request->_0a18H;
        $poblacion->_0a18M = (int)$request->_0a18M;
        $poblacion->_19a64H = (int)$request->_19a64H;
        $poblacion->_19a64M = (int)$request->_19a64M;
        $poblacion->mayor64H = (int)$request->mayor64H;
        $poblacion->mayor64M = (int)$request->mayor64M;
        $poblacion->indigenaH = (int)$request->indigenaH;
        $poblacion->indigenaM = (int)$request->indigenaM;
        $poblacion->afroColombianaH =(int)$request->afroColombianaH;
        $poblacion->afroColombianaM = (int)$request->afroColombianaM;
        $poblacion->raizalH = (int)$request->raizalH;
        $poblacion->raizalM = (int)$request->raizalM;
        $poblacion->puebloRomH = (int)$request->puebloRomH;
        $poblacion->puebloRomM = (int)$request->puebloRomM;
        $poblacion->mestizaH = (int)$request->mestizaH;
        $poblacion->mestizaM = (int)$request->mestizaM;
        $poblacion->palenqueraH = (int)$request->palenqueraH;
        $poblacion->palenqueraM = (int)$request->palenqueraM;
        $poblacion->desplazadosH = (int)$request->desplazadosH;
        $poblacion->desplazadosM = (int)$request->desplazadosM;
        $poblacion->discapacitadosH = (int)$request->discapacitadosH;
        $poblacion->discapacitadosM = (int)$request->discapacitadosM;
        $poblacion->victimasH = (int)$request->victimasH;
        $poblacion->victimasM = (int)$request->victimasM;
        //dd($poblacion);
        $poblacion->save();
        return response()->json(['error'=>false,'poblacion' => $poblacion]);

    }

    //crear la poblacion de un evento
    public function createPoblacion(Request $request){
        $poblacion = new Poblacion();
        $poblacion->idEvento = $request->idEvento;
        $poblacion->_0a18H = $request->_0a18H;
        $poblacion->_0a18M = $request->_0a18M;
        $poblacion->_19a64H = $request->_19a64H;
        $poblacion->_19a64M = $request->_19a64M;
        $poblacion->mayor64H = $request->mayor64H;
        $poblacion->mayor64M = $request->mayor64M;
        $poblacion->indigenaH = $request->indigenaH;
        $poblacion->indigenaM = $request->indigenaM;
        $poblacion->afroColombianaH = $request->afroColombianaH;
        $poblacion->afroColombianaM = $request->afroColombianaM;
        $poblacion->raizalH = $request->raizalH;
        $poblacion->raizalM = $request->raizalM;
        $poblacion->puebloRomH = $request->puebloRomH;
        $poblacion->puebloRomM = $request->puebloRomM;
        $poblacion->mestizaH = $request->mestizaH;
        $poblacion->mestizaM = $request->mestizaM;
        $poblacion->palenqueraH = $request->palenqueraH;
        $poblacion->palenqueraM = $request->palenqueraM;
        $poblacion->desplazadosH = $request->desplazadosH;
        $poblacion->desplazadosM = $request->desplazadosM;
        $poblacion->discapacitadosH = $request->discapacitadosH;
        $poblacion->discapacitadosM = $request->discapacitadosM;
        $poblacion->victimasH = $request->victimasH;
        $poblacion->victimasM = $request->victimasM;
        $poblacion->save();
        return response()->json(['error'=>false,'poblacion' => $poblacion]);

    }

    public function EventoInicio (Request $request){
        //fecha actual
        $date = Carbon::now();
        $eventos = Evento::where('fechaFin' ,'>', $date)->get();
         foreach ($eventos as  $evento) {
            $inicio = new Carbon($evento->fechaInicio);
            $fin = new Carbon($evento->fechaFin);
            $evento->inicio = $inicio->toFormattedDateString();
            $evento->fin = $fin->toFormattedDateString();
            
        }
        return response()->json(['error'=>false ,'evento' => $eventos]);
    }

    public function EventoFin (Request $request){
        //fecha actual
        $date = Carbon::now();
        $eventos = Evento::where('fechaFin' ,'<', $date)->get();
         foreach ($eventos as  $evento) {
            $inicio = new Carbon($evento->fechaInicio);
            $fin = new Carbon($evento->fechaFin);
            $evento->inicio = $inicio->toFormattedDateString();
            $evento->fin = $fin->toFormattedDateString();
            
        }
        return response()->json(['error'=>false ,'evento' => $eventos]);
    }


    //actualiza los datos del evento
 public function Update (Request $request){
        $evento = Evento::find($request->idEvento);
        $evento->descripcion = $request->descripcion;
        $evento->idUsuario = $request->idUsuario;
        $evento->idDepartamento =  $request->idDepartamento;
        $evento->idRegion = $request->idRegion;
        $evento->idCiudad = $request->idCiudad;
        $evento->nit = $request->nit;
        $evento->codigoPostal = $request->codigoPostal;
        $evento->Direccion = $request->Direccion;
        $evento->telefono = $request->telefono;
        $evento->telefono2 = $request->telefono2;
        $evento->correo2 = $request->correo2;
        $evento->correo = $request->correo;
        $evento->fundado = $request->fundado;
        $evento->version = $request->version;
        $evento->fechaInicio = $request->fechaInicio;
        $evento->fechaFin = $request->fechaFin;
        $evento->poblacion = $request->poblacion;
        $evento->poblacionCirculante = $request->poblacionCirculante;
        $evento->website = $request->website;
        $evento->facebook = $request->facebook;
        $evento->instagram = $request->instagram;
        $evento->twitter = $request->twitter;
        $evento->otro = $request->otro;
        $evento->save();

        return response()->json(['error'=>false ,'evento' => $evento]);
    }

    public function guardarImagen(Request $request){
       
        $evento = Evento::find($request->idEvento);
        $request->file('file')->move("imagenes/", $evento->idEvento . '.' . $request->file('file')->getClientOriginalExtension());
        $evento->imagen = "imagenes/" . $request->idEvento . '.' . $request->file('file')->getClientOriginalExtension();
        $evento->save();
        return response()->json(['error'=>false ,'evento' => $evento]);
    }

    //Consulta de los tipos de actividades 
    public function Reportetipo(Request $request){
        $totales = new stdClass();
        $totales->tipo0 = 0;
        $totales->tipo1 = 0;
        $totales->tipo2 = 0;
        $totales->tipo3 = 0;
        $totales->tipo4 = 0;
        $totales->tipo5 = 0;
        $totales->tipo6 = 0;
        $totales->tipo7 = 0;
        $totales->tipo8 = 0;
        $totales->tipo9 = 0;
        $totales->tipo10 = 0;
        
        $eventos = Evento::all();
        foreach($eventos as $evento){
            $actividades = Actividad::where('idEvento', $evento->idEvento)->get();
            foreach($actividades as $actividad){
                $subactividades = EventoActividad::where('idActividad', $actividad->idActividad)->get();
                foreach ($subactividades as $sub) {
                    if ($sub->tipo == 0) {
                        $totales->tipo0 += 1; //Encuentros y espectaculos religiosos.
                    }elseif ($sub->tipo == 1) {
                        $totales->tipo1 += 1; //Eventos Religiosos
                    }elseif ($sub->tipo == 2) {
                        $totales->tipo2 += 1; //Congregaciones Políticas
                    }elseif ($sub->tipo == 3) {
                        $totales->tipo3 += 1; //Conciertos y presentaciones políticas
                    }elseif ($sub->tipo == 4) {
                        $totales->tipo4 += 1; //Ferias, Festivales, Rodeos y Corralejas
                    }elseif ($sub->tipo == 5) {
                        $totales->tipo5 += 1; //Concursos    
                    }elseif ($sub->tipo == 6) {
                        $totales->tipo6 += 1; //Congresos, Simposios, Seminarios o similares    
                    }elseif ($sub->tipo == 7) {
                        $totales->tipo7 += 1; //Teatro
                    }elseif ($sub->tipo == 8) {
                        $totales->tipo8 += 1; //Exhibiciones (Desfiles de Modas, Exposiciones, etc.)
                    }elseif ($sub->tipo == 9) {
                        $totales->tipo9 += 1; //Atracciones y Entretenimiento (Parques de Atracciones, Ciudades de Hierro, Circos, etc.)
                    }elseif ($sub->tipo == 10) {
                        $totales->tipo10 += 10; //Otros (Marchas, Ventas, etc.)
                    }
                }
            }
            
        }
        
        return response()->json(['error'=>false ,'totales' => $totales]);
    }
}


