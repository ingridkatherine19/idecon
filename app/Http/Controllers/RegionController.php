<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Region;
use DB;

class RegionController extends Controller {

    public function all(Request $request){
        $regiones = Region::all();
        return response()->json(['error'=>false,'regiones' => $regiones]);
    }



}
