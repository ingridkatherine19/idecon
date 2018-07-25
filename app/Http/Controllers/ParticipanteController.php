<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Participante;
use DB;
use stdClass;

class ParticipanteController extends Controller {

    public function all(Request $request){
        $participante = Participante::all();
        return response()->json(['error'=>false,'participante' => $participante]);
    }

    public function allDepartamento(Request $request){
        $participante = Participante::where('departamento' , $request->idDepartamento)->get();
        return response()->json(['error'=>false,'participante' => $participante]);
    }
    
    public function Tipo(Request $request){
        $participante = Participante::where('tipo' , $request->tipo)->get();
        return response()->json(['error'=>false,'participante' => $participante]);
    }

    public function Create(Request $request) {
   
        $participante = new Participante();
        $participante->tipo = $request->tipo;
        $participante->nombre = $request->nombre;
        $participante->cedula = $request->cedula;
        $participante->edad = $request->edad;
        $participante->fechaNac = $request->fechaNac;
        $participante->sexo = $request->sexo;
        $participante->departamento = $request->departamento;
        $participante->ciudad = $request->ciudad;
        $participante->direccion = $request->direccion;
        $participante->telefono = $request->telefono;
        $participante->telefono2 = $request->telefono2;
        $participante->correo = $request->correo;
        $participante->habilidad = $request->habilidad;
        $participante->profesion = $request->profesion;
        $participante->nivelAcademico = $request->nivel;
        $participante->estadoCivil = $request->estadoC;
        $participante->facebook = $request->facebook;
        $participante->twitter = $request->twitter;
        $participante->instagram = $request->instagram;
        $participante->youtube = $request->youtube;
        $participante->save();

        return response()->json(['error'=>false,'participante' => $participante, 'mensaje' => 'El participante fue registrado con éxito' ]);
    }

    public function Update(Request $request) {

        $participante = Participante::find($request->idParticipante);
        $participante->tipo = $request->tipo;
        $participante->nombre = $request->nombre;
        $participante->cedula = $request->cedula;
        $participante->edad = $request->edad;
        $participante->fechaNac = $request->fechaNac;
        $participante->sexo = $request->sexo;
        $participante->departamento = $request->departamento;
        $participante->ciudad = $request->ciudad;
        $participante->direccion = $request->direccion;
        $participante->telefono = $request->telefono;
        $participante->telefono2 = $request->telefono2;
        $participante->correo = $request->correo;
        $participante->habilidad = $request->habilidad;
        $participante->profesion = $request->profesion;
        $participante->nivelAcademico = $request->nivel;
        $participante->estadoCivil = $request->estadoC;
        $participante->facebook = $request->facebook;
        $participante->twitter = $request->twitter;
        $participante->instagram = $request->instagram;
        $participante->youtube = $request->youtube;
        $participante->save();

        $participante->save();
        return response()->json(['error'=>false,'participante' => $participante , 'mensaje' =>'El participante fue actualizado con éxito']);
    }

    public function Delete(Request $request){
        $participante = Participante::find($request->idParticipante);
        $participante->delete();
        return response()->json(['error'=>false,'participante' => $participante , 'mensaje' => 'El participante ha sido eliminad con exito']); 


    }

    public function reporteParticipante(Request $request){
       
        /*NIVEL ACADEMICO
             0: Educacion Media; 1: Técnico; 2: Técnico Profesional; 3: Tecnologo; 4: Profesional; 5: Especializacion; 6: Maestría; 7: Doctorado; 8: ninguno 

        */
        $participantes = Participante::all();
        $cantParticipante = Participante::count();
        $promEdad = 0;
        $totalEdad = 0;
        $promNivel = 0;
        $cantJuridico = 0;
        $cantNatural = 0;
        $cantMujeres = 0;
        $cantHombres = 0;
        $promMujeres = 0;
        $promHombres = 0;
        $nivelA = array();
        $reporte = new stdClass();
   
        foreach ($participantes as $participante) {
            $totalEdad += $participante->edad;
            $cantJuridico = Participante::where('tipo' , 1)->count();
            $cantNatural = Participante::where('tipo' , 0)->count();
            $cantMujeres = Participante::where('sexo' , 0)->count();
            $cantHombres = Participante::where('sexo' , 1)->count();
            //CALCULO DE CANTIDAD Y PROMEDIO DE NIVEL ACEDEMICO

            $eduMedia =  Participante::where('nivelAcademico' , 0)->count();
            $promEduMedia = ($eduMedia * 100) / $cantParticipante;
            $tecnico =  Participante::where('nivelAcademico' , 1)->count();
            $promTecnico = ($tecnico * 100) / $cantParticipante;
            $tecnicoPro =  Participante::where('nivelAcademico' , 2)->count();
            $promTecnicoPro = ($tecnicoPro * 100) /$cantParticipante;
            $tecnologo = Participante::where('nivelAcademico' , 3)->count();
            $promTecnologo = ($tecnologo * 100 ) /$cantParticipante;
            $profesional = Participante::where('nivelAcademico' , 4)->count();
            $promProfesional = ($profesional * 100) / $cantParticipante;
            $especializacion = Participante::where('nivelAcademico' , 5)->count();
            $promEspecializacion = ($especializacion * 100)/ $cantParticipante;
            $maestria = Participante::where('nivelAcademico' , 6)->count();
            $promMaestria = ($maestria * 100)/$cantParticipante;
            $doctorado = Participante::where('nivelAcademico' , 7)->count();
            $promDoctorado = ($doctorado * 100)/ $cantParticipante;
            $ninguno = Participante::where('nivelAcademico' , 8)->count();
            $promNinguno = ($ninguno * 100)/ $cantParticipante;
        }

        //ASIGNA LA CANTIDAD DE NIVELES ACADEMICOS A JSON 
        if ($eduMedia != 0) {
            $nivelAcademico =  new stdClass();
            $nivelAcademico->numero = 0;
            $nivelAcademico->nombre = 'Educación Media';
            $nivelAcademico->cantidad = $eduMedia;
            $nivelAcademico->promedio = $promEduMedia;
            $nivelAcademico->color = '#3c8dbc';
            array_push($nivelA, $nivelAcademico);
        }

        if ($tecnico != 0) {
            $nivelAcademico =  new stdClass();
            $nivelAcademico->numero = 1;
            $nivelAcademico->nombre = 'Técnico';
            $nivelAcademico->cantidad = $tecnico;
            $nivelAcademico->promedio = $promTecnico;
            $nivelAcademico->color = '#00c0ef';
            array_push($nivelA, $nivelAcademico);
        }
        if ($tecnicoPro != 0) {
            $nivelAcademico =  new stdClass();
            $nivelAcademico->numero = 2;
            $nivelAcademico->nombre = 'Técnico Profesional';
            $nivelAcademico->cantidad = $tecnicoPro;
            $nivelAcademico->promedio = $promTecnicoPro;
            $nivelAcademico->color = '#00a65a'; 
            array_push($nivelA, $nivelAcademico);
        }
        if ($tecnologo != 0) {
            $nivelAcademico =  new stdClass();
            $nivelAcademico->numero = 3;
            $nivelAcademico->nombre = 'Tecnólogo';
            $nivelAcademico->cantidad = $tecnologo;
            $nivelAcademico->promedio = $promTecnologo;
            $nivelAcademico->color = '#f39c12'; 
            array_push($nivelA, $nivelAcademico);
        }
        if ($profesional) {
           $nivelAcademico =  new stdClass();
           $nivelAcademico->numero = 4;
           $nivelAcademico->nombre = 'Profesional';
           $nivelAcademico->cantidad = $profesional;
           $nivelAcademico->promedio = $promProfesional;
           $nivelAcademico->color = '#ff851b';
           array_push($nivelA, $nivelAcademico);
        }
        if ($especializacion != 0) {
            $nivelAcademico =  new stdClass();
            $nivelAcademico->numero = 5;
            $nivelAcademico->nombre = 'Especialización';
            $nivelAcademico->cantidad = $especializacion;
            $nivelAcademico->promedio= $promEspecializacion;
            $nivelAcademico->color = '#001F3F';
            array_push($nivelA, $nivelAcademico);
        }
        if ($maestria != 0) {
            $nivelAcademico =  new stdClass();
            $nivelAcademico->numero = 6;
            $nivelAcademico->nombre = 'Maestría';
            $nivelAcademico->cantidad = $maestria;
            $nivelAcademico->promedio = $promMaestria;
            $nivelAcademico->color = '#605ca8';
            array_push($nivelA, $nivelAcademico);
        }

        if ($doctorado != 0) {
            $nivelAcademico =  new stdClass();
            $nivelAcademico->numero = 7;
            $nivelAcademico->nombre = ' Doctorado';
            $nivelAcademico->cantidad = $doctorado;
            $nivelAcademico->promedio = $promDoctorado;
            $nivelAcademico->color = '#D81B60';
            array_push($nivelA, $nivelAcademico);
        }
        if ($ninguno != 0) {
            $nivelAcademico =  new stdClass();
            $nivelAcademico->numero = 8;
            $nivelAcademico->nombre = ' Ninguno';
            $nivelAcademico->cantidad = $ninguno; 
            $nivelAcademico->promedio = $promNinguno;
            $nivelAcademico->color = '#d2d6de';
            array_push($nivelA, $nivelAcademico);
        }

       // SACA MEDIA DE EDAD , Promedio de hombres, promedio de mujeres
        $promEdad = $totalEdad/$cantParticipante;
        $promMujeres = ($cantMujeres*100)/$cantParticipante;
        $promHombres = ($cantHombres *100)/$cantParticipante;
        $reporte->totalEdad = $totalEdad;
        $reporte->cantJuridico = $cantJuridico;
        $reporte->cantNatural = $cantNatural;
        $reporte->cantMujeres = $cantMujeres;
        $reporte->cantHombres = $cantHombres;
        $reporte->promEdad = $promEdad;
        $reporte->promMujeres = $promMujeres;
        $reporte->promHombres = $promHombres;

        return response()->json(['error'=>false,'reporte' => $reporte , 'nivelAcademico' => $nivelA]); 

    }

}
