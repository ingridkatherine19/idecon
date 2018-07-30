'use strict';
 
angular.module('myApp.Encuesta', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/encuesta', {
        templateUrl: 'pages/Encuesta/encuesta.html',
        controller: 'EncuestaCtrl'
    });
}]) 

// Home controller
.controller('EncuestaCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  if (!$rootScope.evento) {
    window.location.href = '#/evento';
  }
  $scope.ver = false;
  console.log($rootScope.evento);
  $scope.nuevoEvento = [];
  $scope.switch = 0;
  $scope.pregunta = {};
  $scope.editar = 0;
  $scope.data2 = [];
  $scope.data3 = [];
  $scope.titulo = 'Agregar Pregunta';
  $scope.button = 'Guardar';
  $scope.cambio = 0;


  
  //$scope.labels = ['', ''];
  $scope.labels = ['Agrupación', 'Empresa', 'Participante', 'Público'];
  
  $scope.cambiarSwitch = function () {
    if ($scope.switch == 0) {
      $scope.switch = 1;
    }else{
      $scope.switch = 0;
    }
  }

  $scope.cambiarButton = function(value){
    console.log(value);
    if (value == 0) {
      $scope.titulo = 'Agregar Pregunta';
      $scope.cambio = 0;
      $scope.pregunta = {};
 
    }else{
      $scope.titulo = 'Actualizar Pregunta';
      $scope.cambio = 1;
    }

  }

  $scope.selectID = function(idPregunta , index) {
    $scope.idSeleccionado = idPregunta;
    $scope.indexS = index;
  }

  $scope.editarEvento = function (pregunta) {
    /*
    $scope.index = index;
    if ($scope.editar == 0) {
      $scope.editar = 1;

    }else{
      $scope.editar = 0;
    }*/
    $scope.preguntaSelect = pregunta; 
    $scope.pregunta.pregunta = pregunta.pregunta;

 
  }

  $scope.editarPregunta = function(pregunta , index){
    console.log(pregunta);
   $http({
        url: path + 'pregunta/update',
        method: 'get',
        params:{
          idEvento:  $rootScope.evento.idEvento,
          idPregunta: $scope.preguntaSelect.idPregunta,
          pregunta: pregunta.pregunta
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
        $scope.preguntas[index] = pregunta;
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
        $scope.preguntaAll();
        $scope.buscarReporte();
     
    });
  }

  $scope.agregarPregunta = function(encuesta){
   $http({
        url: path + 'pregunta/create',
        method: 'get',
        params:{
          idEvento:  $rootScope.evento.idEvento,
          pregunta: encuesta.pregunta,
          tipo: encuesta.tipo
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
        $scope.switch = 0; 
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
        $scope.preguntaAll();
        $scope.buscarReporte();

    });
  }

    $scope.eliminarPregunta = function(){
    
     $http({
        url: path + 'pregunta/delete',
        method: 'get',
        params:{
          idPregunta: $scope.idSeleccionado 
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
          if (response.error == false) {
            $scope.preguntas.splice($scope.indexS,  1);
            $('#myModal5').modal('show'); // abrir
            setTimeout(function(){
              $('#myModal5').modal('hide');
            },2000);  
            $scope.buscarReporte();
          };
          
    });

    }

    $scope.buscarReporte = function(){
      $http({
          url: path + 'reporte/encuesta2',
          method: 'get',
          params:{
          idEvento:  $rootScope.evento.idEvento
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.reporte = response.pregunta;
        $scope.reporteTipo = response.reporteTipo;
        console.log($scope.reporte);
        $scope.ver = true;
        if ($scope.reporteTipo.length != 0) {
          $scope.data = [
            $scope.reporteTipo[0].tipoAgrupacion,
            $scope.reporteTipo[0].tipoEmpresa,  
            $scope.reporteTipo[0].tipoParticipante,
            $scope.reporteTipo[0].tipoPublico
          ];
        }
          

        $scope.labels2 = ["Execelente", "Bueno", "Regular" , "Malo" , "Pésimo" , "Nada"];
        $scope.labels3 = ["Si", "No"];
        angular.forEach($scope.reporte, function (value, key){
          if (value.tipo == 1) {
            $scope.prueba = [[value.excelente], [value.bueno], [value.regular] , [value.malo] , [value.pesimo] , [value.nada]];
            $scope.data2.push($scope.prueba);
          }else{
           
              $scope.prueba = [[value.si], [value.no]];
              $scope.data2.push($scope.prueba);
          }
   

        });

      console.log($scope.reporte);
   //   $scope.graficaBarras();
      });

    }

    $scope.preguntaAll = function(){

     $http({
          url: path + 'pregunta/all',
          method: 'get',
          params:{
          idEvento:  $rootScope.evento.idEvento
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
          $scope.preguntas = response.pregunta;
      });
  }


  $scope.preguntaAll();
  $scope.buscarReporte();
}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
