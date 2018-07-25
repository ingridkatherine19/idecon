'use strict';
 
angular.module('myApp.Invitacion', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/invitacion', {
        templateUrl: 'pages/Invitacion/Invitacion.html',
        controller: 'InvitacionCtrl'
    });
}])

// Home controller
.controller('InvitacionCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  if (!$rootScope.evento) {
    window.location.href = '#/evento';
  }
  $scope.ver = false;
  $scope.switch = 0 //Mostrar la primera vista
  $scope.listadoSelect = [];
  $scope.tipousuarioSelect = 0;
  $scope.valor = 0;
  $scope.mensaje = {};
  console.log($rootScope.evento);

  $scope.tipoUsuario = [
        { name: "Empresa",  id: 0 },
        { name: "Agrupaciones", id: 1 },
        { name: "Participantes",  id: 2 },
        { name: "Hoteles",  id: 3},
        { name: "Restaurantes",  id: 4}

  ];
  $scope.cambiarTabla = function(){
    var valorRadio = document.getElementsByName('radiobutton');
    for (var i = 0, length = valorRadio.length; i < length; i++) {
        if (valorRadio[i].checked) {
            // Valor del radio button capturado
            if (valorRadio[i].value == 0) {
              $scope.valor = 0;
            }else{
              $scope.valor = 1;
            }
             // only one radio can be logically checked, don't check the rest
            break;
        }
    }
  }
  $scope.changeSwitch = function () {
 
    if ($scope.switch == 0) {
      $scope.switch = 1;
    }else{
      $scope.switch = 0;
    } 
  }

  $scope.limpiarLista = function (){
    $scope.listadoSelect = [];
  }
  

/*  $scope.cambiarTabla = function(valor){
    
    if (valor == 0) {
      $scope.valor = 0;
    }else{
      $scope.valor = 1;
    }
  }
*/

   $scope.listaSeleccionada = function(lista){
      var inserta = false;
      var elimina  =  false;

      console.log(lista);
        if ($scope.listadoSelect.length == 0) {
           $scope.listadoSelect.push(lista);

        }else{
            for (var i = $scope.listadoSelect.length - 1; i >= 0; i--) {
                if ($scope.listadoSelect[i] == lista) {
                  elimina  =  true;
                  var posicion = i;
               
                }else{
                  if ($scope.listadoSelect[i] != lista) {
                      //$scope.empresaSelect.push(empresa);
                      inserta = true;
                  }

                }
            }

            if (elimina) {
              $scope.listadoSelect.splice(posicion, 1);
            }else{
              if (inserta) {
                $scope.listadoSelect.push(lista);
              }
            }
        }
         //$scope.guardar($scope.listadoSelect);
    }

  $scope.selectMensaje = function(mensaje , index){
    $scope.mensajeSelect = mensaje;
    $scope.indexSelect = index;
    console.log($scope.mensajeSelect );
  }

  $scope.actualizarMensaje = function (){
      $http({
          url: path + 'invitacion/actualizarmensaje',
          method: 'get',
          params:{
            idMensaje: $scope.mensajeSelect.idMensaje, 
            texto: $scope.mensajeSelect.texto,
            idEvento: $rootScope.evento.idEvento
      },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {

        $('#myModal2').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal2').modal('hide');
        },2000);
        $scope.mensajeAll();
        $scope.responseMensaje = response.respuesta;
      });
  }

  $scope.guardarMensaje = function(mensaje){
    
    $http({
          url: path + 'invitacion/guardarmensaje',
          method: 'get',
          params:{
            tipo: mensaje.tipo, 
            texto: mensaje.texto,
            idEvento: $rootScope.evento.idEvento
      },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.responseMensaje = response.respuesta;
        $('#myModal2').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal2').modal('hide');
        },2000);
        $scope.mensajeAll();
        $scope.mensaje = {};
        });

  }

  $scope.guardar = function(caso){
    if (caso == 0) {//SI el caso es 0 es difusion
      $scope.datos = $scope.noinvitadas;
    }else{
      if (caso == 1) {//SI el caso es 1 es una seleccion
        $scope.datos = $scope.listadoSelect;
      }
    }
    console.log($scope.datos);
    if ($scope.datos != []) {
      $http({
            url: path + 'invitacion/guardar',
            method: 'get',
            params:{
              tipo: $scope.tipoSelect, 
              datos: JSON.stringify($scope.datos),
              idEvento: $rootScope.evento.idEvento
              
        },
            headers: {
                "Content-Type": "application/json"
            }
        }).success(function (response) {
            $scope.responseMensaje = response.mensaje;
            $('#myModal2').modal('show'); // abrir
              setTimeout(function(){
                $('#myModal2').modal('hide');
            },2000);
            $scope.valor = 0;
            $scope.invitados = {};
            $scope.noinvitadas = {};
            $scope.listadoSelect = {};
            $scope.buscarLista($scope.tipoSelect);
          //  $scope.buscarLista($scope.tipoSelect);
      });      
    }

  }

  $scope.buscarLista = function(tipo){

    $scope.tipoSelect = tipo;

     $http({
          url: path + 'invitacion/listado',
          method: 'get',
          params:{
            tipo: $scope.tipoSelect, //el tipo de la tabla que es, si es empresa, participante o agrupacion 
          	idEvento: $rootScope.evento.idEvento
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.invitados = response.invitadas;
        $scope.noinvitadas = response.noinvitadas;
        console.log($scope.noinvitadas);
        $scope.ver = true;
      });


  }


  $scope.eliminarMensaje = function(mensaje , index){
    
        $http({
            url: path + 'mensaje/delete',
            method: 'get',
            params:{
              idMensaje: $scope.mensajeSelect.idMensaje
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).success(function (response) {
           $scope.mensajes.splice($scope.indexSelect,  1);
        });
    
   }

   $scope.mensajeAll = function(){
    $http({
          url: path + 'mensaje/all',
          method: 'get',
          params:{
            idEvento: $rootScope.evento.idEvento
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.mensajes = response.mensajes;
        
      });
  }

  $scope.capturaValor = function(seleccionado , index){
    $scope.seleccionado = seleccionado;
    $scope.index = index;
  }

  $scope.cambiarEstado = function (estado){
  
    $http({
          url: path + 'invitacion/estado',
          method: 'get',
          params:{
            idInvitacion: $scope.seleccionado.idInvitacion,
            estado: estado
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
          
          $scope.responseMensaje = response.mensaje;
          $('#myModal2').modal('show'); // abrir
            setTimeout(function(){
              $('#myModal2').modal('hide');
          },2000);
          $scope.invitados[$scope.index].estado = estado;
        
      });

  }

   $scope.mensajeAll();
   $scope.buscarLista($scope.tipousuarioSelect);
  

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
