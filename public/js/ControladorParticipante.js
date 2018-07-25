'use strict';
 
angular.module('myApp.Participante', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/participante', {
        templateUrl: 'pages/Participante/participante.html',
        controller: 'ParticipanteCtrl'
    });
}])

// Home controller
.controller('ParticipanteCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope , DTOptionsBuilder, DTColumnDefBuilder) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  $scope.participantes ={};
  $scope.participante = {};
  $scope.ver = false;
  $scope.button = "Guardar";
  $scope.colores = [{'color': '#00EAB5'}, {'color' : '#FF6C00'}, {'color' : '#00ABF8'}, {'color' : '#F24B45'}, {'color' : '#D03B43'}, {'color' : '#AB313E'}, {'color' : '#503140'}, {'color' : '#322E3F'}];
  

  $scope.tipoUsuario = [
        { name: "Natural",  id: 0 },
        { name: "Jurídico", id: 1 }
  ];
  $scope.sexoUsuario = [
        { name: "Masculino",  id: 0 },
        { name: "Femenino", id: 1 }
  ];
  $scope.nivelUsuario = [
        { name: "Educación Media",  id: 0 },
        { name: "Técnico", id: 1 },
        { name: "Técnico Profesional", id: 2 },
        { name: "Tecnólogo", id: 3 },
        { name: "Profesional", id: 4 },
        { name: "Especialización", id: 5},
        { name: "Maestría", id: 6},
        { name: "Doctorado", id: 7},
        { name: "Ninguno", id: 8}
  ];
  $scope.estadoCivil = [
        { name: "Soltero",  id: 0 },
        { name: "Casado", id: 1 },
        { name: "Viudo", id: 2 }
  ];


  $scope.All = function(){
     $http({
        url: path + 'participante/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.participantes = response.participante;
      
    });
  }

  $scope.cambiarButton = function(){
      $scope.button = "Guardar";
      $scope.participante = {};
  }

  $scope.cargarParticipante = function (participante){
    $scope.button = "Actualizar";
    console.log(participante);
    $scope.participante = participante;
    $scope.participante.cedula = parseInt(participante.cedula);
    $scope.participante.edad = parseInt(participante.edad);
    $scope.participante.telefono = parseInt(participante.telefono);
    $scope.participante.telefono2 = parseInt(participante.telefono2);
    $scope.participante.fechaNac = new Date(participante.fechaNac);
    $scope.tipoSelect = participante.tipo;
    $scope.sexoSelect = participante.sexo;
    $scope.departamentoSelect = participante.departamento;
    $scope.buscarCiudad(participante.departamento);
    $scope.ciudadSelect = parseInt(participante.ciudad);
    $scope.nivelSelect = participante.nivelAcademico;
    $scope.estadoSelect = participante.estadoCivil;
  }


  $scope.cambiarTipo = function(tipo){
  
    if (tipo == 2) {
      $scope.All();
    }else{
      $http({
        url: path + 'participante/tipo',
        method: 'get',
        params:{tipo: tipo},
        headers: {
            "Content-Type": "application/json"
        }
      }).success(function (response) {
      $scope.participantes = response.participante;
      
     });
    }

  }

  $scope.reporteParticipante = function(){

    $http({
          url: path + 'participante/reporteP',
          method: 'get',
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.reporte = response.reporte;
        $scope.nivelAcademico = response.nivelAcademico;
        $scope.labels = [];
        $scope.data = [];
        $scope.ver = true;
        

      angular.forEach($scope.nivelAcademico, function (value, key){
        $scope.labels.push(value.nombre);
        $scope.data.push(value.cantidad);

      });

    });
  }

  $scope.eliminar = function(participante , index){
    $scope.participanteSeleccionado = participante;
    $scope.index = index;
  }

  $scope.delete = function(){
      $http({
        url: path + 'participante/delete',
        method: 'get',
        params:{
          idParticipante: $scope.participanteSeleccionado.idParticipante
        },
        headers: {
            "Content-Type": "application/json"
        }

      }).success(function (response) {
        if (response.error == false) {
          $scope.participantes.splice($scope.index,  1);
          $('#myModal5').modal('show'); // abrir
            setTimeout(function(){
              $('#myModal5').modal('hide');
            },2000);
          };
      });
  }

  $scope.guardar = function() {
    console.log($scope.participante);
   var route;
   if ($scope.button == "Guardar") {
    route = 'participante/create';
   }else{
    route = 'participante/update';
   }

    $http({
        url: path + route,
        method: 'get',
        params: $scope.participante,
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
      
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      
      $scope.All();
      
      $scope.participante = {};


    });
  }

  $scope.buscarCiudad = function(idDepartamento){
  
    $http({
        url: path + 'ciudad/all',
        method: 'get',
        params:{
          idDepartamento: 11 //PRUEBA
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.ciudades = response.ciudades;
      console.log($scope.ciudades);
      
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
      console.log($scope.departamentos);
    });
//LLAMADAS
$scope.All();
$scope.reporteParticipante();


}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
