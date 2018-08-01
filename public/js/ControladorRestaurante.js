'use strict';

angular.module('myApp.Restaurante', ['ngRoute' , 'isteven-multi-select'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/restaurante', {
        templateUrl: 'pages/Restaurante/restaurante.html',
        controller: 'RestauranteCtrl'
    });
}])

// Home controller
.controller('RestauranteCtrl', ['$http', '$scope', '$rootScope' , function($http, $scope, $rootScope , DTOptionsBuilder, DTColumnDefBuilder) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  $scope.restaurantes = {};
  $scope.ver = false;
  $scope.restaurante = {};
  $scope.servicioSelect = [];
  $scope.labels = ["Restaurante de Lujo", "Restaurante de Primera", "Restaurante de Segunda" , "Restaurante de Tercera" , "Restaurante de Cuarta"];
  $scope.data = [];
  $scope.colores = [{'color': '#00EAB5'}, {'color' : '#FF6C00'}, {'color' : '#00ABF8'}, {'color' : '#F24B45'}, {'color' : '#D03B43'}, {'color' : '#AB313E'}, {'color' : '#503140'}, {'color' : '#322E3F'}];
  $scope.tipodeRestaurante = [
      { name: "Restaurantes de lujo",  id: 0 },
      { name: "Restaurantes de primera", id: 1 },
      { name: "Restaurantes de segunda",  id: 2 },
      { name: "Restaurantes de tercera",  id: 3 },
      { name: "Restaurantes de cuarta",  id: 4 }
  ];

  $scope.detalleComida = [
      { name: "Grill-room o Parrilla",  id: 0 },
      { name: "Buffet", id: 1 },
      { name: "Especialidades (Temáticos)",  id: 2 },
      { name: "Cocina Francesa",  id: 3 },
      { name: "Cocina Española",  id: 4 },
      { name: "Cocina Italiana",  id: 5 },
      { name: "Cocina Mexicana",  id: 6 },
      { name: "Cocina Colombiana",  id: 7 },
      { name: "Cocina Caribeña",  id: 8 },
      { name: "Fast Food",  id: 9 },
      { name: "Gourmet",  id: 10 },
      { name: "Take Away",  id: 11 },
     
  ];


  $scope.button = "Guardar";

  $scope.modernBrowsers = [
    { name: "Desayuno", value: 0, maker: "(Desayuno)", ticked: false  },
    { name: "Almuerzo", value: 1, maker: "(Almuerzo)", ticked: false },
    { name: "Comida", value: 2, maker: "(Comida)", ticked: false  },
    { name: "Salon Eventos", value: 3,  maker: "(Salon)", ticked: false },
    { name: "Domicilios", value: 4, maker: "(Domicilios)", ticked: false  },
    { name: "Wifi", value: 5, maker: "(Wifi)", ticked: false  },
    { name: "TDC", value: 6, maker: "(TDC)", ticked: false  },
    { name: "Bebidas y Jugos", value: 7, maker: "(bebidas)", ticked: false  },
    { name: "Bebidas Alcoholicas", value: 8, maker: "(alcoholicas)", ticked: false  },
    { name: "Reservas", value: 9, maker: "(Reservas)", ticked: false  },
    { name: "Salón Privado", value: 10, maker: "(privado)", ticked: false  }
   
]; 

  $scope.modernBrowsers2 = [
    { name: "Carnes y Derivados", value: 0, maker: "(carnes)", ticked: false  },
    { name: "Pescados y Mariscos", value: 1, maker: "(Almuerzo)", ticked: false },
    { name: "Frutos Secos", value: 2, maker: "(Secos)", ticked: false  },
    { name: "Frutos y verduras", value: 3,  maker: "(Frutos)", ticked: false },
    { name: "Lácteos y Derivados", value: 4, maker: "(Lacteos)", ticked: false  },
    { name: "Legumbres", value: 5, maker: "(Legumbres)", ticked: false  },
    { name: "Cereales", value: 6, maker: "(Cereales)", ticked: false  }
   
  ]; 


  $scope.reporte = function() {

    $http({
        url: path + 'restaurante/reporteR',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.servicio = response.servicio;
       $scope.tipoRestaurante = response.tipoRestaurante;
       $scope.ver = true;
       //console.log($scope.tipoRestaurante);
       //console.log($scope.servicio);
      angular.forEach($scope.tipoRestaurante, function (value, key){
       
        $scope.data.push(value.cantidad);


      });
      //console.log($scope.data);    
        $scope.dataIngreso = {//BAR CHART ?????????????
        labels: [""],
        datasets: $scope.data
      };
       
    //  $scope.graficaNivelAcademico();
    //  $scope.cargarGrafica();

    });

    
  }

 $scope.all = function() {
   $http({
        url: path + 'restaurante/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.restaurantes = response.restaurante;
       $scope.cantidad = response.cantidad;
    });
  }
  $scope.cambiarButton = function(){
      $scope.button = "Guardar";
      $scope.restaurante = {};
  }
  $scope.limpiar = function(){
    angular.forEach($scope.modernBrowsers, function (value, key){
      value.ticked = false;
    });
    angular.forEach($scope.modernBrowsers2, function (value, key){
        value.ticked = false;
    });
  }
  $scope.guardar = function() {
  //console.log($scope.servicioSelect);
    $scope.restaurante.servicios =JSON.stringify($scope.outputBrowsers);
    $scope.restaurante.proteina =JSON.stringify($scope.outputBrowsers2);
    $scope.restaurante.lat = $scope.lat;
    $scope.restaurante.lng = $scope.lng;
   var route;
   if ($scope.button == "Guardar") {
    route = 'restaurante/create';
   }else{
    route = 'restaurante/update';
   }

    $http({
        url: path + route,
        method: 'get',
        params: $scope.restaurante,
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      
      $scope.restaurantes = response.restaurante;
      $scope.restaurante = {};
         $scope.outputBrowsers = [];
         $scope.outputBrowsers2 = [];
      angular.forEach($scope.modernBrowsers, function (value, key){
          value.ticked = false;
      });
      angular.forEach($scope.modernBrowsers2, function (value, key){
          value.ticked = false;
      });
      $scope.all();
    });
  }

  $scope.cargarRestaurante = function (restaurante){
   
    $scope.restaurante = restaurante;
    $scope.restaurante.telefono = parseInt(restaurante.telefono);
    $scope.tipoSelect = restaurante.tipoRestaurante;
    $scope.detalleSelect = restaurante.detalle;
    $scope.button ="Actualizar";
    $http({
          url: path + 'restaurante/buscar',
          method: 'get',
          params:{
            idRestaurante: $scope.restaurante.idRestaurante
          },
          headers: {
              "Content-Type": "application/json"
          }

    }).success(function (response) {
      
      $scope.servicioSelect = response.servicios;
      $scope.proteinas = response.proteinas;
      angular.forEach($scope.modernBrowsers, function (value, key){
        angular.forEach($scope.servicioSelect, function (value2, key){
          if (value.value == value2.valor) {
            value.ticked = true;
          }
        });
      });
      angular.forEach($scope.modernBrowsers2, function (value, key){
        angular.forEach($scope.proteinas, function (value2, key){
          if (value.value == value2.valor) {
            value.ticked = true;
          }
        });
      });
    });

  }

  $scope.eliminar = function(restaurante , index){
    $scope.restauranteSeleccionado = restaurante;
    $scope.index = index;
  }
  


  $scope.delete = function(){
    $http({
          url: path + 'restaurante/delete',
          method: 'get',
          params:{
            idRestaurante: $scope.restauranteSeleccionado.idRestaurante
          },
          headers: {
              "Content-Type": "application/json"
          }

    }).success(function (response) {
      
      if (response.error == false) {
        $scope.restaurantes.splice($scope.index,  1);
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
        $scope.all();
      };
      
    });
  }
     $scope.servicioSeleccionado = function(servicio){
      $scope.switch = false;
        if ($scope.servicioSelect.length == 0) {
           $scope.servicioSelect.push(servicio);

        }else{
            for (var i = $scope.servicioSelect.length - 1; i >= 0; i--){
                if ($scope.servicioSelect[i] == servicio) {
                   $scope.switch = true;

                   $scope.i = i;
                }else{
                  if ($scope.servicioSelect[i] != servicio) {
                      //$scope.empresaSelect.push(servicio);
                      $scope.switch = false;
                  }

                }
            }
            if ($scope.switch == false) {

              $scope.servicioSelect.push(servicio);
            }else{
              $scope.servicioSelect.splice(i , 1);
            }
        }
}



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
     // console.log(location.lat(), location.lng());
        var marker = new google.maps.Marker({
          position: location,
          map: $scope.map
        });
      // console.log(marker.getPosition());
        
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
//LLAMADAS
  $scope.all();
  $scope.reporte();

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
