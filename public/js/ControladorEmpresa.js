'use strict';
 
angular.module('myApp.Empresa', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/empresa', {
        templateUrl: 'pages/Empresa/Empresa.html',
        controller: 'EmpresaCtrl'
    });
}])

.controller('EmpresaCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope , DTOptionsBuilder, DTColumnDefBuilder) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  $scope.ver = false;
  $scope.empresas ={};
  $scope.empresa = {};
  $scope.button = "Guardar"; // Botón inicializado en guardar 

  //Select de los tipos de empresas 
  $scope.tipoEmpresa = [
        { name: "Micro Empresa",  id: 0 },
        { name: "Pequeña Empresa", id: 1 },
        { name: "Mediana Empresa",  id: 2 },
        { name: "Grande Empresa",  id: 3 }
  ];


  $scope.reporteE = function(){

    $http({
        url: path + 'empresa/reportempresa',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
      $scope.reporte = response.reporte;
      $scope.sectorR = response.sectorArray;
      $scope.ver = true;
      $scope.labels = ["Micro", "Pequeña", "Mediana", "Grande"];;
      $scope.data = [];
      angular.forEach($scope.sectorR, function (value, key){
        $scope.data.push(value.cantidad);
    });

  });
 }

 $scope.all = function() {
   $http({
        url: path + 'empresa/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.empresas = response.empresa;
    });
  }

  $scope.cambiarButton = function(){
      $scope.button = "Guardar";
      $scope.empresa = {};
  }

  $scope.guardar = function() {
    var route;
   if ($scope.button == "Guardar") {
    route = 'empresa/create';
   }else{
    route = 'empresa/update';
   }
   $scope.empresa.lat = $scope.lat;
   $scope.empresa.lng = $scope.lng;

    $http({
        url: path + route,
        method: 'get',
        params: $scope.empresa,
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.all();
       $scope.reporteE();
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);

    });
  }

  $scope.cargarEmpresa = function (empresa){

    $scope.empresa = empresa;
    $scope.empresa.nit = parseInt(empresa.nit);
    $scope.empresa.telefono1 = parseInt(empresa.telefono1);
    $scope.empresa.telefono2 = parseInt(empresa.telefono2);
    $scope.tipoSelect = empresa.sector;
    $scope.departamentoSelect = empresa.departamento;
    $scope.buscarCiudad($scope.departamentoSelect);
    $scope.ciudadSelect = empresa.ciudad;
    $scope.button ="Actualizar";
  }


  $scope.delete = function(){
  
    $http({
      url: path + 'empresa/delete',
      method: 'get',
      params:{
        idEmpresa: $scope.empresaSeleccionada.idEmpresa
      },
      headers: {
          "Content-Type": "application/json"
      }

    }).success(function (response) {
      
      if (response.error == false) {
        $scope.empresas.splice($scope.index,  1);
        $scope.reporteE();
      $('#myModal5').modal('show'); // abrir modal
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
      };
      
    });
      
  }
  $scope.eliminar = function(empresa, index){
    $scope.empresaSeleccionada = empresa;
    $scope.index = index; 
  }
  
  $scope.buscarCiudad = function(idDepartamento){
    
    $http({
        url: path + 'ciudad/all',
        method: 'get',
        params:{
          idDepartamento: idDepartamento 
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.ciudades = response.ciudades;
    });
  }

    //todos los departamentos
    $http({
        url: path + 'departamento/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.departamentos = response.departamentos;
    });

 /*----------------------MAPA-------------------------*/
  $scope.map;
  $scope.markers = [];
  $scope.initMap = function() {
      var haightAshbury = {lat: 10.4742449, lng: -73.2436335};

       $scope.map = new google.maps.Map(document.getElementById('map2'), {
          zoom: 16,
          center: haightAshbury,
          mapTypeId: 'terrain'
        });

        // This event listener will call addMarker() when the map is clicked.
        $scope.map.addListener('click', function(event) {
          //alert();
          if ($scope.markers.length == 0) {
            $scope.addMarker(event.latLng);  
          }
          
        });
    
  }

     // Adds a marker to the map and push to the array.
      $scope.addMarker = function(location) {
        $scope.lat = location.lat();
        $scope.lng = location.lng();

        var marker = new google.maps.Marker({
          position: location,
          map: $scope.map
        });
        $scope.markers.push(marker);
        //console.log($scope.markers);
      }

      // Sets the map on all markers in the array.
      $scope.setMapOnAll = function(map) {
        for (var i = 0; i < $scope.markers.length; i++) {
          $scope.markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      $scope.clearMarkers = function() {
        $scope.setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      $scope.showMarkers = function() {
        $scope.setMapOnAll($scope.map);
      }

      // Deletes all markers in the array by removing references to them.
      $scope.deleteMarkers = function() {
        $scope.clearMarkers();
        $scope.markers = [];
      }

    /*------------------------------SEPARADOR DE MILES----------------------------*/
    $("#empresanit").on({
        "focus": function (event) {
            $(event.target).select();
        },
        "keyup": function (event) {
            $(event.target).val(function (index, value ) {
                return value.replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            });
        }
    }); 

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


  /*---------------------------FIN DE SEPARADOR DE MILES-------------------------*/
 
//LLAMADAS
  $scope.all();
  $scope.reporteE();

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
