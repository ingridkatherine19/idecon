<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modelos\Encuesta;
use App\Modelos\Encuesta2;
use App\Modelos\Pregunta;
use App\User;
use DB;
use stdClass;

class EncuestaController extends Controller {
  /*Encuesta 2 es la encuesta que se está usando actualmente.*/
    public function preguntaCreate (Request $request){
        $pregunta = new Pregunta();
        $pregunta->idEvento = $request->idEvento;
        $pregunta->pregunta  = $request->pregunta;
        $pregunta->tipo = $request->tipo;
        $pregunta->save();
        return response()->json(['error'=>false, 'pregunta' => $pregunta]);
    }

    public function buscar (Request $request){
      $existe = false;
      $preguntas = Pregunta::where('idEvento' , $request->idEvento)->get();
      foreach ($preguntas as $p) {
        $encuesta = Encuesta2::where('idEvento' , $p->idEvento)->where('idUsuario' , $request->idUsuario)->get();
      }
      if (isset($encuesta[0])) {
        $existe = true;
      }
      return response()->json(['error'=>false, 'preguntas' => $preguntas , 'existe' => $existe]);
    }

     public function Update(Request $request) {
    
        $pregunta = Pregunta::find($request->idPregunta);
        $pregunta->idEvento = $request->idEvento;
        $pregunta->pregunta  = $request->pregunta;
        $pregunta->save();
        return response()->json(['error'=>false,'pregunta' => $pregunta , 'mensaje' =>'La pregunta fue actualizada exitosamente']);
    }

    public function preguntaAll (Request $request){

        $pregunta = Pregunta::where('idEvento' , $request->idEvento)->get();
        return response()->json(['error'=>false, 'pregunta' => $pregunta]);
    }

    public function preguntaDelete (Request $request){
        $pregunta = Pregunta::find($request->idPregunta);
        $pregunta->delete();
        return response()->json(['error'=>false,'pregunta' => $pregunta , 'mensaje' => 'La pregunta fue eliminada exitosamente']); 
    }

    public function reporte(Request $request){
       $visitante = 0;
       $participante = 0;
       $promVisitante = 0;
       $promParticipante = 0;
       $promPesimo = 0;
       $orientacion = 0;
       $metodologiaEmpleada = 0;
       $desarrolloEvento = 0;
       $distribucionEspacio = 0;
       $logisticaEvento = 0;
       $general = 0;
       $medio = 0;
       $nuevoEvento = 0;
       $comentario = 0;
       $pesimo = 0;
       $promPesimo = 0;
       $malo = 0;
       $promMalo = 0;
       $regular = 0;
       $promRegular = 0;
       $bueno = 0;
       $promBueno = 0;
       $excelente = 0; 
       $promExcelente = 0;
       $nada = 0;
       $promNada = 0;
       $radio = 0;
       $television = 0;
       $correo = 0;
       $electronico = 0;
       $calificacionActividad = array();
       $orientacionArray = array();
       $metodologiaArray = array();
       $desarrolloArray = array();
       $distribucionArray = array();
       $logisticaArray = array();
       $generalArray = array();
       $tipoArray = array();
       $reporteMedios = array();
       $reporte = new stdClass(); 
       $valorG = 0;
       $cantEncuesta = Encuesta::count(); //CANTIDAD DE ENCUESTAS

       //REPORTE de tipo: Si es visitante o participante, 
       $visitante = Encuesta::where('tipo' , 0)->count();
       $participante = Encuesta::where('tipo' , 1)->count();
       $promVisitante = ($visitante * 100) / $cantEncuesta;
       $promParticipante = ($participante * 100) / $cantEncuesta;

       if ($visitante != 0) {
            $obj =  new stdClass();
            $obj->numero = 0;
            $obj->nombre = 'Visitante';
            $obj->cantidad = $visitante;
            $obj->promedio = $promVisitante;
            $obj->color = '#3c8dbc';
            array_push($tipoArray, $obj);
        }
        if ($participante != 0) {
            $obj =  new stdClass();
            $obj->numero = 0;
            $obj->nombre = 'Participante';
            $obj->cantidad = $participante;
            $obj->promedio = $promParticipante;
            $obj->color = '#3c8dbc';
            array_push($tipoArray, $obj);
        }

       //REPORTE POR CALIFICACION DE ACTIVIDAD
        $pesimo = Encuesta::where('calificacionActividad' , 1)->count();
        $promPesimo = ($pesimo * 100) /$cantEncuesta;
        $malo = Encuesta::where('calificacionActividad' , 2)->count();
        $promMalo = ($malo * 100) /$cantEncuesta;
        $regular = Encuesta::where('calificacionActividad' , 3)->count();
        $promRegular = ($regular * 100) / $cantEncuesta;
        $bueno = Encuesta::where('calificacionActividad' , 4)->count();
        $promBueno = ($bueno * 100) / $cantEncuesta;
        $excelente = Encuesta::where('calificacionActividad' , 5)->count();
        $promExcelente = ($excelente * 100) / $cantEncuesta;
        $nada = Encuesta::where('calificacionActividad' , 6)->count();
        $promNada = ($nada * 100) / $cantEncuesta;
        if ($pesimo != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Pesimo';
            $obj->cantidad = $pesimo;
            $obj->promedio = $promPesimo;
            $obj->color = '#f56954';
            array_push($calificacionActividad, $obj);
        }

        if ($malo != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Malo';
            $obj->cantidad = $malo;
            $obj->promedio = $promMalo;
            $obj->color = '#3c8dbc';
            array_push($calificacionActividad, $obj);
        }
        if ($regular != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Regular';
            $obj->cantidad = $regular;
            $obj->promedio = $promRegular;
            $obj->color = '#605ca8';
            array_push($calificacionActividad, $obj);
        }
        if ($bueno != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Bueno';
            $obj->cantidad = $bueno;
            $obj->promedio = $promBueno;
            $obj->color = '#18247b';
            array_push($calificacionActividad, $obj);

        }
        if ($excelente != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Excelente';
            $obj->cantidad = $excelente;
            $obj->promedio = $promExcelente;
            $obj->color = '#ff851b';
            array_push($calificacionActividad, $obj);
        }
        if ($nada != 0) {
            $obj =  new stdClass();
            $obj->numero = 5;
            $obj->nombre = 'Nada';
            $obj->cantidad = $nada;
            $obj->promedio = $promNada;
            $obj->color = '#f17ced';
            array_push($calificacionActividad, $obj);
        }


//////////////////////////////////////////////////////////////////
       //REPORTE POR Organización y desarrollo 

        $pesimo2 = 0;
        $promPesimo2 = 0;
        $malo2 = 0;
        $promMalo2 = 0;
        $regular2 = 0;
        $promRegular2 = 0;
        $bueno2 = 0;
        $promBueno2 = 0;
        $excelente2 = 0; 
        $promExcelente2 = 0;
        $nada2 = 0;
        $promNada2 = 0;
        $pesimo2 = Encuesta::where('orientacion' , 1)->count();
        $promPesimo2 = ($pesimo2 * 100) /$cantEncuesta;
        $malo2 = Encuesta::where('orientacion' , 2)->count();
        $promMalo2 = ($malo2 * 100) /$cantEncuesta;
        $regular2 = Encuesta::where('orientacion' , 3)->count();
        $promRegular2 = ($regular2 * 100) / $cantEncuesta;
        $bueno2 = Encuesta::where('orientacion' , 4)->count();
        $promBueno2 = ($bueno2 * 100) / $cantEncuesta;
        $excelente2 = Encuesta::where('orientacion' , 5)->count();
        $promExcelente2 = ($excelente2 * 100) / $cantEncuesta;
        $nada2 = Encuesta::where('orientacion' , 6)->count();

         $promNada2 = ($nada * 100) / $cantEncuesta;
        if ($pesimo2 != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Pesimo';
            $obj->cantidad = $pesimo2;
            $obj->promedio = $promPesimo2;
            $obj->color = '#5ca87a';
            array_push($orientacionArray, $obj);
        }

        if ($malo2 != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Malo';
            $obj->cantidad = $malo2;
            $obj->promedio = $promMalo2;
            $obj->color = '#d2d6de';
            array_push($orientacionArray, $obj);
        }
        if ($regular2 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Regular';
            $obj->cantidad = $regular2;
            $obj->promedio = $promRegular2;
            $obj->color = '#7b1826';
            array_push($orientacionArray, $obj);
        }
        if ($bueno2 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Bueno';
            $obj->cantidad = $bueno2;
            $obj->promedio = $promBueno2;
            $obj->color = '#de2a6c';
            array_push($orientacionArray, $obj);

        }
        if ($excelente2 != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Excelente';
            $obj->cantidad = $excelente2;
            $obj->promedio = $promExcelente2;
            $obj->color = '#7e7cf1';
            array_push($orientacionArray, $obj);
        }
        if ($nada2 != 0) {
            $obj =  new stdClass();
            $obj->numero = 5;
            $obj->nombre = 'Nada';
            $obj->cantidad = $nada2;
            $obj->promedio = $promNada2;
            $obj->color = '#f5acf2';
            array_push($orientacionArray, $obj);
        }


        //REPORTE POR DESARROLLO EVENTO
       $pesimo3 = 0;
       $promPesimo3 = 0;
       $malo3 = 0;
       $promMalo3 = 0;
       $regular3 = 0;
       $promRegular3 = 0;
       $bueno3 = 0;
       $promBueno3 = 0;
       $excelente3 = 0; 
       $promExcelente3 = 0;
       $nada3 = 0;
       $promNada3 = 0;

        $pesimo3 = Encuesta::where('metodologiaEmpleada' , 1)->count();
        $promPesimo3 = ($pesimo3 * 100) /$cantEncuesta;
        $malo3 = Encuesta::where('metodologiaEmpleada' , 2)->count();
        $promMalo3 = ($malo3 * 100) /$cantEncuesta;
        $regular3 = Encuesta::where('metodologiaEmpleada' , 3)->count();
        $promRegular3 = ($regular3 * 100) / $cantEncuesta;
        $bueno3 = Encuesta::where('metodologiaEmpleada' , 4)->count();
        $promBueno3 = ($bueno3 * 100) / $cantEncuesta;
        $excelente3 = Encuesta::where('metodologiaEmpleada' , 5)->count();
        $promExcelente3 = ($excelente3 * 100) / $cantEncuesta;
        $nada3 = Encuesta::where('metodologiaEmpleada' , 6)->count();
         $promNada3 = ($nada3 * 100) / $cantEncuesta;
      
        if ($pesimo3 != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Pesimo';
            $obj->cantidad = $pesimo3;
            $obj->promedio = $promPesimo3;
            $obj->color = '#3c8dbc';
            array_push($metodologiaArray, $obj);
        }

        if ($malo3 != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Malo';
            $obj->cantidad = $malo3;
            $obj->promedio = $promMalo3;
            $obj->color = '#d0bf49';
            array_push($metodologiaArray, $obj);
        }
        if ($regular3 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Regular';
            $obj->cantidad = $regular3;
            $obj->promedio = $promRegular3;
            $obj->color = '#5ca1a8';
            array_push($metodologiaArray, $obj);
        }
        if ($bueno3 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Bueno';
            $obj->cantidad = $bueno3;
            $obj->promedio = $promBueno3;
            $obj->color = '#1a106f';
            array_push($metodologiaArray, $obj);

        }
        if ($excelente3 != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Excelente';
            $obj->cantidad = $excelente3;
            $obj->promedio = $promExcelente3;
            $obj->color = '#6f1033';
            array_push($metodologiaArray, $obj);
        }
        if ($nada3 != 0) {
            $obj =  new stdClass();
            $obj->numero = 5;
            $obj->nombre = 'Nada';
            $obj->cantidad = $nada3;
            $obj->promedio = $promNada3;
            $obj->color = '#106f6f';
            array_push($metodologiaArray, $obj);
        }
///////////////////////////////////////////////////////////////////
        //DESARROLLO EVENTO

       $pesimo4 = 0;
       $promPesimo4 = 0;
       $malo4 = 0;
       $promMalo4 = 0;
       $regular4 = 0;
       $promRegular4 = 0;
       $bueno4 = 0;
       $promBueno4 = 0;
       $excelente4 = 0; 
       $promExcelente4 = 0;
       $nada4 = 0;
       $promNada4 = 0;

        $pesimo4 = Encuesta::where('desarrolloEvento' , 1)->count();
        $promPesimo4 = ($pesimo4 * 100) /$cantEncuesta;
        $malo4 = Encuesta::where('desarrolloEvento' , 2)->count();
        $promMalo4 = ($malo4 * 100) /$cantEncuesta;
        $regular4 = Encuesta::where('desarrolloEvento' , 3)->count();
        $promRegular4 = ($regular4 * 100) / $cantEncuesta;
        $bueno4 = Encuesta::where('desarrolloEvento' , 4)->count();
        $promBueno4 = ($bueno4 * 100) / $cantEncuesta;
        $excelente4 = Encuesta::where('desarrolloEvento' , 5)->count();
        $promExcelente4 = ($excelente4 * 100) / $cantEncuesta;
        $nada4 = Encuesta::where('desarrolloEvento' , 6)->count();
         $promNada4 = ($nada4 * 100) / $cantEncuesta;
      
        if ($pesimo4 != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Pesimo';
            $obj->cantidad = $pesimo4;
            $obj->promedio = $promPesimo4;
            $obj->color = '#39cccc';
            array_push($desarrolloArray, $obj);
        }

        if ($malo4 != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Malo';
            $obj->cantidad = $malo4;
            $obj->promedio = $promMalo4;
            $obj->color = '#8e5ca8';
            array_push($desarrolloArray, $obj);
        }
        if ($regular4 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Regular';
            $obj->cantidad = $regular4;
            $obj->promedio = $promRegular4;
            $obj->color = '#dd4b39';
            array_push($desarrolloArray, $obj);
        }
        if ($bueno4 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Bueno';
            $obj->cantidad = $bueno4;
            $obj->promedio = $promBueno4;
            $obj->color = '#777';
            array_push($desarrolloArray, $obj);

        }
        if ($excelente4 != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Excelente';
            $obj->cantidad = $excelente4;
            $obj->promedio = $promExcelente4;
            $obj->color = '#ec788ed9';
            array_push($desarrolloArray, $obj);
        }
        if ($nada4 != 0) {
            $obj =  new stdClass();
            $obj->numero = 5;
            $obj->nombre = 'Nada';
            $obj->cantidad = $nada4;
            $obj->promedio = $promNada4;
            $obj->color = '#d2d6de';
            array_push($desarrolloArray, $obj);
        }
//////////////////////////////////////////////////////////////////
        //DISTRIBUCION ESPACIO
       $pesimo5 = 0;
       $promPesimo5 = 0;
       $malo5 = 0;
       $promMalo5 = 0;
       $regular5 = 0;
       $promRegular5 = 0;
       $bueno5 = 0;
       $promBueno5 = 0;
       $excelente5 = 0; 
       $promExcelente5 = 0;
       $nada5 = 0;
       $promNada5 = 0;

        $pesimo5 = Encuesta::where('distribucionEspacio' , 1)->count();
        $promPesimo5 = ($pesimo5 * 100) /$cantEncuesta;
        $malo5 = Encuesta::where('distribucionEspacio' , 2)->count();
        $promMalo5 = ($malo5 * 100) /$cantEncuesta;
        $regular5 = Encuesta::where('distribucionEspacio' , 3)->count();
        $promRegular5 = ($regular5 * 100) / $cantEncuesta;
        $bueno5 = Encuesta::where('distribucionEspacio' , 4)->count();
        $promBueno5 = ($bueno5 * 100) / $cantEncuesta;
        $excelente5 = Encuesta::where('distribucionEspacio' , 5)->count();
        $promExcelente5 = ($excelente5 * 100) / $cantEncuesta;
        $nada5 = Encuesta::where('distribucionEspacio' , 6)->count();
         $promNada5 = ($nada5 * 100) / $cantEncuesta;
      
        if ($pesimo5 != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Pesimo';
            $obj->cantidad = $pesimo5;
            $obj->promedio = $promPesimo5;
            $obj->color = '#3c8dbc';
            array_push($distribucionArray, $obj);
        }

        if ($malo5 != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Malo';
            $obj->cantidad = $malo5;
            $obj->promedio = $promMalo5;
            $obj->color = '#7b3d3d';
            array_push($distribucionArray, $obj);
        }
        if ($regular5 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Regular';
            $obj->cantidad = $regular5;
            $obj->promedio = $promRegular5;
            $obj->color = '#3e2256';
            array_push($distribucionArray, $obj);
        }
        if ($bueno5 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Bueno';
            $obj->cantidad = $bueno5;
            $obj->promedio = $promBueno5;
            $obj->color = '#f9264d';
            array_push($distribucionArray, $obj);

        }
        if ($excelente5 != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Excelente';
            $obj->cantidad = $excelente5;
            $obj->promedio = $promExcelente5;
            $obj->color = '#f926f3';
            array_push($distribucionArray, $obj);
        }
        if ($nada5 != 0) {
            $obj =  new stdClass();
            $obj->numero = 5;
            $obj->nombre = 'Nada';
            $obj->cantidad = $nada5;
            $obj->promedio = $promNada5;
            $obj->color = '#dd4b39';
            array_push($distribucionArray, $obj);
        }
    //////////////////////////////////////////////////////////////////
        //LOGISTICA
       $pesimo6 = 0;
       $promPesimo6 = 0;
       $malo6 = 0;
       $promMalo6 = 0;
       $regular6 = 0;
       $promRegular6 = 0;
       $bueno6 = 0;
       $promBueno6 = 0;
       $excelente6 = 0; 
       $promExcelente6 = 0;
       $nada6 = 0;
       $promNada6 = 0;

        $pesimo6 = Encuesta::where('logisticaEvento' , 1)->count();
        $promPesimo6 = ($pesimo6 * 100) /$cantEncuesta;
        $malo6 = Encuesta::where('logisticaEvento' , 2)->count();
        $promMalo6 = ($malo6 * 100) /$cantEncuesta;
        $regular6 = Encuesta::where('logisticaEvento' , 3)->count();
        $promRegular6 = ($regular6 * 100) / $cantEncuesta;
        $bueno6 = Encuesta::where('logisticaEvento' , 4)->count();
        $promBueno6 = ($bueno6 * 100) / $cantEncuesta;
        $excelente6 = Encuesta::where('logisticaEvento' , 5)->count();
        $promExcelente6 = ($excelente6 * 100) / $cantEncuesta;
        $nada6 = Encuesta::where('logisticaEvento' , 6)->count();
        $promNada6 = ($nada6 * 100) / $cantEncuesta;
      
        if ($pesimo6 != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Pesimo';
            $obj->cantidad = $pesimo6;
            $obj->promedio = $promPesimo6;
            $obj->color = '#25e5ef';
            array_push($logisticaArray, $obj);
        }

        if ($malo6 != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Malo';
            $obj->cantidad = $malo6;
            $obj->promedio = $promMalo6;
            $obj->color = '#bd25ef';
            array_push($logisticaArray, $obj);
        }
        if ($regular6 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Regular';
            $obj->cantidad = $regular6;
            $obj->promedio = $promRegular6;
            $obj->color = '#2ce84c';
            array_push($logisticaArray, $obj);
        }
        if ($bueno6 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Bueno';
            $obj->cantidad = $bueno6;
            $obj->promedio = $promBueno6;
            $obj->color = '#f5f06b';
            array_push($logisticaArray, $obj);

        }
        if ($excelente6 != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Excelente';
            $obj->cantidad = $excelente6;
            $obj->promedio = $promExcelente6;
            $obj->color = '#d46e6e';
            array_push($logisticaArray, $obj);
        }
        if ($nada6 != 0) {
            $obj =  new stdClass();
            $obj->numero = 5;
            $obj->nombre = 'Nada';
            $obj->cantidad = $nada6;
            $obj->promedio = $promNada6;
            $obj->color = '#ea2a33';
            array_push($logisticaArray , $obj);
        }

//////////////////////////////////////////////////////////////////
        //GENERAL
       $pesimo7 = 0;
       $promPesimo7 = 0;
       $malo7 = 0;
       $promMalo7 = 0;
       $regular7 = 0;
       $promRegular7 = 0;
       $bueno7 = 0;
       $promBueno7 = 0;
       $excelente7 = 0; 
       $promExcelente7 = 0;
       $nada7 = 0;
       $promNada7 = 0;

        $pesimo7 = Encuesta::where('general' , 1)->count();
        $promPesimo7 = ($pesimo7 * 100) /$cantEncuesta;
        $malo7 = Encuesta::where('general' , 2)->count();
        $promMalo7 = ($malo7 * 100) /$cantEncuesta;
        $regular7 = Encuesta::where('general' , 3)->count();
        $promRegular7 = ($regular7 * 100) / $cantEncuesta;
        $bueno7 = Encuesta::where('general' , 4)->count();
        $promBueno7 = ($bueno7 * 100) / $cantEncuesta;
        $excelente7 = Encuesta::where('general' , 5)->count();
        $promExcelente7 = ($excelente7 * 100) / $cantEncuesta;
        $nada7 = Encuesta::where('general' , 6)->count();
        $promNada7 = ($nada7 * 100) / $cantEncuesta;
      
        if ($pesimo7 != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Pesimo';
            $obj->cantidad = $pesimo7;
            $obj->promedio = $promPesimo7;
            $obj->color = '#3c8dbc';
            array_push($generalArray, $obj);
        }

        if ($malo7 != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Malo';
            $obj->cantidad = $malo7;
            $obj->promedio = $promMalo7;
            $obj->color = '#d2d6de';
            array_push($generalArray, $obj);
        }
        if ($regular7 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Regular';
            $obj->cantidad = $regular7;
            $obj->promedio = $promRegular7;
            $obj->color = '#6f2655';
            array_push($generalArray, $obj);
        }
        if ($bueno7 != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Bueno';
            $obj->cantidad = $bueno7;
            $obj->promedio = $promBueno7;
            $obj->color = '#26254a';
            array_push($generalArray, $obj);

        }
        if ($excelente7 != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'Excelente';
            $obj->cantidad = $excelente7;
            $obj->promedio = $promExcelente7;
            $obj->color = '#dd4b39';
            array_push($generalArray, $obj);
        }
        if ($nada7 != 0) {
            $obj =  new stdClass();
            $obj->numero = 5;
            $obj->nombre = 'Nada';
            $obj->cantidad = $nada7;
            $obj->promedio = $promNada7;
            $obj->color = '#111111';
            array_push($generalArray, $obj);
        }
  ////////////////////////////////////////////////////////////////
        //MEDIOS
        $radio = Encuesta::where('medio' , 0)->count();
        $radioProm = ($radio * 100) /$cantEncuesta;
        $television = Encuesta::where('medio' , 1)->count();
        $televisionProm = ($television * 100) /$cantEncuesta;
        $correo = Encuesta::where('medio' , 2)->count();
        $correoProm = ($correo * 100) / $cantEncuesta;
        $prensa = Encuesta::where('medio' , 3)->count();
        $prensaProm = ($prensa * 100) / $cantEncuesta;
        $pagina = Encuesta::where('medio' , 4)->count();
        $paginaProm = ($pagina * 100) / $cantEncuesta;
        
        if ($radio != 0) {
            $obj =  new stdClass();
            $obj->numero = 0;
            $obj->nombre = 'Radio';
            $obj->cantidad = $radio;
            $obj->promedio = $radioProm;
            $obj->color = '#ff851b';
            array_push($reporteMedios , $obj);
        }
        if ($television != 0) {
            $obj =  new stdClass();
            $obj->numero = 1;
            $obj->nombre = 'Television';
            $obj->cantidad = $television;
            $obj->promedio = $televisionProm;
            $obj->color = '#3533c1';
            array_push($reporteMedios , $obj);
        }
        if ($correo != 0) {
            $obj =  new stdClass();
            $obj->numero = 2;
            $obj->nombre = 'Correo';
            $obj->cantidad = $correo;
            $obj->promedio = $correoProm;
            $obj->color = '#001f3f';
            array_push($reporteMedios , $obj);
        }
        if ($prensa != 0) {
            $obj =  new stdClass();
            $obj->numero = 3;
            $obj->nombre = 'Prensa';
            $obj->cantidad = $prensa;
            $obj->promedio = $prensaProm;
            $obj->color = '#ea2a33';
            array_push($reporteMedios , $obj);
        }
        if ($pagina != 0) {
            $obj =  new stdClass();
            $obj->numero = 4;
            $obj->nombre = 'pagina';
            $obj->cantidad = $pagina;
            $obj->promedio = $paginaProm;
            $obj->color = '#39cccc';
            array_push($reporteMedios , $obj);
        }



        ///////////////////////////////////////////////////////////////////
        //  NUEVO EVENTO        
        $no = Encuesta::where('nuevoEvento' , 0)->count();
        $noProm = ($no * 100) / $cantEncuesta;
        $si = Encuesta::where('nuevoEvento' , 1)->count();
        $siProm = ($si * 100) / $cantEncuesta;

        $reporteSiNo = new stdClass();
        $reporteSiNo->no = $no;
        $reporteSiNo->noProm = $noProm;
        $reporteSiNo->si = $si;
        $reporteSiNo->siProm = $siProm;

        return response()->json(['error'=>false, 'calificacionActividad' => $calificacionActividad , 'orientacionArray' => $orientacionArray , 'metodologiaArray' => $metodologiaArray , 'desarrolloArray' => $desarrolloArray , 'distribucionArray' => $distribucionArray , 'logisticaArray' => $logisticaArray , 'generalArray' => $generalArray , 'reporteMedios' => $reporteMedios , 'reporteSiNo' => $reporteSiNo , 'tipoArray' => $tipoArray]);
        
        
  }       
        
    public function reporteEncuesta2(Request $request){
      
        $reporteTipo = array(); //Este reporte guarda las cantidades de personas que han respondido la encuesta
        $total = 0;
        $pregunta = Pregunta::where('idEvento' , $request->idEvento)->get();//Busco las preguntas de un evento determinado
        $obj =  new stdClass();
        $obj->tipoEmpresa = 0;
        $obj->tipoAgrupacion = 0;
        $obj->tipoParticipante = 0;
        $obj->tipoPublico = 0;
        if (count($pregunta) != 0) {
           foreach ($pregunta as $p) {

                $encuesta = Encuesta2::where('idPregunta' , $p->idPregunta)->get();
                $total += Encuesta2::where('idPregunta' , $p->idPregunta)->count();
               
                foreach ($encuesta as $e) {
                 // dd($e);
                    $usuario = User::find($e->idUsuario);
               
                    if ($usuario->tipo == 1) {
                        $obj->tipoEmpresa +=1;
                    }elseif ($usuario->tipo == 2) {
                        $obj->tipoAgrupacion +=1;
                    }elseif ($usuario->tipo == 3) {
                        $obj->tipoParticipante +=1;
                    }elseif ($usuario->tipo == 4) { 
                        $obj->tipoPublico +=1;
                    } 
                 }  
               
                if ($p->tipo == 1) {
              
                  $pesimo = Encuesta2::where('idPregunta' , $p->idPregunta)->where('respuesta' , 1)->count();
                  $malo = Encuesta2::where('idPregunta' , $p->idPregunta)->where('respuesta' , 2)->count();
                  $regular = Encuesta2::where('idPregunta' , $p->idPregunta)->where('respuesta' , 3)->count();
                  $bueno = Encuesta2::where('idPregunta' , $p->idPregunta)->where('respuesta' , 4)->count();
                  $excelente = Encuesta2::where('idPregunta' , $p->idPregunta)->where('respuesta' , 5)->count();
                  $nada = Encuesta2::where('idPregunta' , $p->idPregunta)->where('respuesta' , 6)->count();
              //    $p->total += Encuesta2::where('idPregunta' , $p->idPregunta)->count();
                  $p->pesimo = $pesimo;
                  $p->malo = $malo;
                  $p->regular = $regular;
                  $p->bueno = $bueno;
                  $p->excelente = $excelente;
                  $p->nada = $nada;
                }else{
                  $si = Encuesta2::where('idPregunta' , $p->idPregunta)->where('respuesta' , 7)->count();
                  $no = Encuesta2::where('idPregunta' , $p->idPregunta)->where('respuesta' , 8)->count();

                  $p->si = $si;
                  $p->no = $no;
                }
           }
          if(!isset($reporteTipo[0])){
            array_push($reporteTipo, $obj);
          }
          $reporteTipo[0]->total = $total;
        }
        return response()->json(['error'=>false, 'pregunta' => $pregunta , 'reporteTipo' => $reporteTipo]); 
    }
  
    
    public function create(Request $request){
        $preguntas = json_decode($request->preguntas);
        foreach ($preguntas as $p) {
          $encuesta = new Encuesta2();
          $encuesta->idPregunta = $p->idPregunta;
          $encuesta->idUsuario = $p->idUsuario;
          $encuesta->respuesta = $p->respuesta;
          $encuesta->save();
        }
       /* $encuesta = new Encuesta();
        $encuesta->tipo = $request->idTipo;
        $encuesta->calificacionActividad  = $respuesta[0]->respuesta;
        $encuesta->orientacion  = $respuesta[1]->respuesta;
        $encuesta->metodologiaEmpleada  = $respuesta[2]->respuesta;
        $encuesta->desarrolloEvento = $respuesta[3]->respuesta;
        $encuesta->distribucionEspacio = $respuesta[4]->respuesta;
        $encuesta->logisticaEvento = $respuesta[5]->respuesta;
        $encuesta->general = $respuesta[6]->respuesta;
        $encuesta->medio  = $respuesta[7]->respuesta;
        $encuesta->nuevoEvento = $respuesta[8]->respuesta;
        $encuesta->comentario = $respuesta[8]->comentario;
        $encuesta->save();*/
        
        return response()->json(['error'=>false, 'encuesta' => $encuesta]);
    }



}
