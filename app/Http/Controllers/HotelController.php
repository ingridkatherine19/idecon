<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Hotel;
use stdClass;
use DB;

class HotelController extends Controller {


    /* 1:Hotel ; 2: Apartamentos y suites ; 3: Hostal; 4: Residencia; 5: Casas; 6: Hotel Boutique; 7: Complejo; 8: Fincas ; 9: Posada; 10: Centro Turístico  */

    public function all(Request $request){
        $hotel = Hotel::orderBy('idHotel', 'desc')->take(5)->get();
        $reporte = new hotel();
        $cantHotel = Hotel::count();
        $reporte->cantHotel = $cantHotel;
        //Cantidad y promedio de RNT
        $reporte->rtn = Hotel::where('rtn', '!=' , 0)->count();
        $reporte->rtnProm = $reporte->rtn * 100 / $cantHotel;
        //Cantidad y promedio en tripadvisor
        $reporte->tripadvisor = Hotel::where('tripadvisor', 1)->count();
        $reporte->tripadvisorProm = $reporte->tripadvisor * 100 / $cantHotel;
        //Cantidad y promedio de cantidad de camas
        $reporte->cantCama = Hotel::sum('habitaciones');
        $reporte->camaProm = $reporte->cantCama * 100 / $cantHotel;
        //Cantidad y Promedio de parqueaderos
        $reporte->cantParqueaderos = Hotel::where('parqueadero' , 1)->count();
        $reporte->parqueaderoProm = $reporte->cantParqueaderos * 100 / $cantHotel;
        //Cantidad y Promedio TV
        $reporte->cantTv = Hotel::where('tv' , 1)->count();
        $reporte->tvProm = $reporte->cantTv * 100 / $cantHotel;

        //Cantidad y Promedio jardin
        $reporte->cantJardin = Hotel::where('jardin' , 1)->count();
        $reporte->jardinProm = $reporte->cantJardin * 100 / $cantHotel;

        //Cantidad y Promedio de artesania 
        $reporte->cantArtesania = Hotel::where('artesania' , 1)->count();
        $reporte->artesaniaProm = $reporte->cantArtesania * 100 / $cantHotel;

        //Cantidad y Promedio de Wifi
        $reporte->cantWifi = Hotel::where('wifi' , 1)->count();    
        $reporte->wifiProm = $reporte->cantWifi * 100 / $cantHotel;
        //Cantidad y Promedio de Lavanderia 
        $reporte->cantLavanderia = Hotel::where('lavanderia' , 1)->count();   
        $reporte->lavanderiaProm = $reporte->cantLavanderia * 100 / $cantHotel;
        //Cantidad y Promedio de piscina
        $reporte->cantPiscina = Hotel::where('piscina' , 1)->count();
        $reporte->piscinaProm = $reporte->cantPiscina * 100 / $cantHotel;
        //Cantidad y Promedio Bar
        $reporte->cantBar = Hotel::where('bar' , 1)->count();
        $reporte->barProm = $reporte->cantBar * 100 / $cantHotel;
    
      //cantidad y promedio roomservice
        $reporte->cantRoomservice = Hotel::where('roomservice' , 1)->count();
        $reporte->roomserviceProm = $reporte->cantRoomservice * 100 / $cantHotel;

        //cantidad y promedio restaurante
        $reporte->cantRestaurante = Hotel::where('restaurante' , 1)->count();
        $reporte->restauranteProm = $reporte->cantRestaurante * 100 / $cantHotel;
        
        //cantidad y promedio gimnasio
        $reporte->cantGimnasio = Hotel::where('gimnasio' , 1)->count();
        $reporte->gimnasioProm = $reporte->cantGimnasio * 100 / $cantHotel;

        //cantidad y promedio areasociales
        $reporte->cantAreasociales = Hotel::where('areasociales' , 1)->count();
        $reporte->areasocialesProm = $reporte->cantAreasociales * 100 / $cantHotel;

        //cantidad y promedio llamadaGratis
        $reporte->cantllamada = Hotel::where('llamadaGratis' , 1)->count();
        $reporte->llamadaProm =  $reporte->cantllamada * 100 / $cantHotel;

        //cantidad y promedio vipareasocial
        $reporte->cantVip = Hotel::where('vipareasocial' , 1)->count();
        $reporte->vipProm = $reporte->cantVip * 100 / $cantHotel;
        //cantidad y promedio salonEventos
        $reporte->cantSocial = Hotel::where('salonEventos' , 1)->count();
        $reporte->socialProm = $reporte->cantSocial * 100 / $cantHotel;
        $reporte->cantAire = Hotel::where('aire' , 1)->count();
        $reporte->aireProm = $reporte->cantAire * 100 / $cantHotel;
        
        /*REPORTE DE CATEGORIAS QUE EXISTEN*/

        /* 1:Hotel ; 2: Apartamentos y suites ; 3: Hostal; 4: Residencia; 5: Casas; 6: Hotel Boutique; 7: Complejo; 8: Fincas ; 9: Posada; 10: Centro Turístico  */
     
        $categoriaArray = array();
      
        $hotelC = Hotel::where('categoria', 1)->count();
        $promhotelC = ($hotelC * 100)/ $cantHotel;
        $apartamento = Hotel::where('categoria', 2)->count();
        $promApartamento = ($apartamento * 100)/ $cantHotel;
        $hostal = Hotel::where('categoria', 3)->count();
        $promHostal = ($hostal * 100)/ $cantHotel;
        $residencia = Hotel::where('categoria', 4)->count();
        $promResidencia =  ($residencia * 100)/ $cantHotel;
        $casas = Hotel::where('categoria', 5)->count();
        $promCasas =  ($casas * 100)/ $cantHotel;
        $boutique = Hotel::where('categoria', 6)->count();
        $promBoutique =  ($boutique * 100)/ $cantHotel;
        $complejo = Hotel::where('categoria', 7)->count();
        $promComplejo =  ($complejo * 100)/ $cantHotel;
        $fincas = Hotel::where('categoria', 8)->count();
        $promFincas =  ($fincas * 100)/ $cantHotel;
        $posada = Hotel::where('categoria', 9)->count();
        $promPosada =  ($posada * 100)/ $cantHotel;
        $centro = Hotel::where('categoria', 10)->count();
        $promCentro =  ($centro * 100)/ $cantHotel;


        if ($hotelC != 0) {

             $obj =  new stdClass();
             $obj->numero = 0;
             $obj->nombre = 'Hotel';
             $obj->cantidad = $hotelC;
             $obj->promedio = $promhotelC;
             $obj->color = '#3c8dbc'; 
             array_push($categoriaArray, $obj);

        }
        if ($apartamento != 0) {
             $obj =  new stdClass();
             $obj->numero = 1;
             $obj->nombre = 'Apartamento';
             $obj->cantidad = $apartamento;
             $obj->promedio = $promApartamento; 
             $obj->color = '#00a65a'; 
             array_push($categoriaArray, $obj);
        }

        if ($hostal != 0) {
             $obj =  new stdClass();
             $obj->numero = 2;
             $obj->nombre = 'Hostal';
             $obj->cantidad = $hostal;
             $obj->promedio = $promHostal; 
             $obj->color = '#D81B60';
             array_push($categoriaArray, $obj);
        }
        if ($residencia != 0) {
            $obj =  new stdClass();
             $obj->numero = 3;
             $obj->nombre = 'Residencia';
             $obj->cantidad = $residencia;
             $obj->promedio = $promResidencia; 
             $obj->color = '#605ca8';
             array_push($categoriaArray, $obj);
        }
          if ($casas != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Casas';
            $obj->cantidad = $casas;
            $obj->promedio = $promCasas; 
            $obj->color = '#f56954';
            array_push($categoriaArray, $obj);
        }
        if ($boutique != 0) {
            $obj =  new stdClass();
            $obj->numero = 5;
            $obj->nombre = 'Hotel Boutique';
            $obj->cantidad = $boutique;
            $obj->promedio = $promBoutique; 
            $obj->color = '#d2d6de';
            array_push($categoriaArray, $obj);
        }
        if ($complejo != 0) {
            $obj =  new stdClass();
            $obj->numero = 6;
            $obj->nombre = 'Complejos';
            $obj->cantidad = $complejo;
            $obj->promedio = $promComplejo; 
            $obj->color = '#001F3F';
            array_push($categoriaArray, $obj);
        }
        if ($fincas != 0) {
            $obj =  new stdClass();
            $obj->numero = 7;
            $obj->nombre = 'Fincas';
            $obj->cantidad = $fincas;
            $obj->promedio = $promFincas; 
            $obj->color = '#39CCCC';
            array_push($categoriaArray, $obj);
        }
        if ($posada != 0) {
            $obj =  new stdClass();
            $obj->numero = 8;
            $obj->nombre = 'Posadas';
            $obj->cantidad = $posada;
            $obj->promedio = $promPosada;
            $obj->color = '#605ca8';
            array_push($categoriaArray, $obj);
        }
        if ($centro != 0) {
            $obj =  new stdClass();
            $obj->numero = 9;
            $obj->nombre = 'Centro Turístico';
            $obj->cantidad = $centro;
            $obj->promedio = $promCentro;
            $obj->color = '#ff851b';
            array_push($categoriaArray, $obj);
        }
      
    return response()->json(['hotel' => $hotel , 'reporte' => $reporte , 'cantHotel' => $cantHotel , 'categoria' => $categoriaArray ]);
    }

    public function allDepartamento(Request $request){
        $hotel = Hotel::where('departamento' , $request->idDepartamento)->get();
        return response()->json(['hotel' => $hotel ]);
    }
    
    public function Create(Request $request) {
        $datos = json_decode($request->datos);
      //  $ciudad = json_decode($request->ciudad);
       
        $hotel = new Hotel();
        $hotel->nombre = $request->nombre;
        $hotel->direccion = $request->direccion;
        $hotel->categoria = $request->categoria;
        $hotel->telefono = $request->telefono;
        $hotel->telefono2 = $request->telefono2;
        $hotel->correo = $request->correo;
        $hotel->departamento = $request->departamento;
        $hotel->ciudad = $request->ciudad;
        $hotel->gerente = $request->gerente;
        $hotel->pagina = $request->pagina;
        $hotel->habitaciones = $request->habitaciones;
        $hotel->capacidadMax = $request->capacidadMax;
        $hotel->lat = $request->lat;
        $hotel->lng = $request->lng;
       
        foreach ($datos as $d) {
        
            if ($d->value == 0) {
               $hotel->rtn = 1;
            }elseif ($d->value == 1) {
                $hotel->parqueadero = 1;
            }elseif ($d->value == 2) {
                $hotel->aire = 1;
            }elseif ($d->value == 3) {
                $hotel->tv = 1;
            }elseif ($d->value == 4) {
                $hotel->jardin = 1;
            }elseif ($d->value == 5) {
                $hotel->artesania = 1;
            }elseif ($d->value == 6) {
                $hotel->wifi = 1;
            }elseif ($d->value == 7) {
                $hotel->lavanderia = 1;
            }elseif ($d->value == 8) {
                $hotel->piscina = 1;
            }elseif ($d->value == 9) {
                $hotel->bar = 1;
            }elseif ($d->value == 10) {
                $hotel->roomservice = 1;
            }elseif ($d->value == 11) {
                $hotel->restaurante = 1;
            }elseif ($d->value == 12) {
                $hotel->gimnasio = 1;
            }elseif ($d->value == 13) {
                $hotel->areasociales = 1;
            }elseif ($d->value == 14) {
               $hotel->llamadaGratis = 1;
            }elseif ($d->value == 15) {
                $hotel->vipareasocial = 1;
            }elseif ($d->value == 16) {
                $hotel->salonEventos = 1;
            }elseif ($d->value == 17) {
                $hotel->tripadvisor = 1;
            }
        }
    
    
        $hotel->save();
        return response()->json(['error'=>false,'hotel' => $hotel, 'mensaje' => 'El hotel fue registrado con éxito' ]);
    }

    public function Update(Request $request) {
        $datos = json_decode($request->datos);
        $ciudad = json_decode($request->ciudad);
        $hotel = Hotel::find($request->idHotel);
        $hotel->nombre = $request->nombre;
        $hotel->direccion = $request->direccion;
        $hotel->categoria = $request->categoria;
        $hotel->telefono = $request->telefono;
        $hotel->telefono2 = $request->telefono2;
        $hotel->correo = $request->correo;
        $hotel->departamento = $request->departamento;
        $hotel->ciudad = $request->ciudad;
        $hotel->gerente = $request->gerente;
        $hotel->pagina = $request->pagina;
        $hotel->habitaciones = $request->habitaciones;
        $hotel->capacidadMax = $request->capacidadMax;
        $hotel->lat = $request->lat;
        $hotel->lng = $request->lng;
       
        foreach ($datos as $d) {
        
            if ($d->value == 0) {
               $hotel->rtn = 1;
            }elseif ($d->value == 1) {
                $hotel->parqueadero = 1;
            }elseif ($d->value == 2) {
                $hotel->aire = 1;
            }elseif ($d->value == 3) {
                $hotel->tv = 1;
            }elseif ($d->value == 4) {
                $hotel->jardin = 1;
            }elseif ($d->value == 5) {
                $hotel->artesania = 1;
            }elseif ($d->value == 6) {
                $hotel->wifi = 1;
            }elseif ($d->value == 7) {
                $hotel->lavanderia = 1;
            }elseif ($d->value == 8) {
                $hotel->piscina = 1;
            }elseif ($d->value == 9) {
                $hotel->bar = 1;
            }elseif ($d->value == 10) {
                $hotel->roomservice = 1;
            }elseif ($d->value == 11) {
                $hotel->restaurante = 1;
            }elseif ($d->value == 12) {
                $hotel->gimnasio = 1;
            }elseif ($d->value == 13) {
                $hotel->areasociales = 1;
            }elseif ($d->value == 14) {
               $hotel->llamadaGratis = 1;
            }elseif ($d->value == 15) {
                $hotel->vipareasocial = 1;
            }elseif ($d->value == 16) {
                $hotel->salonEventos = 1;
            }elseif ($d->value == 17) {
                $hotel->tripadvisor = 1;
            }
        }
         $hotel->save();
        return response()->json(['error'=>false,'hotel' => $hotel , 'mensaje' =>'El hotel fue actualizado con exito']);
    }

    public function Delete(Request $request){
        $hotel = Hotel::find($request->idHotel);
        $hotel->delete();
        return response()->json(['error'=>false,'hotel' => $hotel , 'mensaje' => 'El hotel ha sido eliminada con exito']); 

    }



    


}
