'use strict';
 
angular.module('myApp.Consumo', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/consumo', {
        templateUrl: 'pages/Consumo/consumo.html',
        controller: 'ConsumoCtrl'
    });
}])

// Home controller
.controller('ConsumoCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  if (!$rootScope.evento) {
    window.location.href = '#/evento';
  }
  console.log($rootScope.evento);
  $scope.ver = false;
  $scope.consumoCalle = [];
  $scope.consumoPalco = [];
  $scope.actualizarMat = false; //Para actualizar la tabla valoracionmaterial
  $scope.actualizarPalco = false;
  $scope.actualizarCalle = false;
  $scope.actualizarOrganico = false;
  $scope.actualizarBen = false;

  $scope.limpiarForm = function(){
    $scope.consumo = {};
    $scope.actualizarPalco = false;
    $scope.actualizarCalle = false;
    $scope.actualizarOrganico = false;

  }

  //-----------------------PALCO--------------


  //llenar la variable de lo que se va a actualizar
  $scope.actPalco = function(consumo){
    
    $scope.consumo = consumo;
    $scope.actualizarPalco = true;
  }

  $scope.editarConsumoPalco = function(consumo){
 
    $http({
        url: path + 'consumo/actpalco',
        method: 'get',
        params: consumo ,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //actualizar la pantalla
      $scope.all();
      //mensaje de agregado con exito
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
         
    });
  }

  //llena los datos de lo que se va a eliminar
  $scope.cargarEliminar = function(consumo, tipo){
    $scope.consumo = consumo;
    $scope.tipoEliminar = tipo;
  }

  $scope.eliminarConsumo = function(){
    if($scope.tipoEliminar == 1){//es un consumo palco
      $http({
          url: path + 'consumo/deletepalco',
          method: 'get',
          params: $scope.consumo,
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        //actualizar la pantalla
        $scope.all();
      });
    }else{
      if ($scope.tipoEliminar == 2) {//es un consumo calle
        $http({
            url: path + 'consumo/deletecalle',
            method: 'get',
            params: $scope.consumo,
            headers: {
                "Content-Type": "application/json"
            }
        }).success(function (response) {
          //actualizar la pantalla
          $scope.all();
        });

        }else{//es consumo organico
          $http({
              url: path + 'consumo/deleteorganico',
              method: 'get',
              params: $scope.consumo,
              headers: {
                  "Content-Type": "application/json"
              }
          }).success(function (response) {
            //actualizar la pantalla
            $scope.all();
          });
        }
      
    }
  }
    
  $scope.guardarConsumoPalco = function(consumo){
    consumo.idEvento = $rootScope.evento.idEvento;
    $http({
        url: path + 'consumo/insertpalco',
        method: 'get',
        params: consumo,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //actualizar la pantalla
      $scope.all();
      //mensaje de agregado con exito
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
         
    });
  }


  //---------------------CALLE--------------*------

  //llenar la variable de lo que se va a actualizar
  $scope.actCalle = function(consumo){
    $scope.consumo = consumo; 

    $scope.actualizarPalco = true;
    $scope.actualizarCalle = true;
  }

  $scope.editarConsumoCalle = function(consumo){
    //console.log(consumo);
    $http({
        url: path + 'consumo/actcalle',
        method: 'get',
        params: consumo,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //actualizar la pantalla
      $scope.all();
      //mensaje de agregado con exito
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
         
    });
  }

  $scope.guardarConsumoCalle = function(consumo ){
    consumo.idEvento = $rootScope.evento.idEvento;
    $http({
        url: path + 'consumo/insertcalle',
        method: 'get',
        params: consumo,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //actualizar la pantalla
      $scope.all();
      //mensaje de agregado con exito
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
         
    });
  }

  //----------------------ORGANICO ------------------------

  //llenar la variable de lo que se va a actualizar
  $scope.actOrganico = function(consumo){
    $scope.consumo = consumo; 
    $scope.actualizarOrganico = true;
  }

  $scope.editarConsumoOrganico = function(consumo){
    //console.log(consumo);
    $http({
        url: path + 'consumo/actorganico',
        method: 'get',
        params: consumo,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //actualizar la pantalla
      $scope.all();
      //mensaje de agregado con exito
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
         
    });
  }

  $scope.guardarConsumoOrganico = function(consumo){
    console.log(consumo);
    consumo.idEvento = $rootScope.evento.idEvento;
    $http({
        url: path + 'consumo/insertorganico',
        method: 'get',
        params: consumo,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //actualizar la pantalla
      $scope.all();
      //mensaje de agregado con exito
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
         
    });
  }
  
  $scope.all = function(){
    $http({
        url: path + 'consumo/all',
        method: 'get',
        params:{
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      
      $scope.consumoCalle = response.consumocalle;
      $scope.consumoPalco = response.consumopalco;
      $scope.consumoorganico = response.consumoorganico;
      $scope.reciclado = response.reciclado;
      $scope.impacto = response.impacto;
      $scope.ver = true;

      $scope.selectPalco = response.selectPalco;
      $scope.selectCalle = response.selectCalle;
      $scope.selectOrganico = response.selectOrganico;

      //calcular el porcentaje del total de cada costo reciclado
      $scope.totalReciclado = 0;
      //llenar la grafica
      //toneladas
      $scope.labels = [];
      $scope.data = [];
      //porcentaje de totales
      $scope.data2 = [];

      
      angular.forEach($scope.reciclado, function (value, key){
        $scope.totalReciclado += value.total;
      });
      angular.forEach($scope.reciclado, function (value, key){
        value.porcentaje  = Math.round((value.total*100)/$scope.totalReciclado);
        $scope.labels.push(value.material);
        $scope.data2.push(value.porcentaje);
        $scope.data.push(Math.round(value.tonelada));
      });
      //se agregan los puntos a la tabla Potencial de material Reciclable
      angular.forEach($scope.reciclado, function (value, key){
        value.kg = $scope.numberFormat(Math.round(value.kg).toString());
        value.total = $scope.numberFormat(Math.round(value.total).toString());
        value.cantidad = $scope.numberFormat(Math.round(value.cantidad).toString());
        value.valor = $scope.numberFormat(Math.round(value.valor).toString());
        value.total2 = $scope.numberFormat(value.total.toString());
      });

            
      console.log($scope.reciclado);


      //se agregan los puntos a los consumos de los palcos
      angular.forEach($scope.consumoPalco, function (value, key){
        value.consumo2 = $scope.numberFormat(Math.round(value.consumo).toString());
        value.costo2 = $scope.numberFormat(Math.round(value.costo).toString());
        value.venta2 = $scope.numberFormat(Math.round(value.venta).toString());
        value.totalCosto2 = $scope.numberFormat(Math.round(value.totalCosto).toString());
        value.totalVenta2 = $scope.numberFormat(Math.round(value.totalVenta).toString());       
      });
      //se agregan los puntos a los consumos de los calle
      angular.forEach($scope.consumoCalle, function (value, key){
        value.consumo = $scope.numberFormat(Math.round(value.consumo).toString());
        value.costo = $scope.numberFormat(Math.round(value.costo).toString());
        value.venta = $scope.numberFormat(Math.round(value.venta).toString());
        value.totalCosto = $scope.numberFormat(Math.round(value.totalCosto).toString());
        value.totalVenta = $scope.numberFormat(Math.round(value.totalVenta).toString());      
       
      });

      //se agregan los puntos al consumo organico
      angular.forEach($scope.consumoorganico, function (value, key){
        value.consumo = $scope.numberFormat(Math.round(value.consumo).toString());
        value.cantidad = $scope.numberFormat(Math.round(value.cantidad).toString());
        value.consumoTotal = $scope.numberFormat(Math.round(value.consumoTotal).toString());
        value.totalCosto = $scope.numberFormat(Math.round(value.totalCosto).toString());
        value.costo = $scope.numberFormat(Math.round(value.costo).toString());
        value.desperdicio = $scope.numberFormat(Math.round(value.desperdicio).toString());      
       
      });
      //puntos a el impacto
      console.log($scope.impacto);

      $scope.impacto.costoArboles = $scope.numberFormat(Math.round($scope.impacto.costoArboles).toString());
      $scope.impacto.reduccionArboles = $scope.numberFormat(Math.round($scope.impacto.reduccionArboles).toString());
      $scope.impacto.totalArboles =  $scope.numberFormat(Math.round($scope.impacto.totalArboles).toString());
      
      $scope.impacto.costoCompo = $scope.numberFormat(Math.round($scope.impacto.costoCompo).toString());
      $scope.impacto.reduccionCompo = $scope.numberFormat(Math.round($scope.impacto.reduccionCompo).toString());
      $scope.impacto.totalCompo =  $scope.numberFormat(Math.round($scope.impacto.totalCompo).toString());
      
      $scope.impacto.costoDese = $scope.numberFormat(Math.round($scope.impacto.costoDese).toString());
      $scope.impacto.reduccionDese = $scope.numberFormat(Math.round($scope.impacto.reduccionDese).toString());
      $scope.impacto.totalDese =  $scope.numberFormat(Math.round($scope.impacto.totalDese).toString());
      
      $scope.impacto.costoPrima = $scope.numberFormat(Math.round($scope.impacto.costoPrima).toString());
      $scope.impacto.reduccionPrima = $scope.numberFormat(Math.round($scope.impacto.reduccionPrima).toString());
      $scope.impacto.totalPrima =  $scope.numberFormat(Math.round($scope.impacto.totalPrima).toString());

      $scope.impacto.costoVerte = $scope.numberFormat(Math.round($scope.impacto.costoVerte).toString());
      $scope.impacto.reduccionVerte = $scope.numberFormat(Math.round($scope.impacto.reduccionVerte).toString());
      $scope.impacto.totalVerte =  $scope.numberFormat(Math.round($scope.impacto.totalVerte).toString());

      $scope.impacto.costoKwh = $scope.numberFormat(Math.round($scope.impacto.costoKwh).toString());
      $scope.impacto.reduccionKwh = $scope.numberFormat(Math.round($scope.impacto.reduccionKwh).toString());
      $scope.impacto.totalKwh =  $scope.numberFormat(Math.round($scope.impacto.totalKwh).toString());
      
      $scope.impacto.costoAgua = $scope.numberFormat(Math.round($scope.impacto.costoAgua).toString());
      $scope.impacto.reduccionAgua = $scope.numberFormat(Math.round($scope.impacto.reduccionAgua).toString());
      $scope.impacto.totalAgua =  $scope.numberFormat(Math.round($scope.impacto.totalAgua).toString());
      
      $scope.impacto.costoPetro = $scope.numberFormat(Math.round($scope.impacto.costoPetro).toString());
      $scope.impacto.reduccionPetro = $scope.numberFormat(Math.round($scope.impacto.reduccionPetro).toString());
      $scope.impacto.totalPetro =  $scope.numberFormat(Math.round($scope.impacto.totalPetro).toString());
      
      $scope.impacto.costoNatural = $scope.numberFormat(Math.round($scope.impacto.costoNatural).toString());
      $scope.impacto.reduccionNatural = $scope.numberFormat(Math.round($scope.impacto.reduccionNatural).toString());
      $scope.impacto.totalNatural =  $scope.numberFormat(Math.round($scope.impacto.totalNatural).toString());

      $scope.impacto.costoGas = $scope.numberFormat(Math.round($scope.impacto.costoGas).toString());
      $scope.impacto.reduccionGas = $scope.numberFormat(Math.round($scope.impacto.reduccionGas).toString());
      $scope.impacto.totalGas =  $scope.numberFormat(Math.round($scope.impacto.totalGas).toString());

      $scope.impacto.costoBio = $scope.numberFormat(Math.round($scope.impacto.costoBio).toString());
      $scope.impacto.reduccionBio = $scope.numberFormat(Math.round($scope.impacto.reduccionBio).toString());
      $scope.impacto.totalBio =  $scope.numberFormat(Math.round($scope.impacto.totalBio).toString());

      $scope.impacto.costoCo2 = $scope.numberFormat(Math.round($scope.impacto.costoCo2).toString());
      $scope.impacto.reduccionCo2 = $scope.numberFormat(Math.round($scope.impacto.reduccionCo2).toString());
      $scope.impacto.totalCo2 =  $scope.numberFormat(Math.round($scope.impacto.totalCo2).toString());

      $scope.impacto.costoBauxita = $scope.numberFormat(Math.round($scope.impacto.costoBauxita).toString());
      $scope.impacto.reduccionBauxita = $scope.numberFormat(Math.round($scope.impacto.reduccionBauxita).toString());
      $scope.impacto.totalBauxita =  $scope.numberFormat(Math.round($scope.impacto.totalBauxita).toString());

      $scope.impacto.costoHierro = $scope.numberFormat(Math.round($scope.impacto.costoHierro).toString());
      $scope.impacto.reduccionHierro = $scope.numberFormat(Math.round($scope.impacto.reduccionHierro).toString());
      $scope.impacto.totalHierro =  $scope.numberFormat(Math.round($scope.impacto.totalHierro).toString());
        
    });
  }

  /*PARA ACTUALIZAR LA TABLA VALORACION MATERIAL*/


  $scope.actualizarMaterial = function(r , index){
    
    $http({
        url: path + 'consumo/actmaterial',
        method: 'get',
        params:{
          idEvento : $rootScope.evento.idEvento,
          costo: r.valor,
          material: index
        } ,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //actualizar la pantalla
      $scope.actualizarMat = false;
      $scope.all();
      //mensaje de agregado con exito
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
    });
  }

  /*ACTUALIZAR TABLA BENEFICIO*/
  $scope.cambiarButtonBen = function(){
    if ($scope.actualizarBen == false) {
      $scope.actualizarBen = true;
    }else{
      $scope.actualizarBen = false;
    }
  }

  $scope.actualizarBeneficio = function(costo , index){
    $http({
        url: path + 'consumo/actbeneficio',
        method: 'get',
        params:{
          idEvento : $rootScope.evento.idEvento,
          costo: costo,
          tipoImpacto: index
        } ,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //actualizar la pantalla
      $scope.actualizarBen = false;
      $scope.all();
      //mensaje de agregado con exito
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
    });
  }
  $scope.all();
  

   $scope.numberFormat = function (numero){
        // Variable que contendra el resultado final
        var resultado = "";
        var nuevoNumero = "";
 
        // Si el numero empieza por el valor "-" (numero negativo)
        if(numero[0]=="-")
        {
            // Cogemos el numero eliminando los posibles puntos que tenga, y sin
            // el signo negativo
            nuevoNumero = numero.replace(/\./g,'').substring(1);
        }else{
            // Cogemos el numero eliminando los posibles puntos que tenga
            nuevoNumero= numero.replace(/\./g,'');
        }
 
        // Si tiene decimales, se los quitamos al numero
        if(numero.indexOf(",")>=0)
            nuevoNumero=nuevoNumero.substring(0,nuevoNumero.indexOf(","));
 
        // Ponemos un punto cada 3 caracteres
        for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++)
            resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0)? ".": "") + resultado;
 
        // Si tiene decimales, se lo añadimos al numero una vez forateado con 
        // los separadores de miles
        if(numero.indexOf(",")>=0)
            resultado +=numero.substring(numero.indexOf(","));
 
        if(numero[0]=="-")
        {
            // Devolvemos el valor añadiendo al inicio el signo negativo
          return "-"+resultado;
        }else{
      
            return resultado;
        }
    }



}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
