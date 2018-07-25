<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Empresa;
use App\Modelos\Agrupacion;
use App\Modelos\Participante;
use Auth;
use DB;

class RegistroAppController extends Controller {

    public function empresa(Request $request) {
      //  dd($request);
        $ciudad = json_decode($request->ciudad);
        $empresa = Empresa::where('nit' , $request->nit)->get();
          if (isset($empresa[0])) {
              return response()->json(['error'=>false,'empresa' => $empresa, 'mensaje' => 'Ya se encuentra una empresa guardada con ese nit' ]);
          }else{
            $empresa = new Empresa();
            $empresa->nombre = $request->nombre;
            $empresa->nit = $request->nit;
            $empresa->sector = $request->sector;
            $empresa->gerente = $request->gerente;
            $empresa->departamento = $request->departamento;
            $empresa->ciudad = $ciudad->idCiudad;
            $empresa->direccion = $request->direccion;
            $empresa->telefono1 = $request->telefono1;
            $empresa->correo = $request->email;
            $empresa->lat = $request->lat;
            $empresa->lng = $request->lng;
            $empresa->save();

              return response()->json(['error'=>false,'empresa' => $empresa, 'mensaje' => 'La empresa fue registrada exitosamente' ]);
          }
        
    }
    public function agrupacion(Request $request) {
      
        $ciudad = json_decode($request->ciudad);
        $region = json_decode($request->region);

        $agrupacion = new Agrupacion();
        $agrupacion->nombre = $request->nombre;
        $agrupacion->representante = $request->representante;
        $agrupacion->nit = $request->nit;
        $agrupacion->departamento = $request->departamento;
        $agrupacion->ciudad = $ciudad->idCiudad;
        $agrupacion->direccion = $request->direccion;
        $agrupacion->telefono = $request->telefono;
        $agrupacion->correo = $request->email;
        $agrupacion->genero = $request->genero;
        $agrupacion->lat = $request->lat;
        $agrupacion->lng = $request->lng;
        $agrupacion->save();

        return response()->json(['error'=>false,'agrupacion' => $agrupacion, 'mensaje' => 'La agrupacion fue registrada con éxito' ]);
    }

    public function participante(Request $request) {
   
        $ciudad = json_decode($request->ciudad);
        $participante = new Participante();
        $participante->tipo = $request->tipo;
        $participante->nombre = $request->nombre;
        $participante->cedula = $request->cedula;
        $participante->edad = $request->edad;
        $participante->fechaNac = $request->fechaNac;
        $participante->sexo = $request->sexo;
        $participante->departamento = $request->departamento;
        $participante->ciudad = $ciudad->idCiudad;
        $participante->direccion = $request->direccion;
        $participante->telefono = $request->telefono;
        $participante->correo = $request->correo;
        $participante->save();

        return response()->json(['error'=>false,'participante' => $participante, 'mensaje' => 'El participante fue registrado con éxito' ]);
    }

        public function usuarioExistente(Request $request) {
        $user = user::where('correo' , $request->correo)->get();
          if (isset($user[0])) {
              return response()->json(['error'=>false,'user' => $user, 'mensaje' => 'El usuario no puede ser almacenado porque ya existe en nuestra base de datos' ]);
          }else{
            $usuario = new user();
            $usuario->nombre = $request->nombre;
            $usuario->apellido = $request->apellido;
            $usuario->cedula = $request->cedula;
            $usuario->tipo = $request->tipo;
            $usuario->correo= $request->correo;
            $usuario->password  = bcrypt($request->contrasena);
            
            $usuario->save();
            return response()->json(['error'=>false,'usuario' => $usuario, 'mensaje' => 'El usuario ha sido creado con exito' ]);
          }
        
    }

}
