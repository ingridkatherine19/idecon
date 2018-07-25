<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Restaurante;
use App\Modelos\Servicio;
use App\Modelos\Serviciorestaurante;
use App\Modelos\Proteinarestaurante;
use DB;
use stdClass;

class RestauranteController extends Controller {

    public function all(Request $request){
        $restaurante = Restaurante::orderBy('idRestaurante', 'desc')->take(5)->get();
        $contador = Restaurante::count();

        return response()->json(['error'=>false,'restaurante' => $restaurante ,'cantidad' => $contador]);
    }

    public function allDepartamento(Request $request){
        $restaurante = Restaurante::where('departamento' , $request->idDepartamento)->get();
        $contador = count($restaurante);

        return response()->json(['error'=>false,'restaurante' => $restaurante ,'cantidad' => $contador]);
    }
    public function servicioall(Request $request){
        $servicio = Servicio::all();
        return response()->json(['error'=>false,'servicio' => $servicio]);
    }

    public function create(Request $request) {
    
     $proteinas = json_decode($request->proteina);
     $servicios = json_decode($request->servicios);
     
    // dd($servicios);
            $restauranteN = new Restaurante();
            $restauranteN->nombre = $request->nombre;
            $restauranteN->gerente = $request->gerente;
            $restauranteN->direccion = $request->direccion;
            $restauranteN->telefono = $request->telefono;
            $restauranteN->correo = $request->correo;
            $restauranteN->facebook = $request->facebook;
            $restauranteN->twitter = $request->twitter;
            $restauranteN->instagram = $request->instagram;
            $restauranteN->youtube = $request->youtube;
            $restauranteN->tipoRestaurante = $request->tipoRestaurante;
            $restauranteN->detalle = $request->detalle;
            $restauranteN->lat = $request->lat;
            $restauranteN->lng = $request->lng;
            $restauranteN->save();

            foreach ($servicios as $s) {
                $servicio = new Serviciorestaurante();
                $servicio->idRestaurante = $restauranteN->idRestaurante;
                $servicio->valor = $s->value;
                $servicio->save();
            }
            foreach ($proteinas as $p) {
                $proteina = new Proteinarestaurante();
                $proteina->idRestaurante = $restauranteN->idRestaurante;
                $proteina->valor = $p->value;
                $proteina->save();
            }
            
        return response()->json(['error'=>false,'restaurante' => $restauranteN, 'mensaje' => 'El restaurante fue registrado con éxito' ]);
          }
        
    

    public function update(Request $request) {
        $proteinas = json_decode($request->proteina);
        $servicios = json_decode($request->servicios);
        $restauranteN = Restaurante::find($request->idRestaurante);
        $restauranteN->nombre = $request->nombre;
        $restauranteN->gerente = $request->gerente;
        $restauranteN->direccion = $request->direccion;
        $restauranteN->telefono = $request->telefono;
        $restauranteN->correo = $request->correo;
        $restauranteN->facebook = $request->facebook;
        $restauranteN->twitter = $request->twitter;
        $restauranteN->instagram = $request->instagram;
        $restauranteN->youtube = $request->youtube;
        $restauranteN->tipoRestaurante = $request->tipoRestaurante;
        $restauranteN->detalle = $request->detalle;
        $restauranteN->lat = $request->lat;
        $restauranteN->lng = $request->lng;
        $restauranteN->save();

        $serv = Serviciorestaurante::where('idRestaurante' , $restauranteN->idRestaurante)->get();
        if (isset($serv[0])) {
            if (count($serv) > 0) {
                foreach ($serv as $s) {
                    $s->delete();
                }
            }elseif (count($serv) == 0) {
                $serv[0]->delete();
            }
        }
        $prot = Proteinarestaurante::where('idRestaurante' , $restauranteN->idRestaurante)->get();
        if (isset($prot[0])) {
            if (count($prot) > 0) {
                foreach ($prot as $p) {
                    $p->delete();
                }
            }elseif (count($prot) == 0) {
                $prot[0]->delete();
            }
        }
        foreach ($servicios as $s) {
            $servicio = new Serviciorestaurante();
            $servicio->idRestaurante = $restauranteN->idRestaurante;
            $servicio->valor = $s->value;
            $servicio->save();
        }
        foreach ($proteinas as $p) {
            $proteina = new Proteinarestaurante();
            $proteina->idRestaurante = $restauranteN->idRestaurante;
            $proteina->valor = $p->value;
            $proteina->save();
        }
        return response()->json(['error'=>false,'restaurante' => $restauranteN , 'mensaje' =>'El restaurante fue actualizado exitosamente']);
    }

    public function delete(Request $request){
        $restaurante = Restaurante::find($request->idRestaurante);
        $prot = Proteinarestaurante::where('idRestaurante' , $restaurante->idRestaurante)->get();
        if (isset($prot[0])) {
            if (count($prot) > 0) {
                foreach ($prot as $p) {
                    $p->delete();
                }
            }elseif (count($prot) == 0) {
                $prot[0]->delete();
            }
        }
        $serv = Serviciorestaurante::where('idRestaurante' , $restaurante->idRestaurante)->get();
        if (isset($serv[0])) {
            if (count($serv) > 0) {
                foreach ($serv as $s) {
                    $s->delete();
                }
            }elseif (count($serv) == 0) {
                $serv[0]->delete();
            }
        }
        $restaurante->delete();
        return response()->json(['error'=>false,'restaurante' => $restaurante , 'mensaje' => 'El restaurante ha sido eliminado']); 
    }

    public function Buscar (Request $request) {
        $servicios = Serviciorestaurante::where('idRestaurante' , $request->idRestaurante)->get();
        $proteinas = Proteinarestaurante::where('idRestaurante' , $request->idRestaurante)->get();
        
        return response()->json(['error'=>false,'servicios' => $servicios , 'proteinas' => $proteinas]); 
    }

    public function reporteRestaurante (){
        /*
            SERVICIOS: 0: Desayuno, 1: Almuerzo; 2: Comida; 3: Salon de Eventos; 4: Domicilios; 5: Wifi; 6: T Credito; 7: Bebidas y Jugos; 8: Bebidas Alcoholicas; 9: Reservas; 10: Salon Privado.


            TIPO DE RESTAURANTE : 0:Restaurantes de lujo; 1:Restaurantes de primera;2: Restaurantes de segunda; 3: Restaurante de tercera; 4: restaurante de cuarta

            Detalles: 
                0: grill-room o parrilla,
                1: Buffet,
                2: Especialidades (Temáticos),
                3: Cocina Francesa,
                4: Cocina Española,
                5: Cocina Italiana,
                6: Cocina Mexicana,
                7: Cocina Colombiana,
                8: Cocina Caribeña,
                9: Fast Food,
                10: Gourmet,
                11: Take Away

        */
        $desayuno = 0;
        $almuerzo = 0;
        $comida = 0;
        $salonEventos = 0;
        $domicilios = 0;
        $wifi = 0;
        $tarjetaC = 0;
        $bebidayjugo = 0;
        $bebidasA = 0;
        $reserva = 0;
        $salonP = 0;
        $lujo = 0;
        $primera = 0;
        $segunda = 0;
        $tercera = 0;
        $cuarta = 0;
        $cantRestaurantes = Restaurante::count();
        $tipoRestaurante = array();
        $servicioArray = array();
        $reporteServicio = new stdClass();

        $lujo = Restaurante::where('tipoRestaurante' , 0)->count();
        $primera = Restaurante::where('tipoRestaurante' , 1)->count();
        $segunda = Restaurante::where('tipoRestaurante' , 2)->count();
        $tercera = Restaurante::where('tipoRestaurante' , 3)->count();
        $cuarta = Restaurante::where('tipoRestaurante' , 4)->count();
         if ($lujo != 0) {
            $obj =  new stdClass();
            $obj->numero = 0;
            $obj->nombre = 'Restaurante de Lujo';
            $obj->cantidad = $lujo;
            $obj->color = '#00a65a';
            array_push($tipoRestaurante, $obj);
        }
        if ($primera != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Restaurante de Primera';
            $obj->cantidad = $primera;
            $obj->color = '#f39c12';
            array_push($tipoRestaurante, $obj);
        }
        if ($segunda != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Restaurante de Segunda';
            $obj->cantidad = $segunda;
            $obj->color = '#f56954';
            array_push($tipoRestaurante, $obj);
        }
        if ($tercera != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Restaurante de Tercera';
            $obj->cantidad = $tercera;
            $obj->color = '#d2d6de';
            array_push($tipoRestaurante, $obj);
        }
        if ($cuarta != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Restaurante de Cuarta';
            $obj->cantidad = $cuarta;
            $obj->color = '#001F3F';
            array_push($tipoRestaurante, $obj);
        }

            $desayuno = Serviciorestaurante::where('valor' , 0)->count();
            if ($desayuno != 0) {
                $obj =  new stdClass();
                $obj->numero = 0;
                $obj->nombre = 'Desayuno';
                $obj->cantidad = $desayuno;
                $obj->color = '#3c8dbc';
                array_push($servicioArray, $obj);
            }
            $almuerzo = Serviciorestaurante::where('valor' , 1)->count();
            if ($almuerzo != 0) {
                $obj =  new stdClass();
                $obj->numero = 1;
                $obj->nombre = 'Almuerzo';
                $obj->cantidad = $almuerzo;
                $obj->color = '#00c0ef';
                array_push($servicioArray, $obj);
            }
            $comida = Serviciorestaurante::where('valor' , 2)->count();
            if ($comida != 0) {
              
                $obj =  new stdClass();
                $obj->numero = 2;
                $obj->nombre = 'Comida';
                $obj->cantidad = $comida;
                $obj->color = '#00a65a';
                array_push($servicioArray, $obj);
            }
            $salonEventos = Serviciorestaurante::where('valor' , 3)->count();
            if ($salonEventos != 0) {
                $obj =  new stdClass();
                $obj->numero = 3;
                $obj->nombre = 'Salon de Eventos';
                $obj->cantidad = $salonEventos;
                $obj->color = '#f39c12';
                array_push($servicioArray, $obj);
            }
            $domicilios = Serviciorestaurante::where('valor' , 4)->count();
            if ($domicilios != 0) {
                $obj =  new stdClass();
                $obj->numero = 4;
                $obj->nombre = 'Domicilios';
                $obj->cantidad = $domicilios;
                $obj->color = '#f56954';
                array_push($servicioArray, $obj);
            }
            $wifi = Serviciorestaurante::where('valor' , 5)->count();

            if ($wifi != 0) {
                $obj =  new stdClass();
                $obj->numero = 5;
                $obj->nombre = 'Wi-fi';
                $obj->cantidad = $wifi;
                $obj->color = '#d2d6de';
                array_push($servicioArray, $obj);
            }
            $tarjetaC = Serviciorestaurante::where('valor' , 6)->count();

            if ($tarjetaC != 0) {
                $obj =  new stdClass();
                $obj->numero = 6;
                $obj->nombre = 'Tarjeta de Crédito';
                $obj->cantidad = $tarjetaC;
                $obj->color = '#001F3F';
                array_push($servicioArray, $obj);
            }

            $bebidayjugo = Serviciorestaurante::where('valor' , 7)->count();
            if ($bebidayjugo != 0) {
                $obj =  new stdClass();
                $obj->numero = 7;
                $obj->nombre = 'Bebidas y Jugos';
                $obj->cantidad = $bebidayjugo;
                $obj->color = '#39CCCC';
                array_push($servicioArray, $obj);
            }

            $bebidasA = Serviciorestaurante::where('valor' , 8)->count();
            if ($bebidasA != 0) {
                $obj =  new stdClass();
                $obj->numero = 8;
                $obj->nombre = 'Bebidas Alcoholicas';
                $obj->cantidad = $bebidasA;
                $obj->color = '#605ca8';
                array_push($servicioArray, $obj);
            } 
            $reserva = Serviciorestaurante::where('valor' , 9)->count();
            if ($reserva != 0) {
                $obj =  new stdClass();
                $obj->numero = 9;
                $obj->nombre = 'Reservas';
                $obj->cantidad = $reserva;
                $obj->color = '#ff851b';
                array_push($servicioArray, $obj);
            } 
            $salonP = Serviciorestaurante::where('valor' , 10)->count();
            if ($salonP != 0) {
                $obj =  new stdClass();
                $obj->numero = 10;
                $obj->nombre = 'Salón Privado';
                $obj->cantidad = $salonP;
                $obj->color = '#ff851b';
                array_push($servicioArray, $obj);
            } 

           // dd($servicioArray , $tipoRestaurante);
        return response()->json(['error'=>false,'servicio' => $servicioArray , 'tipoRestaurante' => $tipoRestaurante]); 
        
    }


}
