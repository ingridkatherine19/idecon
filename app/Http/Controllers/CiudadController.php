<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Ciudad;
use DB;

class CiudadController extends Controller {

    public function all(Request $request){
        $ciudades = Ciudad::where('idDepartamento', $request->idDepartamento)->get();
        return response()->json(['error'=>false,'ciudades' => $ciudades]);
    }



}
