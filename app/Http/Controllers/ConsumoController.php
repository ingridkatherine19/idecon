<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modelos\Consumopalco;
use App\Modelos\Consumocalle;
use App\Modelos\Consumoorganico;
use App\Modelos\Valormaterial;
use App\Modelos\Beneficio;
use App\Modelos\Evento;
use stdClass;
use DB;

class ConsumoController extends Controller {

    public function all(Request $request){
        $consumopalco = Consumopalco::where('idEvento', $request->idEvento)->get();
        $consumocalle = Consumocalle::where('idEvento', $request->idEvento)->get();
        $consumoorganico = Consumoorganico::where('idEvento', $request->idEvento)->get();

        //los productos reciclados
        $reciclado = array();

        $aluminio = new stdClass();
        $aluminio->material = 'Aluminio';
        $aluminio->editar = false;
        $aluminio->cantidad = 0;
        $valor = Valormaterial::where('material', 0)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $aluminio->valor = $valor[0]->costo;
        }else{
            $aluminio->valor = 10;
        }

        $vidrio = new stdClass();
        $vidrio->material = 'Vidrio';
        $vidrio->editar = false;
        $vidrio->cantidad = 0;
        $valor = Valormaterial::where('material', 1)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $vidrio->valor = $valor[0]->costo;
        }else{
            $vidrio->valor = 10;
        }
        
        $plastico = new stdClass();
        $plastico->material = 'Plásticos PET';
        $plastico->editar = false;
        $plastico->cantidad = 0;
        $valor = Valormaterial::where('material', 2)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $plastico->valor = $valor[0]->costo;
        }else{
            $plastico->valor = 10;
        }
        
        $carton = new stdClass();
        $carton->editar = false;
        $carton->material = 'Cartón';
        $carton->cantidad = 0;
        $valor = Valormaterial::where('material', 3)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $carton->valor = $valor[0]->costo;
        }else{
            $carton->valor = 10;
        }
        
        $organico = new stdClass();
        $organico->material = 'Orgánico';
        $organico->editar = false;
        $organico->cantidad = 0;
        $organico->kg = 0;
        $valor = Valormaterial::where('material', 4)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $organico->valor = $valor[0]->costo;
        }else{
            $organico->valor = 10;
        }

        
        
        //calcular totale de costo, venta y margen d contribucion

        //CALLE
        foreach ($consumopalco as $consumo) {
        	if ($consumo->producto == 0) {
        		$consumo->productoN = 'Licor';
                $vidrio->cantidad += $consumo->consumo;
        	}
        	if ($consumo->producto == 1) {
        		$consumo->productoN = 'Agua';
                $plastico->cantidad += $consumo->consumo;
        	}
        	if ($consumo->producto == 2) {
        		$consumo->productoN = 'Cerveza de Lata';
                $aluminio->cantidad += $consumo->consumo;
        	}
            if ($consumo->producto == 3) {
                $consumo->productoN = 'Cerveza de Botella';
                $vidrio->cantidad += $consumo->consumo;
            }
        	if ($consumo->producto == 4) {
        		$consumo->productoN = 'Energéticos de Lata';
                $aluminio->cantidad += $consumo->consumo;
        	}
            if ($consumo->producto == 5) {
                $consumo->productoN = 'Energéticos de Plastico';
                $plastico->cantidad += $consumo->consumo;
            }
            if ($consumo->producto == 6) {
                $consumo->productoN = 'Refrescos';
                $plastico->cantidad += $consumo->consumo;
            }
        	if ($consumo->producto == 7) {
        		$consumo->productoN = 'Snacks';
        	}
            if ($consumo->producto == 8) {
                $consumo->productoN = 'Almuerzos';
            }
            if ($consumo->producto == 9) {
                $consumo->productoN = 'Desayunos';
            }
            if ($consumo->producto == 10) {
                $consumo->productoN = 'Comidas';
            }
        	$consumo->totalCosto = $consumo->consumo * $consumo->costo;
        	$consumo->totalVenta = $consumo->consumo * $consumo->venta;
        	$consumo->mc = (1 - ($consumo->totalCosto / $consumo->totalVenta))*100;
        }

        //CALLE
        foreach ($consumocalle as $consumo) {
        	if ($consumo->producto == 0) {
                $consumo->productoN = 'Licor';
                $vidrio->cantidad += $consumo->consumo;
            }
            if ($consumo->producto == 1) {
                $consumo->productoN = 'Agua';
                $plastico->cantidad += $consumo->consumo;
            }
            if ($consumo->producto == 2) {
                $consumo->productoN = 'Cerveza de Lata';
                $aluminio->cantidad += $consumo->consumo;
            }
            if ($consumo->producto == 3) {
                $consumo->productoN = 'Cerveza de Botella';
                $vidrio->cantidad += $consumo->consumo;
            }
            if ($consumo->producto == 4) {
                $consumo->productoN = 'Energéticos de Lata';
                $aluminio->cantidad += $consumo->consumo;
            }
            if ($consumo->producto == 5) {
                $consumo->productoN = 'Energéticos de Plastico';
                $plastico->cantidad += $consumo->consumo;
            }
            if ($consumo->producto == 6) {
                $consumo->productoN = 'Refrescos';
                $plastico->cantidad += $consumo->consumo;
            }
            if ($consumo->producto == 7) {
                $consumo->productoN = 'Snacks';
            }
            if ($consumo->producto == 8) {
                $consumo->productoN = 'Almuerzos';
            }
            if ($consumo->producto == 9) {
                $consumo->productoN = 'Desayunos';
            }
            if ($consumo->producto == 10) {
                $consumo->productoN = 'Comidas';
            }
        	$consumo->totalCosto = $consumo->consumo * $consumo->costo;
        	$consumo->totalVenta = $consumo->consumo * $consumo->venta;
        	$consumo->mc = ($consumo->totalCosto /$consumo->totalVenta)*100;
        }

        //ORGANICO
        foreach ($consumoorganico as $consumo) {
            if ($consumo->producto == 0) {
                $consumo->productoN = 'Pan';

                $total = 0;
                //el consumo total es el consumo de los desayunos de la calle y de los palcos por la cantidad de consumo
                $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                if (count($desayunoPalco) != 0) {
                    $total += $desayunoPalco[0]->consumo;
                }
                if (count($desayunoCalle) != 0) {
                    $total += $desayunoCalle[0]->consumo;
                }

                $consumo->consumoTotal = $consumo->consumo * $total;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS
                $cant =   ($total * $consumo->consumo)/ $consumo->cantidad;
                $organico->cantidad += $cant;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = ($consumo->consumoTotal / $consumo->cantidad)*0.05;
                
                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 1) {
                $consumo->productoN = 'Huevos';

                $total = 0;
                //el consumo total es el consumo de los desayunos de la calle y de los palcos por la cantidad de consumo
                $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                if (count($desayunoPalco) != 0) {
                    $total += $desayunoPalco[0]->consumo;
                }
                if (count($desayunoCalle) != 0) {
                    $total += $desayunoCalle[0]->consumo;
                }

                $consumo->consumoTotal = $consumo->consumo * $total;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS
                $cant =   ($total * $consumo->consumo)/ $consumo->cantidad;
                $organico->cantidad += $cant;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = ($consumo->consumoTotal / $consumo->cantidad)*0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;

            }
            if ($consumo->producto == 2) {
                $consumo->productoN = 'Leche';

                $total = 0;
                //el consumo total es el consumo de los desayunos de la calle y de los palcos por la cantidad de consumo
                $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                if (count($desayunoPalco) != 0) {
                    $total += $desayunoPalco[0]->consumo;
                }
                if (count($desayunoCalle) != 0) {
                    $total += $desayunoCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 3) {
                $consumo->productoN = 'Arroz';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 4) {
                $consumo->productoN = 'Carne';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 5) {
                $consumo->productoN = 'Pollo';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 6) {
                $consumo->productoN = 'Cerdo';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 7) {
                $consumo->productoN = 'Pescado';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;
                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 8) {
                $consumo->productoN = 'Vegetales';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 9) {
                $consumo->productoN = 'Frutas';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }
                if (count($desayunoPalco) != 0) {
                    $total += $desayunoPalco[0]->consumo;
                }
                if (count($desayunoCalle) != 0) {
                    $total += $desayunoCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 10) {
                $consumo->productoN = 'Otros Granos';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 11) {
                $consumo->productoN = 'Maíz';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                
                
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }
                if (count($desayunoPalco) != 0) {
                    $total += $desayunoPalco[0]->consumo;
                }
                if (count($desayunoCalle) != 0) {
                    $total += $desayunoCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 12) {
                $consumo->productoN = 'Azúcar';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }
                if (count($desayunoPalco) != 0) {
                    $total += $desayunoPalco[0]->consumo;
                }
                if (count($desayunoCalle) != 0) {
                    $total += $desayunoCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 13) {
                $consumo->productoN = 'Aceite';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }
                if (count($desayunoPalco) != 0) {
                    $total += $desayunoPalco[0]->consumo;
                }
                if (count($desayunoCalle) != 0) {
                    $total += $desayunoCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            if ($consumo->producto == 14) {
                $consumo->productoN = 'Sal';

                $total = 0;
                //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
                $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
                $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $request->idEvento)->get();
                //verificar que tengan algo para poder sumar
                
                if (count($almuerzoPalco) != 0) {
                    $total += $almuerzoPalco[0]->consumo;
                }
                if (count($almuerzoCalle) != 0) {
                    $total += $almuerzoCalle[0]->consumo;
                }
                if (count($comidaPalco) != 0) {
                    $total += $comidaPalco[0]->consumo;
                }
                if (count($comidaCalle) != 0) {
                    $total += $comidaCalle[0]->consumo;
                }
                if (count($desayunoPalco) != 0) {
                    $total += $desayunoPalco[0]->consumo;
                }
                if (count($desayunoCalle) != 0) {
                    $total += $desayunoCalle[0]->consumo;
                }

                $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                $organico->cantidad += $consumo->consumoTotal;

                $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                $consumo->desperdicio = $consumo->consumoTotal *0.05;

                //SE SUMAN LOS KG DE DESPERDICIOS
                $organico->kg += $consumo->desperdicio;
            }
            
        }

        $selectPalco = array();
        $selectCalle = array();
        $selectOrganico = array();
        //buscar cuales no estan

        //PALCO
        $c = Consumopalco::where('producto', 0)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
        	$select = new stdClass();
        	$select->idTipo = 0;
        	$select->nombre = 'Licor';
        	array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 1)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
        	$select = new stdClass();
        	$select->idTipo = 1;
        	$select->nombre = 'Agua';
        	array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 2)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
        	$select = new stdClass();
        	$select->idTipo = 2;
        	$select->nombre = 'Cerveza de Lata';
        	array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 3)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 3;
            $select->nombre = 'Cerveza de Botella';
            array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 4)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
        	$select = new stdClass();
        	$select->idTipo = 4;
        	$select->nombre = 'Energéticos de Lata';
        	array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 5)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 5;
            $select->nombre = 'Energéticos de Plastico';
            array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 6)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 6;
            $select->nombre = 'Refrescos';
            array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 7)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
        	$select = new stdClass();
        	$select->idTipo = 7;
        	$select->nombre = 'Snacks';
        	array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 8)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 8;
            $select->nombre = 'Almuerzos';
            array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 9)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 9;
            $select->nombre = 'Desayunos';
            array_push($selectPalco, $select);
        }
        $c = Consumopalco::where('producto', 10)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 10;
            $select->nombre = 'Comidas';
            array_push($selectPalco, $select);
        }

        //CALLE
        $c = Consumocalle::where('producto', 0)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 0;
            $select->nombre = 'Licor';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 1)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 1;
            $select->nombre = 'Agua';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 2)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 2;
            $select->nombre = 'Cerveza de Lata';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 3)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 3;
            $select->nombre = 'Cerveza de Botella';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 4)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 4;
            $select->nombre = 'Energéticos de Lata';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 5)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 5;
            $select->nombre = 'Energéticos de Plastico';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 6)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 6;
            $select->nombre = 'Refrescos';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 7)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 7;
            $select->nombre = 'Snacks';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 8)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 8;
            $select->nombre = 'Almuerzos';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 9)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 9;
            $select->nombre = 'Desayunos';
            array_push($selectCalle, $select);
        }
        $c = Consumocalle::where('producto', 10)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 10;
            $select->nombre = 'Comidas';
            array_push($selectCalle, $select);
        }

        //ORGANICO
        $c = Consumoorganico::where('producto', 0)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 0;
            $select->nombre = 'Pan';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 1)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 1;
            $select->nombre = 'Huevos';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 2)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 2;
            $select->nombre = 'Leche';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 3)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 3;
            $select->nombre = 'Arroz';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 4)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 4;
            $select->nombre = 'Carne';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 5)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 5;
            $select->nombre = 'Pollo';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 6)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 6;
            $select->nombre = 'Cerdo';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 7)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 7;
            $select->nombre = 'Pescado';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 8)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 8;
            $select->nombre = 'Vegetales';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 9)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 9;
            $select->nombre = 'Frutas';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 10)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 10;
            $select->nombre = 'Otros Granos';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 11)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 11;
            $select->nombre = 'Maíz';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 12)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 12;
            $select->nombre = 'Azúcar';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 13)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 13;
            $select->nombre = 'Aceite';
            array_push($selectOrganico, $select);
        }
        $c = Consumoorganico::where('producto', 14)->where('idEvento', $request->idEvento)->get();
        if (count($c) == 0) {
            $select = new stdClass();
            $select->idTipo = 14;
            $select->nombre = 'Sal';
            array_push($selectOrganico, $select);
        }


        //despues de haber sumado todos los valores se agregan a la variable, se meten en el arreglo
        
        //ALUMINIO CALCULO
        $aluminio->kg = (15.00 * $aluminio->cantidad)/1000;
        $aluminio->tonelada = $aluminio->kg/1000;
        $aluminio->total = $aluminio->kg * $aluminio->valor;
        array_push($reciclado, $aluminio);
        //VIDRIO
        $vidrio->kg = (450.00 * $vidrio->cantidad)/1000;
        $vidrio->tonelada = $vidrio->kg/1000;
        $vidrio->total = $vidrio->kg * $vidrio->valor;
        array_push($reciclado, $vidrio);
        //PLASTICO
        $plastico->kg = ( (30.00*$plastico->cantidad)+($plastico->cantidad*2.00)+(($plastico->cantidad/24)*50.00)+(($aluminio->cantidad/4)*3.75)+(($aluminio->cantidad/24)*27.50))/1000;
        $plastico->tonelada = $plastico->kg/1000;
        $plastico->total = $plastico->kg * $plastico->valor;
        array_push($reciclado, $plastico);
        //CARTON
        $carton->cantidad = ($aluminio->cantidad + $plastico->cantidad)/24;
        
        $carton->kg = ((350.00*($plastico->cantidad/24))/1000)+((350.00*($aluminio->cantidad/24))/1000)+((1.30*$plastico->cantidad)/1000);

        $carton->tonelada = $carton->kg/1000;
        $carton->total = $carton->kg * $carton->valor;
        array_push($reciclado, $carton);
        //ORGANICO
        $organico->tonelada = $organico->kg/1000;
        $organico->total = $organico->kg * $organico->valor;
        array_push($reciclado, $organico);


        //calculo del impacto ambiental
        $impacto = new stdClass();
        
        //ARBOLES
        $impacto->reduccionArboles = 0;
        $impacto->editarArboles = false;
        $impacto->reduccionArboles += ($carton->kg/1000)*17;
        $valor = Beneficio::where('tipoImpacto', 0)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoArboles = $valor[0]->costo;
        }else{
            $impacto->costoArboles = 10;
        }
        
        //buscar en la base de datos si tiene algun costo
        $impacto->totalArboles = $impacto->reduccionArboles * $impacto->costoArboles;
        
        //COMPOSTAJE    
        $impacto->reduccionCompo = 0;
        $impacto->editarCompo = false;
        $impacto->reduccionCompo += ($organico->kg/100)*30;
        $valor = Beneficio::where('tipoImpacto', 1)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoCompo = $valor[0]->costo;
        }else{
            $impacto->costoCompo = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalCompo = $impacto->reduccionCompo * $impacto->costoCompo;
        
        //Desechos orgánicos
        $impacto->reduccionDese = 0;
        $impacto->editarDese = false;
        $impacto->reduccionDese += $organico->kg;
        $valor = Beneficio::where('tipoImpacto', 2)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoDese = $valor[0]->costo;
        }else{
            $impacto->costoDese = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalDese = $impacto->reduccionDese * $impacto->costoDese;
        
        //Kg de materias primas.
        $impacto->reduccionPrima = 0;
        $impacto->editarPrima = false;
        $impacto->reduccionPrima += ($vidrio->kg/1000)*1200;
        $valor = Beneficio::where('tipoImpacto', 3)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoPrima = $valor[0]->costo;
        }else{
            $impacto->costoPrima = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalPrima = $impacto->reduccionPrima * $impacto->costoPrima;    

        //Kg menos de basura al vertedero   
        $impacto->reduccionVerte = 0;
        $impacto->editarVerte = false;
        $impacto->reduccionVerte += $aluminio->kg + $vidrio->kg + $plastico->kg + $carton->kg + $organico->kg;
        $valor = Beneficio::where('tipoImpacto', 4)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoVerte = $valor[0]->costo;
        }else{
            $impacto->costoVerte = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalVerte = $impacto->reduccionVerte * $impacto->costoVerte;   

        //Kwh de electricidad ahorrados 
        $impacto->reduccionKwh = 0;
        $impacto->editarKwh = false;
        $impacto->reduccionKwh += ($aluminio->kg/1000)*14630;
        $impacto->reduccionKwh += ((($vidrio->kg/1000)*130)/1000)*11600;
        $impacto->reduccionKwh += ($plastico->kg/1000)*5774;
        $impacto->reduccionKwh += ($carton->kg/1000)*4000;
        $valor = Beneficio::where('tipoImpacto', 5)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoKwh = $valor[0]->costo;
        }else{
            $impacto->costoKwh = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalKwh = $impacto->reduccionKwh * $impacto->costoKwh;

        //Litros de Agua    
        $impacto->reduccionAgua = 0;
        $impacto->editarAgua = false;
        $impacto->reduccionAgua += $plastico->kg*39.26;
        $impacto->reduccionAgua += ($carton->kg/1000)*50000;
        $valor = Beneficio::where('tipoImpacto', 6)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoAgua = $valor[0]->costo;
        }else{
            $impacto->costoAgua = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalAgua = $impacto->reduccionAgua * $impacto->costoAgua;

        //Litros de petróleo    
        $impacto->reduccionPetro = 0;
        $impacto->editarPetro = false;
        $aux = ($aluminio->kg/1000)*14630;
        $impacto->reduccionPetro += (($aux /11600)*7.3)*159;
        $impacto->reduccionPetro += ($vidrio->kg/1000)*136;
        $impacto->reduccionPetro += (($plastico->kg/1000)*16.3)*159;
        $impacto->reduccionPetro += ($carton->kg/1000)*140;
        $valor = Beneficio::where('tipoImpacto', 7)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoPetro = $valor[0]->costo;
        }else{
            $impacto->costoPetro = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalPetro = $impacto->reduccionPetro * $impacto->costoPetro;

        //Gas Natural M3 
        $impacto->reduccionNatural= 0;
        $impacto->editarNatural = false;
        $aux = ($organico->kg/1000)*500;
        $impacto->reduccionNatural += $aux*0.6;
        $valor = Beneficio::where('tipoImpacto', 8)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoNatural = $valor[0]->costo;
        }else{
            $impacto->costoNatural = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalNatural = $impacto->reduccionNatural * $impacto->costoNatural;

        //Bio Gas M3 
        $impacto->reduccionGas= 0;
        $impacto->editarGas = false;
        $impacto->reduccionGas += ($organico->kg/1000)*500;
        $valor = Beneficio::where('tipoImpacto', 9)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoGas = $valor[0]->costo;
        }else{
            $impacto->costoGas = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalGas = $impacto->reduccionGas * $impacto->costoGas;   

        //Litros de Bio etanol o bio disel  
        $impacto->reduccionBio= 0;
        $impacto->editarBio = false;
        $impacto->reduccionBio += $organico->kg/10;
        $valor = Beneficio::where('tipoImpacto', 10)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoBio = $valor[0]->costo;
        }else{
            $impacto->costoBio = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalBio = $impacto->reduccionBio * $impacto->costoBio;

        //Toneladas de CO2
        $impacto->reduccionCo2= 0;
        $impacto->editarCo2 = false;
        $impacto->reduccionCo2 += (($aluminio->cantidad/1000)*113.8)/1000;
        $impacto->reduccionCo2 += ((($vidrio->kg*2560))/1000)/1000;
        $impacto->reduccionCo2 += ($plastico->kg/1000)*1.5;
        $impacto->reduccionCo2 += (($carton->kg/1000)*900)/1000;
        $impacto->reduccionCo2 += (($organico->kg/1000)*250);
        $valor = Beneficio::where('tipoImpacto', 11)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoCo2 = $valor[0]->costo;
        }else{
            $impacto->costoCo2 = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalCo2 = $impacto->reduccionCo2 * $impacto->costoCo2;


        //Toneladas de bauxita  
        $impacto->reduccionBauxita= 0;
        $impacto->editarBauxita = false;
        $impacto->reduccionBauxita += (($aluminio->kg/1000)*4);
        $valor = Beneficio::where('tipoImpacto', 12)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoBauxita = $valor[0]->costo;
        }else{
            $impacto->costoBauxita = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalBauxita = $impacto->reduccionBauxita * $impacto->costoBauxita;

        //Mineral de hierro
        $impacto->reduccionHierro= 0;
        $impacto->editarHierro = false;
        $impacto->reduccionHierro += (($aluminio->kg/1000)*1.5);
        $valor = Beneficio::where('tipoImpacto', 13)->where('idEvento', $request->idEvento)->get();
        if (count($valor) != 0) {
            $impacto->costoHierro = $valor[0]->costo;
        }else{
            $impacto->costoHierro = 10;
        }
        //buscar en la base de datos si tiene algun costo
        $impacto->totalHierro = $impacto->reduccionHierro * $impacto->costoHierro;

        
        //reporte de cada matrial por la reduccion 
        $reporteAluminio = new stdClass();
        $reporteAluminio->basura = $aluminio->kg;
        $reporteAluminio->kwh = ($aluminio->kg/1000)*14630;
        $reporteAluminio->agua =($aluminio->kg/1000)*91200;
        $reporteAluminio->petroleo = (($reporteAluminio->kwh/11600)*7.3)*159; 
        $reporteAluminio->co2 =(($aluminio->cantidad/1000)*113.8)/1000;
        $reporteAluminio->bauxita = (($aluminio->kg/1000)*4);
        $reporteAluminio->hierro =(($aluminio->kg/1000)*1.5);

        $reporteVidrio = new stdClass();
        $reporteVidrio->prima = ($vidrio->kg/1000)*1200;
        $reporteVidrio->basura = $vidrio->kg;
        $reporteVidrio->kwh = ((($vidrio->kg/1000)*130)/1000)*11600;
        $reporteVidrio->petroleo = (($vidrio->kg/1000)*136);
        $reporteVidrio->co2 = ((($vidrio->kg*2560))/1000)/1000;

        $reportePlastico = new stdClass();
        $reportePlastico->basura = $plastico->kg;
        $reportePlastico->kwh = ($plastico->kg/1000)*5774;
        $reportePlastico->agua = $plastico->kg*39.26;
        $reportePlastico->petroleo = (($plastico->kg/1000)*16.3)*159;
        $reportePlastico->co2 = ($plastico->kg/1000)*1.5;

        $reporteCarton = new stdClass();
        $reporteCarton->arbol = ($carton->kg/1000)*17;
        $reporteCarton->basura = $carton->kg;
        $reporteCarton->kwh =($carton->kg/1000)*4000;
        $reporteCarton->agua = ($carton->kg/1000)*50000;
        $reporteCarton->petroleo =($carton->kg/1000)*140;
        $reporteCarton->co2 =(($carton->kg/1000)*900)/1000;

        $reporteOrganico = new stdClass();
        $reporteOrganico->compostaje = ($organico->kg/100)*30;
        $reporteOrganico->organico = $organico->kg;
        $reporteOrganico->basura = $organico->kg;
        $reporteOrganico->gas = ($organico->kg/1000)*500;
        $reporteOrganico->natural = $reporteOrganico->gas*0.6;
        $reporteOrganico->bio = $organico->kg/10;
        $reporteOrganico->co2 =(($organico->kg/1000)*250)/1000;


        return response()->json(['error'=>false,'consumopalco' => $consumopalco,'consumocalle' => $consumocalle,'consumoorganico' => $consumoorganico,'reciclado' => $reciclado,'impacto' => $impacto, 'selectPalco' => $selectPalco, 'selectCalle' => $selectCalle, 'selectOrganico' => $selectOrganico, 'reporteAluminio'=> $reporteAluminio, 'reporteVidrio' => $reporteVidrio, 'reportePlastico' => $reportePlastico, 'reporteCarton' => $reporteCarton, 'reporteOrganico' => $reporteOrganico ]);
    }

    public function createPalco(Request $request){
    	$consumo = new Consumopalco();
    	$consumo->idEvento = $request->idEvento;
    	$consumo->producto =  $request->producto;
    	$consumo->consumo = $request->consumo;
    	$consumo->costo = $request->costo;
    	$consumo->venta = $request->venta;
    	$consumo->save();
    	return response()->json(['error'=>false,'consumo' => $consumo]);
    }

    public function updatePalco(Request $request){
       
        $consumo = Consumopalco::find($request->idConsumo);
        $consumo->consumo = $request->consumo;
        $consumo->costo = $request->costo;
        $consumo->venta = $request->venta;
        $consumo->save();
        return response()->json(['error'=>false,'consumo' => $consumo]);
    }

    public function deletePalco(Request $request){
        $consumo = Consumopalco::find($request->idConsumo);
        $consumo->delete();
        return response()->json(['error'=>false,'consumo' => $consumo]);
    }
    

    public function createCalle(Request $request){
    	$consumo = new Consumocalle();
    	$consumo->idEvento = $request->idEvento;
    	$consumo->producto =  $request->producto;
    	$consumo->consumo = $request->consumo;
    	$consumo->costo = $request->costo;
    	$consumo->venta = $request->venta;
    	$consumo->save();
    	return response()->json(['error'=>false,'consumo' => $consumo]);
    }

    public function updateCalle(Request $request){
        $consumo = Consumocalle::find($request->idConsumo);
        $consumo->consumo = $request->consumo;
        $consumo->costo = $request->costo;
        $consumo->venta = $request->venta;
        $consumo->save();
        return response()->json(['error'=>false,'consumo' => $consumo]);
    }

    public function deleteCalle(Request $request){
        $consumo = Consumocalle::find($request->idConsumo);
        $consumo->delete();
        return response()->json(['error'=>false,'consumo' => $consumo]);
    }

    public function createOrganico(Request $request){
        $consumo = new Consumoorganico();
        $consumo->idEvento = $request->idEvento;
        $consumo->producto =  $request->producto;
        $consumo->consumo = $request->consumo;
        $consumo->cantidad = $request->cantidad;
        $consumo->costo = $request->costo;
        $consumo->save();
        return response()->json(['error'=>false,'consumo' => $consumo]);
    }

    public function updateOrganico(Request $request){
        $consumo = Consumoorganico::find($request->idConsumo);
        $consumo->consumo = $request->consumo;
        $consumo->cantidad = $request->cantidad;
        $consumo->costo = $request->costo;
        $consumo->save();
        return response()->json(['error'=>false,'consumo' => $consumo]);
    }
    public function actMaterial (Request $request){
        
        $buscar = Valormaterial::where('idEvento' , $request->idEvento )->where('material' , $request->material)->get();
      
        if (isset($buscar[0])) {
      
           $buscar[0]->costo = $request->costo;
           $buscar[0]->save();
           return response()->json(['error'=>false,'material' => $buscar]);
        }else{
         
            $nuevo = new Valormaterial();
            $nuevo->idEvento = $request->idEvento;
            $nuevo->costo = $request->costo;
            $nuevo->material = $request->material;
            $nuevo->save();
            return response()->json(['error'=>false,'material' => $nuevo]);
        }

    }

    public function actBeneficio (Request $request){
       
        $buscar = Beneficio::where('idEvento' , $request->idEvento )->where('tipoImpacto' , $request->tipoImpacto)->get();
      
        if (isset($buscar[0])) {
           $buscar[0]->costo = $request->costo;
           $buscar[0]->save();
           return response()->json(['error'=>false,'beneficio' => $buscar]);
        }else{
         
            $nuevo = new Beneficio();
            $nuevo->idEvento = $request->idEvento;
            $nuevo->costo = $request->costo;
            $nuevo->tipoImpacto = $request->tipoImpacto;
            $nuevo->save();
            return response()->json(['error'=>false,'beneficio' => $nuevo]);
        }

    }

    public function deleteOrganico(Request $request){
        $consumo = Consumoorganico::find($request->idConsumo);
        $consumo->delete();
        return response()->json(['error'=>false,'consumo' => $consumo]);
    }

    public function dashboard(Request $request){
        
        $eventos = Evento::all();


        //los productos reciclados
        $reciclado = array();
        $cant = 0;
        $aluminio = new stdClass();
        $aluminio->material = 'Aluminio';
        $aluminio->cantidad = 0;
        $aluminio->kg = 0;
        $aluminio->tonelada = 0;
        $aluminio->total = 0;

        $vidrio = new stdClass();
        $vidrio->material = 'Vidrio';
        $vidrio->cantidad = 0;
        $vidrio->kg = 0;
        $vidrio->tonelada = 0;
        $vidrio->total = 0;

        $plastico = new stdClass();
        $plastico->material = 'Plásticos PET';
        $plastico->cantidad = 0;
        $plastico->kg = 0;
        $plastico->tonelada = 0;
        $plastico->total = 0;

        $carton = new stdClass();
        $carton->material = 'Cartón';
        $carton->cantidad = 0;
        $carton->kg = 0;
        $carton->tonelada = 0;
        $carton->total = 0;

        $organico = new stdClass();
        $organico->material = 'Orgánico';
        $organico->cantidad = 0;
        $organico->kg = 0;
        $organico->tonelada = 0;
        $organico->total = 0;

        foreach ($eventos as $evento) {
            $aluminio->cantidad = 0;
            $vidrio->cantidad = 0;
            $plastico->cantidad = 0;
            $carton->cantidad = 0;
            $organico->cantidad = 0;


            $consumopalco = Consumopalco::where('idEvento', $evento->idEvento)->get();
            $consumocalle = Consumocalle::where('idEvento', $evento->idEvento)->get();
            $consumoorganico = Consumoorganico::where('idEvento', $evento->idEvento)->get();

            $valor = Valormaterial::where('material', 0)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $aluminio->valor = $valor[0]->costo;
            }else{
                $aluminio->valor = 10;
            }

            $valor = Valormaterial::where('material', 1)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $vidrio->valor = $valor[0]->costo;
            }else{
                $vidrio->valor = 10;
            }

            $valor = Valormaterial::where('material', 2)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $plastico->valor = $valor[0]->costo;
            }else{
                $plastico->valor = 10;
            }


            $valor = Valormaterial::where('material', 3)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $carton->valor = $valor[0]->costo;
            }else{
                $carton->valor = 10;
            }

            $valor = Valormaterial::where('material', 4)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $organico->valor = $valor[0]->costo;
            }else{
                $organico->valor = 10;
            }


            //dd($aluminio, $vidrio, $plastico, $carton, $organico, $evento);

            //PALCO
            foreach ($consumopalco as $consumo) {
                if ($consumo->producto == 0) {
                    $consumo->productoN = 'Licor';
                    $vidrio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 1) {
                    $consumo->productoN = 'Agua';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 2) {
                    $consumo->productoN = 'Cerveza de Lata';
                    $aluminio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 3) {
                    $consumo->productoN = 'Cerveza de Botella';
                    $vidrio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 4) {
                    $consumo->productoN = 'Energéticos de Lata';
                    $aluminio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 5) {
                    $consumo->productoN = 'Energéticos de Plastico';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 6) {
                    $consumo->productoN = 'Refrescos';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 7) {
                    $consumo->productoN = 'Snacks';
                }
                if ($consumo->producto == 8) {
                    $consumo->productoN = 'Almuerzos';
                }
                if ($consumo->producto == 9) {
                    $consumo->productoN = 'Desayunos';
                }
                if ($consumo->producto == 10) {
                    $consumo->productoN = 'Comidas';
                }
                $consumo->totalCosto = $consumo->consumo * $consumo->costo;
                $consumo->totalVenta = $consumo->consumo * $consumo->venta;
                $consumo->mc = (1 - ($consumo->totalCosto / $consumo->totalVenta))*100;
            }

            //CALLE
            foreach ($consumocalle as $consumo) {
                if ($consumo->producto == 0) {
                    $consumo->productoN = 'Licor';
                    $vidrio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 1) {
                    $consumo->productoN = 'Agua';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 2) {
                    $consumo->productoN = 'Cerveza de Lata';
                    $aluminio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 3) {
                    $consumo->productoN = 'Cerveza de Botella';
                    $vidrio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 4) {
                    $consumo->productoN = 'Energéticos de Lata';
                    $aluminio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 5) {
                    $consumo->productoN = 'Energéticos de Plastico';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 6) {
                    $consumo->productoN = 'Refrescos';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 7) {
                    $consumo->productoN = 'Snacks';
                }
                if ($consumo->producto == 8) {
                    $consumo->productoN = 'Almuerzos';
                }
                if ($consumo->producto == 9) {
                    $consumo->productoN = 'Desayunos';
                }
                if ($consumo->producto == 10) {
                    $consumo->productoN = 'Comidas';
                }
                $consumo->totalCosto = $consumo->consumo * $consumo->costo;
                $consumo->totalVenta = $consumo->consumo * $consumo->venta;
                $consumo->mc = ($consumo->totalCosto /$consumo->totalVenta)*100;
            }

            //ORGANICO
            foreach ($consumoorganico as $consumo) {
                if ($consumo->producto == 0) {
                    $consumo->productoN = 'Pan';

                    $total = 0;
                    //el consumo total es el consumo de los desayunos de la calle y de los palcos por la cantidad de consumo
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = $consumo->consumo * $total;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS
                    $cant =   ($total * $consumo->consumo)/ $consumo->cantidad;
                    $organico->cantidad += $cant;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = ($consumo->consumoTotal / $consumo->cantidad)*0.05;
                    
                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 1) {
                    $consumo->productoN = 'Huevos';

                    $total = 0;
                    //el consumo total es el consumo de los desayunos de la calle y de los palcos por la cantidad de consumo
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = $consumo->consumo * $total;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS
                    $cant =   ($total * $consumo->consumo)/ $consumo->cantidad;
                    $organico->cantidad += $cant;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = ($consumo->consumoTotal / $consumo->cantidad)*0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
 
                }
                if ($consumo->producto == 2) {
                    $consumo->productoN = 'Leche';

                    $total = 0;
                    //el consumo total es el consumo de los desayunos de la calle y de los palcos por la cantidad de consumo
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 3) {
                    $consumo->productoN = 'Arroz';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 4) {
                    $consumo->productoN = 'Carne';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 5) {
                    $consumo->productoN = 'Pollo';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 6) {
                    $consumo->productoN = 'Cerdo';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 7) {
                    $consumo->productoN = 'Pescado';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;
                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 8) {
                    $consumo->productoN = 'Vegetales';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 9) {
                    $consumo->productoN = 'Frutas';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 10) {
                    $consumo->productoN = 'Otros Granos';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 11) {
                    $consumo->productoN = 'Maíz';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 12) {
                    $consumo->productoN = 'Azúcar';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 13) {
                    $consumo->productoN = 'Aceite';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 14) {
                    $consumo->productoN = 'Sal';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                
            }

            //despues de haber sumado todos los valores se agregan a la variable, se meten en el arreglo
            if ($aluminio->cantidad != 0) {
                //ALUMINIO CALCULO
                $aluminio->kg += (15.00 * $aluminio->cantidad)/1000;
                $aluminio->tonelada += $aluminio->kg/1000;
                $aluminio->total += $aluminio->kg * $aluminio->valor;
                
            }
            
            if ($vidrio->cantidad != 0) {
                //VIDRIO
                $vidrio->kg += (450.00 * $vidrio->cantidad)/1000;
                $vidrio->tonelada += $vidrio->kg/1000;
                $vidrio->total += $vidrio->kg * $vidrio->valor;
                
            }
            

            if ($plastico->cantidad != 0) {
                //PLASTICO
                $plastico->kg += ( (30.00*$plastico->cantidad)+($plastico->cantidad*2.00)+(($plastico->cantidad/24)*50.00)+(($aluminio->cantidad/4)*3.75)+(($aluminio->cantidad/24)*27.50))/1000;
                $plastico->tonelada += $plastico->kg/1000; 
                $plastico->total += $plastico->kg * $plastico->valor;
                
            }
            
            if ($aluminio->cantidad != 0 || $plastico->cantidad != 0) {
                //CARTON
                $carton->cantidad = ($aluminio->cantidad + $plastico->cantidad)/24;
                
                $carton->kg += ((350.00*($plastico->cantidad/24))/1000)+((350.00*($aluminio->cantidad/24))/1000)+((1.30*$plastico->cantidad)/1000);

                $carton->tonelada += $carton->kg/1000;
                $carton->total += $carton->kg * $carton->valor;
                
            }
            
            if ($organico->cantidad != 0) {
                //ORGANICO
                $organico->tonelada += $organico->kg/1000;
                $organico->total += $organico->kg * $organico->valor;
                
            }
            //dd($aluminio, $vidrio, $plastico, $carton, $organico);
            $cant += $aluminio->cantidad;
        }
        $aluminio->cantidad = $cant;
        array_push($reciclado, $aluminio);
        array_push($reciclado, $vidrio);
        array_push($reciclado, $plastico);
        array_push($reciclado, $carton);
        array_push($reciclado, $organico);

        //calculo del impacto ambiental
        $impacto = new stdClass();
        
        //ARBOLES
        $impacto->reduccionArboles = ($carton->kg/1000)*17;
        
       

        //Kwh de electricidad ahorrados 
        $impacto->reduccionKwh = 0;
        $impacto->reduccionKwh += ($aluminio->kg/1000)*14630;
        $impacto->reduccionKwh += ((($vidrio->kg/1000)*130)/1000)*11600;
        $impacto->reduccionKwh += ($plastico->kg/1000)*5774;
        $impacto->reduccionKwh += ($carton->kg/1000)*4000;
        
        //Litros de Agua    
        $impacto->reduccionAgua = 0;
        $impacto->reduccionAgua += $plastico->kg*39.26;
        $impacto->reduccionAgua += ($carton->kg/1000)*50000;
        
        //Litros de petróleo    
        $impacto->reduccionPetro = 0;
        $aux = ($aluminio->kg/1000)*14630;
        $impacto->reduccionPetro += (($aux /11600)*7.3)*159;
        $impacto->reduccionPetro += ($vidrio->kg/1000)*136;
        $impacto->reduccionPetro += (($plastico->kg/1000)*16.3)*159;
        $impacto->reduccionPetro += ($carton->kg/1000)*140;
        

        //Gas Natural M3 
        $aux = ($organico->kg/1000)*500;
        $impacto->reduccionNatural = $aux*0.6;

        //Bio Gas M3 
        $impacto->reduccionGas = ($organico->kg/1000)*500;
        
        //Litros de Bio etanol o bio disel  
        $impacto->reduccionBio = $organico->kg/10;
        
        //Toneladas de CO2
        $impacto->reduccionCo2= 0;
        $impacto->reduccionCo2 += (($aluminio->cantidad/1000)*113.8)/1000;
        $impacto->reduccionCo2 += ((($vidrio->kg*2560))/1000)/1000;
        $impacto->reduccionCo2 += ($plastico->kg/1000)*1.5;
        $impacto->reduccionCo2 += (($carton->kg/1000)*900)/1000;
        $impacto->reduccionCo2 += (($organico->kg/1000)*250)/1000;
        
        
        return response()->json(['error'=>false, 'reciclado' => $reciclado, 'impacto' => $impacto]);
    }

        public function dashboardDepartamento(Request $request){
        
        
        $eventos = Evento::where('idDepartamento' , $request->idDepartamento)->get();

        //los productos reciclados
        $reciclado = array();
        $cant = 0;
        $aluminio = new stdClass();
        $aluminio->material = 'Aluminio';
        $aluminio->cantidad = 0;
        $aluminio->kg = 0;
        $aluminio->tonelada = 0;
        $aluminio->total = 0;

        $vidrio = new stdClass();
        $vidrio->material = 'Vidrio';
        $vidrio->cantidad = 0;
        $vidrio->kg = 0;
        $vidrio->tonelada = 0;
        $vidrio->total = 0;

        $plastico = new stdClass();
        $plastico->material = 'Plásticos PET';
        $plastico->cantidad = 0;
        $plastico->kg = 0;
        $plastico->tonelada = 0;
        $plastico->total = 0;

        $carton = new stdClass();
        $carton->material = 'Cartón';
        $carton->cantidad = 0;
        $carton->kg = 0;
        $carton->tonelada = 0;
        $carton->total = 0;

        $organico = new stdClass();
        $organico->material = 'Orgánico';
        $organico->cantidad = 0;
        $organico->kg = 0;
        $organico->tonelada = 0;
        $organico->total = 0;

        foreach ($eventos as $evento) {
            $aluminio->cantidad = 0;
            $vidrio->cantidad = 0;
            $plastico->cantidad = 0;
            $carton->cantidad = 0;
            $organico->cantidad = 0;


            $consumopalco = Consumopalco::where('idEvento', $evento->idEvento)->get();
            $consumocalle = Consumocalle::where('idEvento', $evento->idEvento)->get();
            $consumoorganico = Consumoorganico::where('idEvento', $evento->idEvento)->get();

            $valor = Valormaterial::where('material', 0)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $aluminio->valor = $valor[0]->costo;
            }else{
                $aluminio->valor = 10;
            }

            $valor = Valormaterial::where('material', 1)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $vidrio->valor = $valor[0]->costo;
            }else{
                $vidrio->valor = 10;
            }

            $valor = Valormaterial::where('material', 2)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $plastico->valor = $valor[0]->costo;
            }else{
                $plastico->valor = 10;
            }


            $valor = Valormaterial::where('material', 3)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $carton->valor = $valor[0]->costo;
            }else{
                $carton->valor = 10;
            }

            $valor = Valormaterial::where('material', 4)->where('idEvento', $evento->idEvento)->get();
            if (count($valor) != 0) {
                $organico->valor = $valor[0]->costo;
            }else{
                $organico->valor = 10;
            }


            //dd($aluminio, $vidrio, $plastico, $carton, $organico, $evento);

            //PALCO
            foreach ($consumopalco as $consumo) {
                if ($consumo->producto == 0) {
                    $consumo->productoN = 'Licor';
                    $vidrio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 1) {
                    $consumo->productoN = 'Agua';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 2) {
                    $consumo->productoN = 'Cerveza de Lata';
                    $aluminio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 3) {
                    $consumo->productoN = 'Cerveza de Botella';
                    $vidrio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 4) {
                    $consumo->productoN = 'Energéticos de Lata';
                    $aluminio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 5) {
                    $consumo->productoN = 'Energéticos de Plastico';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 6) {
                    $consumo->productoN = 'Refrescos';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 7) {
                    $consumo->productoN = 'Snacks';
                }
                if ($consumo->producto == 8) {
                    $consumo->productoN = 'Almuerzos';
                }
                if ($consumo->producto == 9) {
                    $consumo->productoN = 'Desayunos';
                }
                if ($consumo->producto == 10) {
                    $consumo->productoN = 'Comidas';
                }
                $consumo->totalCosto = $consumo->consumo * $consumo->costo;
                $consumo->totalVenta = $consumo->consumo * $consumo->venta;
                $consumo->mc = (1 - ($consumo->totalCosto / $consumo->totalVenta))*100;
            }

            //CALLE
            foreach ($consumocalle as $consumo) {
                if ($consumo->producto == 0) {
                    $consumo->productoN = 'Licor';
                    $vidrio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 1) {
                    $consumo->productoN = 'Agua';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 2) {
                    $consumo->productoN = 'Cerveza de Lata';
                    $aluminio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 3) {
                    $consumo->productoN = 'Cerveza de Botella';
                    $vidrio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 4) {
                    $consumo->productoN = 'Energéticos de Lata';
                    $aluminio->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 5) {
                    $consumo->productoN = 'Energéticos de Plastico';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 6) {
                    $consumo->productoN = 'Refrescos';
                    $plastico->cantidad += $consumo->consumo;
                }
                if ($consumo->producto == 7) {
                    $consumo->productoN = 'Snacks';
                }
                if ($consumo->producto == 8) {
                    $consumo->productoN = 'Almuerzos';
                }
                if ($consumo->producto == 9) {
                    $consumo->productoN = 'Desayunos';
                }
                if ($consumo->producto == 10) {
                    $consumo->productoN = 'Comidas';
                }
                $consumo->totalCosto = $consumo->consumo * $consumo->costo;
                $consumo->totalVenta = $consumo->consumo * $consumo->venta;
                $consumo->mc = ($consumo->totalCosto /$consumo->totalVenta)*100;
            }

            //ORGANICO
            foreach ($consumoorganico as $consumo) {
                if ($consumo->producto == 0) {
                    $consumo->productoN = 'Pan';

                    $total = 0;
                    //el consumo total es el consumo de los desayunos de la calle y de los palcos por la cantidad de consumo
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = $consumo->consumo * $total;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS
                    $cant =   ($total * $consumo->consumo)/ $consumo->cantidad;
                    $organico->cantidad += $cant;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = ($consumo->consumoTotal / $consumo->cantidad)*0.05;
                    
                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 1) {
                    $consumo->productoN = 'Huevos';

                    $total = 0;
                    //el consumo total es el consumo de los desayunos de la calle y de los palcos por la cantidad de consumo
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = $consumo->consumo * $total;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS
                    $cant =   ($total * $consumo->consumo)/ $consumo->cantidad;
                    $organico->cantidad += $cant;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = ($consumo->consumoTotal / $consumo->cantidad)*0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;

                }
                if ($consumo->producto == 2) {
                    $consumo->productoN = 'Leche';

                    $total = 0;
                    //el consumo total es el consumo de los desayunos de la calle y de los palcos por la cantidad de consumo
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 3) {
                    $consumo->productoN = 'Arroz';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 4) {
                    $consumo->productoN = 'Carne';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 5) {
                    $consumo->productoN = 'Pollo';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 6) {
                    $consumo->productoN = 'Cerdo';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 7) {
                    $consumo->productoN = 'Pescado';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;
                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 8) {
                    $consumo->productoN = 'Vegetales';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 9) {
                    $consumo->productoN = 'Frutas';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 10) {
                    $consumo->productoN = 'Otros Granos';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 11) {
                    $consumo->productoN = 'Maíz';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 12) {
                    $consumo->productoN = 'Azúcar';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 13) {
                    $consumo->productoN = 'Aceite';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                if ($consumo->producto == 14) {
                    $consumo->productoN = 'Sal';

                    $total = 0;
                    //el consumo total es el consumo de los almuerzos y comidas de la calle y de los palcos por la cantidad de consumo
                    $almuerzoPalco = Consumopalco::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $almuerzoCalle = Consumocalle::where('producto', 8)->where('idEvento', $evento->idEvento)->get();
                    $comidaPalco = Consumopalco::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $comidaCalle = Consumocalle::where('producto', 10)->where('idEvento', $evento->idEvento)->get();
                    $desayunoPalco = Consumopalco::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    $desayunoCalle = Consumocalle::where('producto', 9)->where('idEvento', $evento->idEvento)->get();
                    //verificar que tengan algo para poder sumar
                    
                    if (count($almuerzoPalco) != 0) {
                        $total += $almuerzoPalco[0]->consumo;
                    }
                    if (count($almuerzoCalle) != 0) {
                        $total += $almuerzoCalle[0]->consumo;
                    }
                    if (count($comidaPalco) != 0) {
                        $total += $comidaPalco[0]->consumo;
                    }
                    if (count($comidaCalle) != 0) {
                        $total += $comidaCalle[0]->consumo;
                    }
                    if (count($desayunoPalco) != 0) {
                        $total += $desayunoPalco[0]->consumo;
                    }
                    if (count($desayunoCalle) != 0) {
                        $total += $desayunoCalle[0]->consumo;
                    }

                    $consumo->consumoTotal = ($consumo->consumo * $total)/ $consumo->cantidad;
                    //SE SUMA EL CONSUMO A LOS TOTALES ORGANICOS 
                    $organico->cantidad += $consumo->consumoTotal;

                    $consumo->totalCosto = $consumo->consumoTotal * $consumo->costo;
                    $consumo->desperdicio = $consumo->consumoTotal *0.05;

                    //SE SUMAN LOS KG DE DESPERDICIOS
                    $organico->kg += $consumo->desperdicio;
                }
                
            }

            //despues de haber sumado todos los valores se agregan a la variable, se meten en el arreglo
            if ($aluminio->cantidad != 0) {
                //ALUMINIO CALCULO
                $aluminio->kg += (15.00 * $aluminio->cantidad)/1000;
                $aluminio->tonelada += $aluminio->kg/1000;
                $aluminio->total += $aluminio->kg * $aluminio->valor;
                
            }
            
            if ($vidrio->cantidad != 0) {
                //VIDRIO
                $vidrio->kg += (450.00 * $vidrio->cantidad)/1000;
                $vidrio->tonelada += $vidrio->kg/1000;
                $vidrio->total += $vidrio->kg * $vidrio->valor;
                
            }
            

            if ($plastico->cantidad != 0) {
                //PLASTICO
                $plastico->kg += ( (30.00*$plastico->cantidad)+($plastico->cantidad*2.00)+(($plastico->cantidad/24)*50.00)+(($aluminio->cantidad/4)*3.75)+(($aluminio->cantidad/24)*27.50))/1000;
                $plastico->tonelada += $plastico->kg/1000;
                $plastico->total += $plastico->kg * $plastico->valor;
                
            }
            
            if ($aluminio->cantidad != 0 || $plastico->cantidad != 0) {
                //CARTON
                $carton->cantidad = ($aluminio->cantidad + $plastico->cantidad)/24;
                
                $carton->kg += ((350.00*($plastico->cantidad/24))/1000)+((350.00*($aluminio->cantidad/24))/1000)+((1.30*$plastico->cantidad)/1000);

                $carton->tonelada += $carton->kg/1000;
                $carton->total += $carton->kg * $carton->valor;
                
            }
            
            if ($organico->cantidad != 0) {
                //ORGANICO
                $organico->tonelada += $organico->kg/1000;
                $organico->total += $organico->kg * $organico->valor;
                
            }
            //dd($aluminio, $vidrio, $plastico, $carton, $organico);
            $cant += $aluminio->cantidad;
        }
        $aluminio->cantidad = $cant;
        array_push($reciclado, $aluminio);
        array_push($reciclado, $vidrio);
        array_push($reciclado, $plastico);
        array_push($reciclado, $carton);
        array_push($reciclado, $organico);

        //calculo del impacto ambiental
        $impacto = new stdClass();
        
        //ARBOLES
        $impacto->reduccionArboles = ($carton->kg/1000)*17;
        
       

        //Kwh de electricidad ahorrados 
        $impacto->reduccionKwh = 0;
        $impacto->reduccionKwh += ($aluminio->kg/1000)*14630;
        $impacto->reduccionKwh += ((($vidrio->kg/1000)*130)/1000)*11600;
        $impacto->reduccionKwh += ($plastico->kg/1000)*5774;
        $impacto->reduccionKwh += ($carton->kg/1000)*4000;
        
        //Litros de Agua    
        $impacto->reduccionAgua = 0;
        $impacto->reduccionAgua += $plastico->kg*39.26;
        $impacto->reduccionAgua += ($carton->kg/1000)*50000;
        
        //Litros de petróleo    
        $impacto->reduccionPetro = 0;
        $aux = ($aluminio->kg/1000)*14630;
        $impacto->reduccionPetro += (($aux /11600)*7.3)*159;
        $impacto->reduccionPetro += ($vidrio->kg/1000)*136;
        $impacto->reduccionPetro += (($plastico->kg/1000)*16.3)*159;
        $impacto->reduccionPetro += ($carton->kg/1000)*140;
        

        //Gas Natural M3 
        $aux = ($organico->kg/1000)*500;
        $impacto->reduccionNatural = $aux*0.6;

        //Bio Gas M3 
        $impacto->reduccionGas = ($organico->kg/1000)*500;
        
        //Litros de Bio etanol o bio disel  
        $impacto->reduccionBio = $organico->kg/10;
        
        //Toneladas de CO2
        $impacto->reduccionCo2= 0;
        $impacto->reduccionCo2 += (($aluminio->cantidad/1000)*113.8)/1000;
        $impacto->reduccionCo2 += ((($vidrio->kg*2560))/1000)/1000;
        $impacto->reduccionCo2 += ($plastico->kg/1000)*1.5;
        $impacto->reduccionCo2 += (($carton->kg/1000)*900)/1000;
        $impacto->reduccionCo2 += (($organico->kg/1000)*250)/1000;
        
        
        return response()->json(['error'=>false, 'reciclado' => $reciclado, 'impacto' => $impacto]);
    }

}
