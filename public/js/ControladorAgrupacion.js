'use strict';
 
angular.module('myApp.Agrupacion', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/agrupacion', {
        templateUrl: 'pages/Agrupacion/agrupacion.html',
        controller: 'AgrupacionCtrl'
    });
}])

// Home controller
.controller('AgrupacionCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope , DTOptionsBuilder, DTColumnDefBuilder) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  $scope.agrupacion = {};
  $scope.swichCargo = 0;
  $scope.ver = false;
  $scope.button = 'Guardar';
  $scope.evento = $rootScope.evento;
  $scope.colores = [{'color': '#00EAB5'}, {'color' : '#FF6C00'}, {'color' : '#00ABF8'}, {'color' : '#F24B45'}, {'color' : '#D03B43'}, {'color' : '#AB313E'}, {'color' : '#503140'}, {'color' : '#322E3F'}];
    
  $scope.All = function(){
    $http({
        url: path + 'agrupacion/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.agrupaciones = response.agrupacion;
    });
  }

  $scope.cambiaCargo = function(){
    if ($scope.swichCargo == 0) {
      $scope.swichCargo = 1;
    }else{
      $scope.swichCargo = 0;  
    }
  }
 $scope.cambiarButton = function(){
      $scope.button = "Guardar";
      $scope.agrupacion = {};
  }

  $scope.cargarAgrupacion = function (agrupacion){

    $scope.agrupacion = agrupacion;
    $scope.agrupacion.nit = parseInt(agrupacion.nit);
    $scope.agrupacion.telefono = parseInt(agrupacion.telefono);
    $scope.agrupacion.telefono2 = parseInt(agrupacion.telefono2);
    $scope.agrupacion.nempleados = parseInt(agrupacion.nempleados);
    $scope.agrupacion.cantMujeres = parseInt(agrupacion.cantMujeres);
    $scope.agrupacion.cantHombres = parseInt(agrupacion.cantHombres);
    $scope.agrupacion.email = agrupacion.correo;
    $scope.departamentoSelect = agrupacion.departamento;
    $scope.buscarCiudad(agrupacion.departamento);
    $scope.ciudadSelect = parseInt(agrupacion.ciudad);
    $scope.regionSelect = agrupacion.region;
    $scope.generoSelect = agrupacion.genero;
    $scope.button ="Actualizar";
  }

  //Ver si hay un nuevo genero
  $scope.nuevoGenero  = function(){
    $scope.agrupacion.lat = $scope.lat;
    $scope.agrupacion.lng = $scope.lng;
    if ($scope.swichCargo == 1) {
      $http({
          url: path + 'genero/create',
          method: 'get',
          params:{
            nombre: $scope.agrupacion.genero
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        console.log(response.genero);
        $scope.agrupacion.genero = response.genero.idGenero;
          $scope.allGenero();
          $scope.guardarAgrupacion();
      });
    }else{
        $scope.guardarAgrupacion();
    }
  }


  
  $scope.colorRandom = function(){
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;

  }

  $scope.Reporte = function(){
    $http({
        url: path + 'agrupacion/reportegrupo',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.reporte = response.reporte;
      $scope.reporteGenero = response.genero;
      $scope.labels = [];
      $scope.data = [];

      angular.forEach($scope.reporteGenero, function (value, key){
        $scope.labels.push(value.nombre);
        $scope.data.push(value.cant);
        $scope.ver = true;
      });

      console.log($scope.labels);

    });
  }

  $scope.map;
  $scope.markers = [];
  $scope.initMap = function() {
      var haightAshbury = {lat: 10.4742449, lng: -73.2436335};

      //var haightAshbury = {lat: 37.769, lng: -122.446};

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

        // Adds a marker at the center of the map.
        //$scope.addMarker(haightAshbury);
    
  }

   // Adds a marker to the map and push to the array.
    $scope.addMarker = function(location) {
      $scope.lat = location.lat();
      $scope.lng = location.lng();
      console.log(location.lat(), location.lng());
      var marker = new google.maps.Marker({
        position: location,
        map: $scope.map
      });
      console.log(marker.getPosition());
      $scope.markers.push(marker);
      //console.log($scope.markers);
    }
  // Deletes all markers in the array by removing references to them.
  $scope.deleteMarkers = function() {
    $scope.clearMarkers();
    $scope.markers = [];
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
      console.log($scope.departamentos);
    });


  $scope.allGenero = function(){//todos los generos
    $http({
        url: path + 'genero/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.genero = response.genero;
     
    });
  }
  //todas las regiones
  $http({
      url: path + 'region/all',
      method: 'get',
      headers: {
          "Content-Type": "application/json"
      }
  }).success(function (response) {
    $scope.regiones = response.regiones;
    console.log($scope.regiones);
  });

  $scope.guardarAgrupacion = function(agrupacion){
   var route;
   if ($scope.button == "Guardar") {
    route = 'agrupacion/create';
   }else{
    route = 'agrupacion/update';
   }

    $http({
        url: path + route,
        method: 'get',
        params: $scope.agrupacion,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);

        $scope.agrupacion = {};
        $scope.All();
        $scope.Reporte();
      
    });
  }

  $scope.eliminar = function(agrupacion , index){

    $scope.agrupacionSeleccionada = agrupacion;
    $scope.index = index;

  }

  $scope.delete = function(){
   
      $http({
        url: path + 'agrupacion/delete',
        method: 'get',
        params:{
          idAgrupacion: $scope.agrupacionSeleccionada.idAgrupacion
        },
        headers: {
            "Content-Type": "application/json"
        }

      }).success(function (response) {
        
        if (response.error == false) {
          $scope.agrupaciones.splice($scope.index,  1);
          $('#myModal5').modal('show'); // abrir
            setTimeout(function(){
              $('#myModal5').modal('hide');
            },2000);
          };

        $scope.Reporte();
        
      });
    
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
      console.log($scope.ciudades);
      
    });
  }

  


  //LLAMADAS
  $scope.Reporte();
  $scope.All();
  $scope.allGenero();

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
