<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Lugar;
use DB;
use stdClass;

class LugarController extends Controller {

    public function all(Request $request){
        $lugar = Lugar::orderBy('idLugar', 'desc')->take(5)->get();
        return response()->json(['error'=>false,'lugar' => $lugar]);
    }

    public function allDepartamento(Request $request){
        $lugar = Lugar::where('departamento' , $request->idDepartamento)->get();
        return response()->json(['error'=>false,'lugar' => $lugar]);
    }

    public function create(Request $request) {

        $lugar = new Lugar();
        $lugar->nombre = $request->nombre;
        $lugar->descripcion = $request->descripcion;
        $lugar->capacidad = $request->capacidad;
        $lugar->direccion = $request->direccion;
        $lugar->tipo = $request->tipo;
        $lugar->categoriaderecurso = $request->categoriaderecurso;
        $lugar->recurso = $request->recurso;
        $lugar->departamento = $request->departamento;
        $lugar->region = $request->region;
        $lugar->lat = $request->lat;
        $lugar->lng = $request->lng;
        $lugar->save();

        return response()->json(['error'=>false,'lugar' => $lugar, 'mensaje' => 'El lugar fue registrada exitosamente' ]);
    }
        
    


    public function update(Request $request) {
    
        $lugar = Lugar::find($request->idLugar);
        $lugar->nombre = $request->nombre;
        $lugar->descripcion = $request->descripcion;
        $lugar->capacidad = $request->capacidad;
        $lugar->direccion = $request->direccion;
        $lugar->tipo = $request->tipo;
        $lugar->categoriaderecurso = $request->categoriaderecurso;
        $lugar->recurso = $request->recurso;
        $lugar->departamento = $request->departamento;
        $lugar->region = $request->region;
        $lugar->lat = $request->lat;
        $lugar->lng = $request->lng;
        $lugar->save();
        return response()->json(['error'=>false,'lugar' => $lugar , 'mensaje' =>'El lugar fue actualizada exitosamente']);
    }

    public function delete(Request $request){
        $lugar = Lugar::find($request->idLugar);
        $lugar->delete();
        return response()->json(['error'=>false,'lugar' => $lugar , 'mensaje' => 'El lugar ha sido eliminado']); 
   }

   public function ReporteLugar (){
          
        /*TIPO
             0: Edificaciones; 1: Edificios y Expresiones Religiosos; 2: Realizaciones técnico cientificas; 3: Parque Natural; 4: Monumentos; 5: Rios; 6: Arroyos; 7: Actividad Turística; 8: Festivales y Fiestas; 9: Expresiones Religiosas; 10: Ferias y Exposiciones; 11: Gastronomía; 12: Grupos Culturales ; 13: Pueblos indigenas; 14: Balneario; 15: Artesania; 16: Museo; 17: Tradiciones-Cuentos-Bailes; 18: Eco Turismo; 19: Acequia; 20: Humedades; 21: Quebradas; 22: Cienagas; 23: Biblioteca; 24: escuelas;

        CATEGORIA DE RECURSOS
             0: Arquitectónico; 1: Destinos Naturales; 2: Destinos Turísticos; 3: Eventos Artísticos y Culturales; 4: Manifestaciones Folcloricas; 5: Grupos Étnicos; 6: Formacion cultural; 
        RECURSOS
             0: Recursos Culturales; 1: Destinos Naturales y Turísticos; 2: Festividades y Eventos;

        */
        $lugares = Lugar::all();
        $cantLugares = Lugar::count();
        $Edificaciones = 0;
        $EyEReligioso = 0;
        $Realizacionestec = 0;
        $ParqueNat = 0;
        $Monumentos = 0;
        $Rios = 0;
        $Arroyos = 0;
        $ActividadT = 0;
        $FestivalesFiestas = 0;
        $ExpresionesR = 0;
        $FeriasyExpo = 0;
        $Gastronomia = 0;
        $GruposCulturales = 0;
        $PueblosIndigenas = 0;
        $Balneario = 0;
        $Artesania = 0;
        $Museo = 0;
        $tcb = 0;
        $ecoTurismo = 0;
        $Acequia = 0;
        $Humedades = 0;
        $Quebradas = 0;
        $Cienagas = 0;
        $Biblioteca = 0;
        $escuelas = 0;
        $tipoArray = array();
        $reporte = new stdClass();
        $resultado = new stdClass();

        $recursosCulturales = lugar::where('recurso' , 0)->count();
        $destinos =  lugar::where('recurso' , 1)->count();
        $festividades = lugar::where('recurso' , 2)->count();
       
        $resultado->cantLugares = $cantLugares;
        $resultado->recursosCulturales = $recursosCulturales;
        $resultado->destinos = $destinos;
        $resultado->festividades = $festividades;
        $Edificaciones = lugar::where('tipo' , 0)->count();
        $EyEReligioso = lugar::where('tipo' , 1)->count();
        $Realizacionestec = lugar::where('tipo' , 2)->count();
        $ParqueNat = lugar::where('tipo' , 3)->count();
        $Monumentos = lugar::where('tipo' , 4)->count();
        $Rios = lugar::where('tipo' , 5)->count();
        $Arroyos = lugar::where('tipo' , 6)->count();
        $ActividadT = lugar::where('tipo' , 7)->count();
        $FestivalesFiestas = lugar::where('tipo' , 8)->count();
        $ExpresionesR = lugar::where('tipo' , 9)->count();
        $FeriasyExpo = lugar::where('tipo' , 10)->count();
        $Gastronomia = lugar::where('tipo' , 11)->count();
        $GruposCulturales = lugar::where('tipo' , 12)->count(); 
        $PueblosIndigenas = lugar::where('tipo' , 13)->count();
        $Balneario = lugar::where('tipo' , 14)->count();
        $Artesania = lugar::where('tipo' , 15)->count();
        $Museo = lugar::where('tipo' , 16)->count();
        $tcb = lugar::where('tipo' , 17)->count();
        $ecoTurismo = lugar::where('tipo' , 18)->count();
        $Acequia = lugar::where('tipo' , 19)->count();        
        $Humedades = lugar::where('tipo' , 20)->count();
        $Cienagas = lugar::where('tipo' , 21)->count();    
        $Biblioteca = lugar::where('tipo' , 22)->count();
        $escuelas = lugar::where('tipo' , 23)->count();

        if ($Edificaciones != 0) {
            $obj =  new stdClass();
            $obj->numero = 0;
            $obj->nombre = 'Edificaciones';
            $obj->cantidad = $Edificaciones;
            $obj->color = '#3c8dbc';
            array_push($tipoArray, $obj);
        }
         if ($EyEReligioso != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Edificios y Expresiones Religiosos';
            $obj->cantidad = $EyEReligioso;
            $obj->color = '#00c0ef';
            array_push($tipoArray, $obj);
        }
         if ($Realizacionestec != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Realizaciones técnico cientificas';
            $obj->cantidad = $Realizacionestec;
            $obj->color = '#00a65a';
            array_push($tipoArray, $obj);
        }
        if ($ParqueNat != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Parques Naturales';
            $obj->cantidad = $ParqueNat;
            $obj->color = '#f39c12';
            array_push($tipoArray, $obj);
        }
        if ($Monumentos != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Monumentos';
            $obj->cantidad = $Monumentos;
            $obj->color = '#f56954';
            array_push($tipoArray, $obj);
        }
        if ($Rios != 0) {
            $obj =  new stdClass();
            $obj->numero = 5;
            $obj->nombre = 'Rios';
            $obj->cantidad = $Rios;
            $obj->color = '#d2d6de';
            array_push($tipoArray, $obj);
        }
        if ($Arroyos != 0) {
            $obj =  new stdClass();
            $obj->numero = 6;
            $obj->nombre = 'Arroyos';
            $obj->cantidad = $Arroyos;
            $obj->color = '#001F3F';
            array_push($tipoArray, $obj);
        }
        if ($ActividadT != 0) {
            $obj =  new stdClass();
            $obj->numero = 7;
            $obj->nombre = 'Actividades Turísticas';
            $obj->cantidad = $ActividadT;
            $obj->color = '#39CCCC';
            array_push($tipoArray, $obj);
        }
        if ($FestivalesFiestas != 0) {
            $obj =  new stdClass();
            $obj->numero = 8;
            $obj->nombre = 'Festividades y Fiestas';
            $obj->cantidad = $FestivalesFiestas;
            $obj->color = '#605ca8';
            array_push($tipoArray, $obj);
        }
        if ($ExpresionesR != 0) {
            $obj =  new stdClass();
            $obj->numero = 9;
            $obj->nombre = 'Expresiones Religiosas';
            $obj->cantidad = $ExpresionesR;
            $obj->color = '#ff851b';
            array_push($tipoArray, $obj);
        }
        if ($FeriasyExpo != 0) {
            $obj =  new stdClass();
            $obj->numero = 10;
            $obj->nombre = 'Ferias y Exposiciones';
            $obj->cantidad = $FeriasyExpo;
            $obj->color = '#D81B60';
            array_push($tipoArray, $obj);
        }
        if ($Gastronomia != 0) {
            $obj =  new stdClass();
            $obj->numero = 11;
            $obj->nombre = 'Gastronomia';
            $obj->cantidad = $Gastronomia;
            $obj->color = '#111111';
            array_push($tipoArray, $obj);
        }
        if ($GruposCulturales != 0) {
            $obj =  new stdClass();
            $obj->numero = 12;
            $obj->nombre = 'Grupos Culturales';
            $obj->cantidad = $GruposCulturales;
            $obj->color = '#5ca1a8';
            array_push($tipoArray, $obj);
        }
        if ($PueblosIndigenas != 0) {
            $obj =  new stdClass();
            $obj->numero = 13;
            $obj->nombre = 'Pueblos Indigenas';
            $obj->cantidad = $PueblosIndigenas;
            $obj->color = '#5ca87a';
            array_push($tipoArray, $obj);
        }
        if ($Balneario != 0) {
            $obj =  new stdClass();
            $obj->numero = 14;
            $obj->nombre = 'Balneario';
            $obj->cantidad = $Balneario;
            $obj->color = '#7da85c';
            array_push($tipoArray, $obj);
        }
        if ($Artesania != 0) {
            $obj =  new stdClass();
            $obj->numero = 15;
            $obj->nombre = 'Artesania';
            $obj->cantidad = $Artesania;
            $obj->color = '#d0bf49';
            array_push($tipoArray, $obj);
        }
        if ($Museo != 0) {
            $obj =  new stdClass();
            $obj->numero = 16;
            $obj->nombre = 'Museo';
            $obj->cantidad = $Museo;
            $obj->color = '#de2a6c';
            array_push($tipoArray, $obj);
        }
        if ($tcb != 0) {
            $obj =  new stdClass();
            $obj->numero = 17;
            $obj->nombre = 'Tradiciones-Cuentos-Bailes';
            $obj->cantidad = $tcb;
            $obj->color = '#a12ade';
            array_push($tipoArray, $obj);
        }
        if ($ecoTurismo != 0) {
            $obj =  new stdClass();
            $obj->numero = 18;
            $obj->nombre = 'Eco-Turismo';
            $obj->cantidad = $ecoTurismo;
            $obj->color = '#2a8bde';
            array_push($tipoArray, $obj);
        }
        if ($Acequia != 0) {
            $obj =  new stdClass();
            $obj->numero = 19;
            $obj->nombre = 'Acequia';
            $obj->cantidad = $Acequia;
            $obj->color = '#18247b';
            array_push($tipoArray, $obj);
        }
        if ($Humedades != 0) {
            $obj =  new stdClass();
            $obj->numero = 20;
            $obj->nombre = 'Humedades';
            $obj->cantidad = $Humedades;
            $obj->color = '#7b1826';
            array_push($tipoArray, $obj);
        }
        if ($Cienagas != 0) {
            $obj =  new stdClass();
            $obj->numero = 21;
            $obj->nombre = 'Cienagas';
            $obj->cantidad = $Cienagas;
            $obj->color = '#f17ced';
            array_push($tipoArray, $obj);
        }
        if ($Biblioteca != 0) {
            $obj =  new stdClass();
            $obj->numero = 22;
            $obj->nombre = 'Biblioteca';
            $obj->cantidad = $Biblioteca;
            $obj->color = '#7e7cf1';
            array_push($tipoArray, $obj);
        }
        if ($escuelas != 0) {
            $obj =  new stdClass();
            $obj->numero = 23;
            $obj->nombre = 'Escuelas';
            $obj->cantidad = $escuelas;
            $obj->color = '#dd4b39';
            array_push($tipoArray, $obj);
        }
        



        return response()->json(['error'=>false,'reporte' => $tipoArray , 'resultado' => $resultado ]); 

    }    

   }



