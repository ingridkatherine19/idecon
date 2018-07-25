'use strict';
 
angular.module('myApp.Lugar', ['ngRoute' , 'isteven-multi-select'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/lugar', {
        templateUrl: 'pages/Lugar/Lugar.html',
        controller: 'LugarCtrl'
    });
}])

// Home controller
.controller('LugarCtrl', ['$http', '$scope', '$rootScope' , function($http, $scope, $rootScope , DTOptionsBuilder, DTColumnDefBuilder) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  //console.log($rootScope.user);
  $scope.ver = false;
  $scope.lugares ={};
  $scope.lugar = {};
  $scope.button = "Guardar";
  $scope.colores = [{'color': '#00EAB5'}, {'color' : '#FF6C00'}, {'color' : '#00ABF8'}, {'color' : '#F24B45'}, {'color' : '#D03B43'}, {'color' : '#AB313E'}, {'color' : '#503140'}, {'color' : '#322E3F'}];
  $scope.tipos = [
      { name: "Edificaciones",  id: 0 },
      { name: "Edificios y Expresiones Religiosos", id: 1 },
      { name: "Realizaciones técnico cientificas",  id: 2 },
      { name: "Parque Natural",  id: 3 },
      { name: "Monumentos",  id: 4 },
      { name: "Rios",  id: 5 },
      { name: "Arroyos", id: 6 },
      { name: "Actividad Turística",  id: 7 },
      { name: "Festivales y Fiestas",  id: 8 },
      { name: "Expresiones Religiosas",  id: 9 },
      { name: "Ferias y Exposiciones",  id: 10 },
      { name: "Gastronomía",  id: 11 },
      { name: "Grupos Culturales", id: 12 },
      { name: "Pueblos indigenas",  id: 13 },
      { name: "Balneario",  id: 14 },
      { name: "Artesania",  id: 15 },
      { name: "Museo",  id: 16 },
      { name: "Tradiciones-Cuentos-Bailes", id: 17 },
      { name: "Eco-Turismo",  id: 18 },
      { name: "Acequía",  id: 19 },
      { name: "Humedades",  id: 20 },
      { name: "Quebradas", id: 21 },
      { name: "Cienagas",  id: 22 },
      { name: "Biblioteca",  id: 23 },
      { name: "Escuela",  id: 24 }
  ];

  $scope.recursos = [
      { name: "Recursos Culturales",  id: 0 },
      { name: "Destinos Naturales y Turísticos", id: 1 },
      { name: "Festividades y Eventos",  id: 2 }
  ];
  $scope.categorias = [
      { name: "Arquitectónico",  id: 0 },
      { name: "Destinos Naturales", id: 1 },
      { name: "Destinos Turísticos",  id: 2 },
      { name: "Eventos Artísticos y Culturales", id: 3 },
      { name: "Manifestaciones Folcloricas",  id: 4 },
      { name: "Grupos Étnicos",  id: 5 },
      { name: "Formacion cultural", id: 6 }
  ];


  $scope.limpiar = function(){
      $scope.lugar = {};
      $scope.setMapOnAll(null);
  }

  $scope.reporteE = function(){

    $http({
        url: path + 'lugar/reporte',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.reporte = response.reporte;
       $scope.resultado = response.resultado;
       $scope.data =[];
       $scope.ver = true;
       //console.log($scope.reporte);
     
      angular.forEach($scope.reporte, function (value, key){
        
        $scope.prueba = {
          label: value.nombre,
          promedio: value.promedio,
          color: value.color,
          fillColor: value.color,
          strokeColor: value.color,
          pointColor: value.color,
          pointStrokeColor: value.color,
          pointHighlightFill: "#fff",
          pointHighlightStroke: "#514e8f",
          data: [value.cantidad]
        }

        $scope.data.push($scope.prueba);

      });

      $scope.dataIngreso = {//BAR CHART ?????????????
        labels: [""],
        datasets: $scope.data
      };

      // $scope.cargarGrafica();
       $scope.graficaSector();
    });
 
  }

 $scope.all = function() {
   $http({
        url: path + 'lugar/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.lugares = response.lugar;
       console.log($scope.lugares);
    });
  }
  $scope.cambiarButton = function(){
      $scope.button = "Guardar";
  }
  $scope.guardar = function() {
   var route;
   if ($scope.button == "Guardar") {
    route = 'lugar/create';
   }else{
    route = 'lugar/update';
   }
    $scope.lugar.lat = $scope.lat;
    $scope.lugar.lng = $scope.lng;
    $http({
        url: path + route,
        method: 'get',
        params: $scope.lugar,
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.lugares = response.lugares;
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
       $scope.all();

    });
  }

  $scope.cargarLugar = function (lugar){
    $scope.lugar = lugar;
    $scope.button ="Actualizar";
    console.log($scope.lugar);
    $scope.tipoSelect = lugar.tipo;
    $scope.categoriaSelect  =lugar.categoriaderecurso;
    $scope.recursoSelect = lugar.recurso;
    $scope.departamentoSelect = lugar.departamento;
    $scope.regionSelect = lugar.region;
  }

  $scope.delete = function(lugar , index){
    $scope.lugarSelect = lugar;
    $scope.indexSelect = index;
  }

  $scope.eliminar = function (){
    $http({
        url: path + 'lugar/delete',
        method: 'get',
        params:{idLugar: $scope.lugarSelect.idLugar},
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
        if (response.error == false) {
          $scope.lugares.splice($scope.indexSelect,  1);
          $('#myModal5').modal('show'); // abrir
            setTimeout(function(){
              $('#myModal5').modal('hide');
          },2000);
        $scope.all();
        };
        
    });
  }
  $scope.regionall = function(){
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
 /*----------------------MAPA-------------------------*/
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
  //$scope.initMap();

//LLAMADAS
  $scope.all();
  $scope.reporteE();
  $scope.regionall();

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
