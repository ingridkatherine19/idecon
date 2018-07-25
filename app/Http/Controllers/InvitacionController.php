<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Empresa;
use App\Modelos\Invitacion;
use App\Modelos\Participante;
use App\Modelos\Agrupacion;
use App\Modelos\Hotel;
use App\Modelos\Restaurante;
use App\Modelos\Mensaje;
use DB;
use stdClass;

class InvitacionController extends Controller {
 
 public function Listado(Request $request){
  /*
    Tipo:
    0: Empresa
    1: Agrupacion
    2: Participante
    3: Hoteles
    4: Restaurantes
  */


    if ($request->tipo == 0) {
        
        $empresas = Empresa::all();
        $invitadas = array();
        $noinvitadas = array();
        foreach ($empresas as $empresa) {
            $empresaS = new Empresa();
            $empresasInvitadas = Invitacion::where('idInvitado' , $empresa->idEmpresa)->where('tipo' , 0)->where('idEvento' , $request->idEvento)->get();
            if(isset($empresasInvitadas[0])){
                $empresaS = $empresa;
                $empresaS->idInvitacion = $empresasInvitadas[0]->idInvitacion;
                $empresaS->idEvento = $empresasInvitadas[0]->idEvento;
                $empresaS->tipo = $empresasInvitadas[0]->tipo;
                $empresaS->estado = $empresasInvitadas[0]->estado; 
                array_push($invitadas, $empresaS);
            }else{
                $empresaS = $empresa;
                array_push($noinvitadas, $empresaS);
            }
        }
        return response()->json(['error'=>false,'invitadas' => $invitadas, 'noinvitadas' => $noinvitadas]);
    }else{
        if ($request->tipo == 1) {
                
            $agrupaciones = Agrupacion::all();
            $invitadas = array();
            $noinvitadas = array();
            foreach ($agrupaciones as $agrupacion) {
                $agrupacionS = new Agrupacion();

                $agrupacionInvitada = Invitacion::where('idInvitado' , $agrupacion->idAgrupacion)->where('tipo' , 1)->where('idEvento' , $request->idEvento)->get();
                if(isset($agrupacionInvitada[0])){
                    $agrupacionS = $agrupacion;
                    $agrupacionS->idInvitacion = $agrupacionInvitada[0]->idInvitacion;
                    $agrupacionS->idEvento = $agrupacionInvitada[0]->idEvento;
                    $agrupacionS->tipo = $agrupacionInvitada[0]->tipo;
                    $agrupacionS->estado = $agrupacionInvitada[0]->estado; 
                    array_push($invitadas, $agrupacionS);
                }else{
                    $agrupacionS = $agrupacion;
                    array_push($noinvitadas, $agrupacionS);
                }
            }

            return response()->json(['error'=>false,'invitadas' => $invitadas, 'noinvitadas' => $noinvitadas]);
        }else{
            if ($request->tipo == 2) {
                $participantes = Participante::all();
                $invitadas = array();
                $noinvitadas = array();
                foreach ($participantes as $participante) {
                    $participanteS = new Participante();

                    $participanteInvitado = Invitacion::where('idInvitado' , $participante->idParticipante)->where('tipo' , 2)->where('idEvento' , $request->idEvento)->get();
                    if(isset($participanteInvitado[0])){
                        $participanteS = $participante;
                        $participanteS->idInvitacion = $participanteInvitado[0]->idInvitacion;
                        $participanteS->idEvento = $participanteInvitado[0]->idEvento;
                        $participanteS->tipo = $participanteInvitado[0]->tipo;
                        $participanteS->estado = $participanteInvitado[0]->estado; 
                        array_push($invitadas, $participanteS);
                    }else{
                        $participanteS = $participante;
                        array_push($noinvitadas, $participanteS);
                    }
                }

                return response()->json(['error'=>false,'invitadas' => $invitadas, 'noinvitadas' => $noinvitadas ]);

            }else{
              if ($request->tipo == 3) {
                $hoteles = Hotel::all();
                $invitadas = array();
                $noinvitadas = array();
                foreach ($hoteles as $hotel) {
                    $hotelS = new Hotel();
                    $hotelInvitado = Invitacion::where('idInvitado' , $hotel->idHotel)->where('tipo' , 3)->where('idEvento' , $request->idEvento)->get();
                    if(isset($hotelInvitado[0])){
                        $hotelS = $hotel;
                        $hotelS->idInvitacion = $hotelInvitado[0]->idInvitacion;
                        $hotelS->idEvento = $hotelInvitado[0]->idEvento;
                        $hotelS->tipo = $hotelInvitado[0]->tipo;
                        $hotelS->estado = $hotelInvitado[0]->estado; 
                        array_push($invitadas, $hotelS);
                    }else{
                        $hotelS = $hotel;
                        array_push($noinvitadas, $hotelS);
                    }
                }

                return response()->json(['error'=>false,'invitadas' => $invitadas, 'noinvitadas' => $noinvitadas ]);
                
              }else{
                if ($request->tipo == 4) {
                    $restaurantes = Restaurante::all();
                    $invitadas = array();
                    $noinvitadas = array();
                    foreach ($restaurantes as $restaurante) {
                        $restauranteS = new Restaurante();
                        $restauranteInvitado = Invitacion::where('idInvitado' , $restaurante->idRestaurante)->where('tipo' , 4)->where('idEvento' , $request->idEvento)->get();
                        if(isset($restauranteInvitado[0])){
                            $restauranteS = $restaurante;
                            $restauranteS->idInvitacion = $restauranteInvitado[0]->idInvitacion;
                            $restauranteS->idEvento = $restauranteInvitado[0]->idEvento;
                            $restauranteS->tipo = $restauranteInvitado[0]->tipo;
                            $restauranteS->estado = $restauranteInvitado[0]->estado; 
                            array_push($invitadas, $restauranteS);
                        }else{
                            $restauranteS = $restaurante;
                            array_push($noinvitadas, $restauranteS);
                        }
                    }
                    return response()->json(['error'=>false,'invitadas' => $invitadas, 'noinvitadas' => $noinvitadas ]);
                }
              }
           }
       }
    }
 }


 public function Create(Request $request){
  //dd($request->tipo );
    $datos = json_decode($request->datos);
    $tipo = (int)$request->tipo;
    
        foreach ($datos as  $d) {
          
            $invitacion = new Invitacion();
            if ($tipo == 0) {//0: Empresa
              $invitacion->idEvento = $request->idEvento;
              $invitacion->tipo = 0;
              $invitacion->estado = 0;
              $invitacion->idInvitado = $d->idEmpresa;
              $invitacion->save();
            }elseif($tipo == 1){// 1: Agrupación
              $invitacion->idEvento = $request->idEvento;
              $invitacion->tipo = 1;
              $invitacion->estado = 0;
              $invitacion->idInvitado = $d->idAgrupacion;
              $invitacion->save();
            }elseif($tipo == 2){// 2: Participante
              $invitacion->idEvento = $request->idEvento;
              $invitacion->tipo = 2;
              $invitacion->estado = 0;
              $invitacion->idInvitado = $d->idParticipante;
              $invitacion->save();
                   
            }elseif($tipo == 3){// 3: Hoteles
              $invitacion->idEvento = $request->idEvento;
              $invitacion->tipo = 3;
              $invitacion->estado = 0;
              $invitacion->idInvitado = $d->idHotel;
              $invitacion->save();
                   
            }elseif($tipo == 4){// 3: Hoteles
              $invitacion->idEvento = $request->idEvento;
              $invitacion->tipo = 4;
              $invitacion->estado = 0;
              $invitacion->idInvitado = $d->idRestaurante;
              $invitacion->save();
                   
            }
            
          $texto = Mensaje::where('tipo' , $request->tipo)->where('idEvento' , $request->idEvento)->get();
          
          if (isset($texto[0])) {
            $mensaje = '<!DOCTYPE html>
                <html lang="en" ng-app="myApp" class="no-js"> 

                <head>
                  <style>
                      div {
                          width: 500px;
                          height: -webkit-fill-available;
                          border: 5px solid grey;
                          padding: 25px;
                          margin: 25px;
                          margin-left: 35%;
                          background-image: url("https://image.freepik.com/vector-gratis/fondo-geometrico-colorido_1035-8807.jpg");
                      }
                      .letra{
                        color:white;
                      }
                  </style>
                </head>
                <div>
                  <!-- Títulos -->
                <center style="background-color:#ccccccb0">
                  <img src="http://www.frecuenciaestereo.com/wp-content/uploads/2017/04/icono-de-notificaciones.png" alt="Imagen de ejemplo" style="width: 20%;"/> 
                  <h1 class="letra">Notificación</h1>
                  <h2 class="letra">Dinco te invita a participar en el evento:</h2>
                  <strong><p class="letra" >'. $texto[0]->texto.'</p></strong>
                </center>
                  <!-- Parrafo -->
                </div>
                </html>
  ';

          }else{
            $texto = Mensaje::where('tipo' , $request->tipo)->get();
            $mensaje = '
                <!DOCTYPE html>
                    <html lang="en" ng-app="myApp" class="no-js"> 
                    <head>
                      <style>
                          div {
                              width: 300px;
                              border: 5px solid grey;
                              padding: 25px;
                              margin: 25px;
                              margin-left: 35%;
                              background-image: url("https://image.freepik.com/vector-gratis/fondo-geometrico-colorido_1035-8807.jpg");
                          }
                          .letra{
                            color:white;
                          }
                      </style>
                    </head>
                    <div>
                    <center style="background-color:#ccccccb0">
                      <img src="http://www.frecuenciaestereo.com/wp-content/uploads/2017/04/icono-de-notificaciones.png" alt="Imagen de ejemplo" style="width: 20%;"/> 
                      <h1 class="letra">Notificación</h1>
                      <h2 class="letra">Dinco te invita a participar en el evento:</h2>
                      <strong><p class="letra" >'. $texto.' Comuniquese con nosotros a través de este correo, o a un correo electrónico</p></strong>
                    </center>
                    </div>
                    </html>';

          }


          // Cuerpo o mensaje
          //dd($mensaje);
          $email_to = $d->correo;
          $email_from = 'saniurys.millan@gmail.com';
             //   $error_message = "";
          $email_subject = "Invitacion"; 
          $email_message = "";
          $email_message .= $mensaje."\n";
          $headers = 'MIME-Version: 1.0' . "\r\n";
          $headers =  'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          
     
          @mail($email_to, $email_subject, $email_message, $headers);
        }

      return response()->json(['error'=>false,'invitacion' => $invitacion, 'mensaje' => 'Las invitaciones han sido enviadas con exito' ]);
 }

 public function CrearMensaje (Request $request){
     
      $verificar = Mensaje::where('tipo' , $request->tipo)->where('idEvento' , $request->idEvento)->get();
      if (isset($verificar[0])) {
         return response()->json(['error'=>false,'respuesta' => 'Ya posee un mensaje para la opcion que selecciono' ]);        
      }else{
            $mensaje = new Mensaje();
            $mensaje->idEvento = $request->idEvento;
            $mensaje->tipo = $request->tipo;
            $mensaje->texto = $request->texto;
            $mensaje->save();

            return response()->json(['error'=>false,'mensaje' => $mensaje, 'respuesta' => 'El mensaje ha sido agregado con éxito' ]);
      }

  
 }
 public function EstadoInvitacion(Request $request){
  
    $invitacion = Invitacion::find($request->idInvitacion);
    $invitacion->estado = $request->estado;
    $invitacion->save();

    return response()->json(['error'=>false,'invitacion' => $invitacion , 'mensaje' => 'El estado ha sido modificado con exito']); 

 }

 public function AllMensajes (Request $request){
  
    $mensajes = Mensaje::whereNotBetween('idMensaje', [1, 5])->where('idEvento' , $request->idEvento)->get();

    return response()->json(['error'=>false,'mensajes' => $mensajes]);
 }

 public function DeleteMensaje (Request $request){
        $mensajed = Mensaje::find($request->idMensaje);
        $mensajed->delete();
        return response()->json(['error'=>false,'mensajed' => $mensajed , 'mensaje' => 'El mensaje ha sido eliminado con éxito']); 

 }
 public function actualizarMensaje (Request $request){
        $mensaje = Mensaje::find($request->idMensaje);
        $mensaje->idEvento = $request->idEvento;
        $mensaje->texto = $request->texto;
        $mensaje->save();
        return response()->json(['error'=>false,'mensaje' => $mensaje , 'respuesta' => 'El mensaje ha sido actualizado']); 
 }

}
