'use strict';
 
angular.module('myApp.Detalle', ['ngRoute' ,'isteven-multi-select'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider
    .when('/detalle', {
        templateUrl: 'pages/Evento/detalleEvento.html',
        controller: 'DetalleCtrl'
    });
}])

// Home controller
.controller('DetalleCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope , DTOptionsBuilder, DTColumnDefBuilder) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  $scope.cambio = 0;
  $scope.evento = $rootScope.detalle;
  $scope.evento.fechaInicio = new Date($scope.evento.fechaInicio);
  $scope.evento.fechaFin = new Date($scope.evento.fechaFin);
  

  $scope.editar = function(){
    if ($scope.cambio == 0) {
      $('#nombre').removeAttr("disabled");
      $('#nit').removeAttr("disabled");
      $('#version').removeAttr("disabled");
      $('#poblacion').removeAttr("disabled");
      $('#circulante').removeAttr("disabled");
      $('#fundado').removeAttr("disabled");
      $('#inicio').removeAttr("disabled");
      $('#fin').removeAttr("disabled");
      $('#direccion').removeAttr("disabled");
      $('#codigo').removeAttr("disabled");
      $('#departamento').removeAttr("disabled");
      $('#ciudad').removeAttr("disabled");
      $('#region').removeAttr("disabled");
      $('#telefono').removeAttr("disabled");
      $('#telefono2').removeAttr("disabled");
      $('#correo').removeAttr("disabled");
      $('#correo2').removeAttr("disabled");
      $('#web').removeAttr("disabled");
      $('#facebook').removeAttr("disabled");
      $('#instagram').removeAttr("disabled");
      $('#twitter').removeAttr("disabled");
      $scope.cambio = 1;
    }else{
      $('#nombre').prop("disabled", true);
      $('#nit').prop("disabled", true);
      $('#version').prop("disabled", true);
      $('#poblacion').prop("disabled", true);
      $('#circulante').prop("disabled", true);
      $('#fundado').prop("disabled", true);
      $('#inicio').prop("disabled", true);
      $('#fin').prop("disabled", true);
      $('#direccion').prop("disabled", true);
      $('#codigo').prop("disabled", true);
      $('#departamento').prop("disabled", true);
      $('#ciudad').prop("disabled", true);
      $('#region').prop("disabled", true);
      $('#telefono').prop("disabled", true);
      $('#telefono2').prop("disabled", true);
      $('#correo').prop("disabled", true);
      $('#correo2').prop("disabled", true);
      $('#web').prop("disabled", true);
      $('#facebook').prop("disabled", true);
      $('#instagram').prop("disabled", true);
      $('#twitter').prop("disabled", true);

      $scope.cambio = 0;
    }
    
  }

  //trae todos los datos necesarios 
  $scope.all = function(){
    //todos los departamentos

    $http({
        url: path + 'departamento/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.departamentos = response.departamentos;
      //console.log($scope.departamentos);
       
    });

    //buscar cioudades

    $scope.buscarCiudades();
    //todos los Regiones
    $http({
        url: path + 'region/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.regiones = response.regiones;
      //console.log($scope.regiones);

    });
  }


  $scope.buscarCiudades = function(){
    //alert('jhdgd');
    console.log($scope.evento.idDepartamento);
    $http({
        url: path + 'ciudad/all',
        method: 'get',
        params:{
          idDepartamento: $scope.evento.idDepartamento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.ciudades = response.ciudades;
  
    });
  }


  $scope.guardar = function(){

    $http({
        url: path + 'evento/update',
        method: 'get',
        params: $scope.evento,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      alert("Se ha actualizado correctamente");
    });
  }

$scope.all();
 

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
