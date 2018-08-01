'use strict';
 
angular.module('myApp.Hotel', ['ngRoute' ,'isteven-multi-select'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/hotel', {
        templateUrl: 'pages/Hotel/hotel.html',
        controller: 'HotelCtrl'
    });
}])

// Home controller
.controller('HotelCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope , DTOptionsBuilder, DTColumnDefBuilder) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  $scope.hotel = {};
  $scope.ver = false;
  $scope.switchHotel = false;
  $scope.swichActualizarH = false;
  $scope.reporte = {};
  $scope.button = 'Guardar';
  $scope.colores = [{'color': '#00EAB5'}, {'color' : '#FF6C00'}, {'color' : '#00ABF8'}, {'color' : '#F24B45'}, {'color' : '#D03B43'}, {'color' : '#AB313E'}, {'color' : '#503140'}, {'color' : '#322E3F'}];
  $scope.modernBrowsers = [
    { name: "Rtn", value: 0, maker: "(Rtn)", ticked: false  },
    { name: "Parqueadero", value: 1, maker: "(Parqueadero)", ticked: false },
    { name: "Aire", value: 2, maker: "(Aire)", ticked: false  },
    { name: "Tv", value: 3,  maker: "(Tv)", ticked: false },
    { name: "Jardin", value: 4, maker: "(Jardin)", ticked: false  },
    { name: "Artesanía", value: 5, maker: "(Artesania)", ticked: false  },
    { name: "Wifi", value: 6, maker: "(Wifi)", ticked: false  },
    { name: "Lavandería", value: 7, maker: "(Lavanderia)", ticked: false  },
    { name: "Piscina", value: 8, maker: "(Piscina)", ticked: false  },
    { name: "Bar", value: 9, maker: "(Bar)", ticked: false  },
    { name: "Room Service", value: 10, maker: "(roomservice)", ticked: false  },
    { name: "Restaurante", value: 11, maker: "(restaurante)", ticked: false  },
    { name: "Gimnasio", value: 12, maker: "(gimnasio)", ticked: false  },
    { name: "Areas Sociales", value: 13, maker: "(areasociales)", ticked: false  },
    { name: "Llamadas Gratis", value: 14, maker: "(llamadasgratis)", ticked: false  },
    { name: "Vip Area Social", value: 15, maker: "(vip area social)", ticked: false  },
    { name: "Salón de Eventos", value: 16, maker: "(salon eventos)", ticked: false  },
    { name: "Tripavisor", value: 17, maker: "(tripavisor)", ticked: false  },
]; 

$scope.categoriaHotel = [
      { name: "Hotel",  id: 0 },
      { name: "Apartamentos y Suites", id: 1 },
      { name: "Hostal",  id: 2 },
      { name: "Residencia",  id: 3 },
      { name: "Casas",  id: 4 },
      { name: "Hotel Boutique",  id: 5 },
      { name: "Complejo",  id: 6 },
      { name: "Fincas",  id: 7 },
      { name: "Posada",  id: 8 },
      { name: "Centro Turístico",  id: 9 },
];

  $scope.cantParqueaderos ={
      width: '0%'
  };
  $scope.cantAire ={
      width: '0%'
  };
  $scope.cantTv ={
      width: '0%'
  };
  $scope.cantJardin ={
      width: '0%'
  };
  $scope.cantArtesania ={
      width: '0%'
  };
  $scope.cantWifi ={
      width: '0%'
  };
  $scope.cantLavanderia ={
      width: '0%'
  };
  $scope.cantPiscina ={
      width: '0%'
  };
  $scope.cantBar ={
      width: '0%'
  };
  $scope.cantRoomservice ={
      width: '0%'
  };
  $scope.cantRestaurante ={
      width: '0%'
  };
  $scope.cantGimnasio ={
      width: '0%'
  };
  $scope.cantllamada ={
      width: '0%'
  };
  $scope.cantVip ={
      width: '0%'
  };
  $scope.cantSocial ={
      width: '0%'
  };

  


$scope.All = function(){
     $http({
        url: path + 'hotel/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.hoteles = response.hotel;
      $scope.reporte = response.reporte;
      $scope.categoria = response.categoria;
      $scope.ver = true;

      
      $scope.cantParqueaderos={
        width: $scope.reporte.cantParqueaderos + '%'
      };
      $scope.cantAire ={
        width: $scope.reporte.cantAire + '%'
      };
      
      $scope.cantTv ={
        width: $scope.reporte.cantTv + '%'
      };

      $scope.cantJardin ={
        width: $scope.reporte.cantJardin + '%'
      };

      $scope.cantArtesania  ={
        width: $scope.reporte.cantArtesania + '%'
      };
      
      $scope.cantWifi ={
        width: $scope.reporte.cantWifi + '%'
      };

      $scope.cantLavanderia ={
        width: $scope.reporte.cantLavanderia + '%'
      };

      $scope.cantPiscina  ={
        width: $scope.reporte.cantPiscina + '%'
      };

      $scope.cantBar ={
        width: $scope.reporte.cantBar + '%'
      };

      $scope.cantRoomservice ={
        width: $scope.reporte.cantRoomservice + '%'
      };
      $scope.cantRestaurante ={
        width: $scope.reporte.cantRestaurante + '%'
      };     
      $scope.cantGimnasio ={
        width: $scope.reporte.cantGimnasio + '%'
      };     

      $scope.cantllamada ={
        width: $scope.reporte.cantllamada + '%'
      };     
      $scope.cantVip ={
        width: $scope.reporte.cantVip + '%'
      };     
      
      $scope.cantSocial  ={
        width: $scope.reporte.cantSocial + '%'
      }; 

    });
  }


    $scope.guardarHotel = function(){
     $scope.hotel.datos =JSON.stringify($scope.outputBrowsers);
     $scope.hotel.lat = $scope.lat;
     $scope.hotel.lng = $scope.lng;
     var route;
     if ($scope.button == "Guardar") {
      route = 'hotel/create';
     }else{
      route = 'hotel/update';
     }
      $http({
          url: path + route,
          method: 'get',
          params: $scope.hotel,
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.All();
          $('#myModal5').modal('show'); // abrir
          setTimeout(function(){
            $('#myModal5').modal('hide');
          },2000);
          $scope.All();
        
      });
    }

    $scope.eliminar = function(hotel , index){
      $scope.hotelSeleccionado = hotel;
      $scope.index;
    }

    $scope.delete = function(){
        $http({
          url: path + 'hotel/delete',
          method: 'get',
          params:{
            idHotel: $scope.hotelSeleccionado.idHotel
          },
          headers: {
              "Content-Type": "application/json"
          }

        }).success(function (response) {
          
          if (response.error == false) {
            $scope.hoteles.splice($scope.index,  1);
            $('#myModal5').modal('show'); // abrir
            setTimeout(function(){
              $('#myModal5').modal('hide');
            },2000);
            $scope.All();
          };
          
        });
      
    }
  $scope.cambiarButton = function(){
      $scope.button = "Guardar";
      $scope.hotel = {};
      $scope.outputBrowsers = {};
  }

    
   $scope.cargarHotel = function (hotel){
    $scope.hotel = hotel;
    if ($scope.hotel.correo == "no") {
      $scope.hotel.correo = "";
    }
    $scope.hotel.telefono = parseInt(hotel.telefono);
    $scope.hotel.telefono2 = parseInt(hotel.telefono2);
    $scope.hotel.capacidadMax = parseInt(hotel.capacidadMax);
    $scope.hotel.habitaciones = parseInt(hotel.habitaciones);
    $scope.categoriaSelect = hotel.categoria;
    $scope.departamentoSelect = hotel.departamento;
    $scope.buscarCiudad($scope.departamentoSelect);
    $scope.ciudadSelect = hotel.ciudad;
    $scope.button ="Actualizar";
 
  }


    $scope.buscarCiudad = function(idDepartamento){
    $http({
        url: path + 'ciudad/all',
        method: 'get',
        params:{
          idDepartamento: idDepartamento //PRUEBA
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.ciudades = response.ciudades;
    //  console.log($scope.ciudades);
      
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
        var marker = new google.maps.Marker({
          position: location,
          map: $scope.map
        });
    //    console.log(marker.getPosition());
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
//LLAMADAS



 $scope.All();


 

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
