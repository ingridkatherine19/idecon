'use strict';

//var path="http://maintsoft.siasolutions.com.co/maintSoft/public/";
var path="http://192.168.100.238/ideconNuevo/public/";

// Declare app level module which depends on views, and components
angular.module('myApp', [
  'ngRoute',
  'chart.js',
  'myApp.view1',
  'myApp.view2',
  'myApp.Evento',
  'myApp.Empresa',
  'myApp.Actividad',
  'myApp.Dashboard',
  'myApp.Participante',
  'myApp.Agrupacion',
  'myApp.Hotel',
  'myApp.Presupuesto',
  'myApp.Invitacion',
  'myApp.PresupuestoReal',
  'myApp.Restaurante',
  'myApp.Reporte',
  'myApp.Lugar',
  'myApp.Encuesta',
  'myApp.EventoUsuario',
  'myApp.ActividadUsuario',
  'myApp.Consumo',
  'isteven-multi-select'

]).directive('fileUpload', function () {
    return {
        scope: true,        //create a new scope
        link: function (scope, el, attrs) {
            el.bind('change', function (event) {
                var files = event.target.files;
                //iterate files since 'multiple' may be specified on the element
                for (var i = 0;i<files.length;i++) {
                    //emit event upward
                    scope.$emit("fileSelected", { file: files[i] });
                }                                       
            });
        }
    };
}).
config(['$routeProvider','ChartJsProvider', function($routeProvider,$scope, $rootScope, ChartJsProvider) {

  $routeProvider.otherwise({redirectTo: '/dashboard'});

}])
.controller('appCtrl', ['$http', '$scope', '$rootScope','$interval', function($http, $scope, $rootScope, $interval) {

}]);