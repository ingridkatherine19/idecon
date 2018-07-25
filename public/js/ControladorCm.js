'use strict';
 
angular.module('myApp.Cm', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/cm', {
        templateUrl: 'pages/Cm/cm.html',
        controller: 'CmCtrl'
    });
}])

// Home controller
.controller('CmCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope) {
  //declaracion de variables
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  $scope.cm ={};
  // var param1 = $routeParams.param1;
  // console.log(param1);
  $scope.cmNuevo = 0;
  //trae todas las maquinas
  $scope.allMaquina = function(){
    $http({
        url: path + 'maquina/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.maquinas = response.maquinas;
       $scope.maquinaSeleccionada = $scope.maquinas[0];
       $scope.maqui = $scope.maquinas[0].idMaquina;
       console.log($scope.maquinas);
    });
  }

  $scope.eliminar = function(id, index){
    $scope.r = confirm('¿Seguro que desea eliminar ese manteniiento preventivo? si lo elimina se eliminara toda la informacion asociada a el');
    if ($scope.r) {
      $http({
          url: path + 'cm/delete',
          params:{
            idCm: id
          },
          method: 'get',
          headers: {
              "Content-Type": "application/json"
          }

      }).success(function (response) {
        $scope.maquinaSeleccionada.cm.splice(index, 1);
        alert('Se elimino correctamente');
      });
    }
  }

  $scope.preparar = function(cm){
    $scope.cm = cm;
    console.log($scope.cm);
  }

  $scope.editarCm = function(){
    $http({
        url: path + 'cm/update',
        params:{
          idCm: $scope.cm.idCm,
          observacion: $scope.cm.observacion
        },
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
      
    });
  }

  $scope.nuevo = function(){
    $scope.cmNuevo = 1;
  }

  $scope.cancelar = function(){
    $scope.cmNuevo = 0;
  }

  $scope.filtrar = function(maquina){
    angular.forEach($scope.maquinas, function(value, key) {
      if(value.idMaquina== maquina){
       $scope.maquinaSeleccionada = value;   
      }
    });
  }
  //trae todas los usuarios
  $scope.allUsuarios = function(){
    $http({
        url: path + 'usuario/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.usuarios = response.usuario;
       //console.log($scope.usuarios);
    });
  }

  $scope.insertar = function(){
    var file = document.getElementById('file').files[0];
    var fd = new FormData();
    fd.append('file', document.getElementById('file').files[0]);
     fd.append('cm', JSON.stringify($scope.cm));
          $http.post(path + 'cm/create', fd, {
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined}
       }).success(function(response){
          $scope.cmNuevo = 0;
          $scope.allMaquina();   
       })
        .error(function(response){

        });
  }


  $scope.allMaquina();
  $scope.allUsuarios();    

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
