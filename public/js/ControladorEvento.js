'use strict';
 
angular.module('myApp.Evento', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/evento', {
        templateUrl: 'pages/Evento/evento.html',
        controller: 'EventoCtrl'
    })
    .when('/detalle', {
        templateUrl: 'pages/Evento/detalleEvento.html',
        controller: 'EventoCtrl'
    });
}])
 
// Home controller
.controller('EventoCtrl', ['$http', '$scope', '$rootScope', '$timeout', function($http, $scope, $rootScope, $timeout) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  //console.log($rootScope.user);
  //declaracionde variables
  $scope.ver = false;
  var url = 'evento/guardarimagen';
  $scope.evento ={
    nombre:''
  };
  $scope.colores = [{'color': '#00EAB5'}, {'color' : '#FF6C00'}, {'color' : '#00ABF8'}, {'color' : '#F24B45'}, {'color' : '#D03B43'}, {'color' : '#AB313E'}, {'color' : '#503140'}, {'color' : '#322E3F'}];
  $scope.int = {};
  $scope.poblacion = {};
  $scope.swichPoblacion = false;
  $scope.aux={};
  $scope.mostrar = false;
  $scope.swichJunta = false;
  $scope.j = {};
  $scope.formJunta = {};
  $scope.swichActualizarJ = false;
  $rootScope.evento = {};
  $scope.cambio = 0;
  $scope.swichint = false;
  $scope.switchAsociacion = false;
  $scope.finish = false; //Cuando termine de agregar el evento.
  $scope.swichCargo = 0;
  $rootScope.filtroReporte = {
    poblacion: 0,
    organizadores: 0,
    actividades: 0,
    socioeconomica: 0,
    cultural: 0
  }

  /*----------------------DEFINIENDO SELECT'S-------------------------*/
    $scope.selectSexo = [
        { name: "Masculino",  id: 0 },
        { name: "Femenino", id: 1 }
    ];
    $scope.nivelAcademico = [
        { name: "Educación Media",  id: 0 },
        { name: "Técnico", id: 1 },
        { name: "Técnico Profesional", id: 2 },
        { name: "Tecnólogo", id: 3 },
        { name: "Profesional", id: 4 },
        { name: "Especialización", id: 5 },
        { name: "Maestría", id: 6 },
        { name: "Doctorado", id: 7 },
        { name: "Ninguno", id: 8 },
    ];
    /*----------------------FIN SELECT'S-------------------------*/
  /*----------------WIZARD--------------------------------------------------*/
  /*$timeout(function () {
      $("#wizard").steps({
        onInit: function (event, currentIndex) { 
          //alert('onInit');
          $scope.mostrar = true;
        },
        onStepChanged: function (event, currentIndex, priorIndex) { 
          //alert('onStepChanged');
          $scope.filtrarCiudades();
        },
        onStepChanging: function (event, currentIndex, newIndex) { 
          
         if (currentIndex == 0) {
           var nombre = $('#nombre').val();
           var departamento = $('#departamento').val();
           var region = $('#region').val();
           var nit = $('#nit').val();
           var codigo = $('#codigo').val();

          if(nombre === '' || departamento === '' || region === '' || nit === '' || codigo === '' ){
            return false;
          }
         }else{
          if (currentIndex == 1) {
            var ciudad = $('#ciudad').val();
            var direccion = $('#direccion').val();
            var telefono = $('#telefono').val();
            var correo = $('#correo').val();

          if(ciudad === '' || direccion === '' || telefono === '' || correo === '' ){
            return false;
          }

          }else{
            if (currentIndex == 2) {
              var fundado = $('#fundado').val();
              var version = $('#version').val();
              var poblacion = $('#poblacion').val();
              var inicio = $('#inicio').val();
              var fin = $('#fin').val();
              var dias = $('#dias').val();

              if(fundado === '' || version === '' || poblacion === '' || inicio === '' || fin === '' || dias === '' ){
               return false;
              }
            }
          }
         } 
          return true;
        },
        onFinished: function (event, currentIndex) {
          $('#myModal').modal('hide');
          $scope.evento.nombre = document.getElementById("nombre").value;
          $scope.aux = JSON.parse(document.getElementById("departamento").value);
          $scope.evento.departamento = $scope.aux.idDepartamento;
          $scope.aux = JSON.parse(document.getElementById("region").value);
          $scope.evento.region = $scope.aux.idRegion;
          $scope.evento.nit = parseInt(document.getElementById("nit").value);  
          $scope.evento.codigo = parseInt(document.getElementById("codigo").value);
          $scope.aux = JSON.parse(document.getElementById("ciudad").value);
          $scope.evento.ciudad = $scope.aux.idCiudad;
          $scope.evento.direccion = document.getElementById("direccion").value;
          $scope.evento.telefono = parseInt(document.getElementById("telefono").value);
          $scope.evento.telefono2 = parseInt(document.getElementById("telefono2").value);
          $scope.evento.correo = document.getElementById("correo").value;
          $scope.evento.correo2 = document.getElementById("correo2").value;
          $scope.evento.fundado = document.getElementById("fundado").value;
          $scope.evento.version = document.getElementById("version").value;
          $scope.evento.poblacion = parseInt(document.getElementById("poblacion").value);
          $scope.evento.inicio = document.getElementById("inicio").value;
          $scope.evento.fin = document.getElementById("fin").value;
          $scope.evento.poblacionCirculante = parseInt(document.getElementById("poblacionCirculante").value);
          $scope.evento.web = document.getElementById("web").value;
          $scope.evento.facebook = document.getElementById("facebook").value;
          $scope.evento.instagram = document.getElementById("instagram").value;
          $scope.evento.twitter = document.getElementById("twitter").value;
          $scope.evento.pass = document.getElementById("pass").value;
          $scope.evento.otro = document.getElementById("otro").value;
          $scope.evento.imagen = document.getElementById("file").files[0];
          $scope.imagen = document.getElementById("file").files[0];
          $scope.guardar();
          //$scope.all();
          //console.log($scope.evento);

        },
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft"
      });
  }, 2000);*/

  /*---------------------------------------REPORTE------------------------------*/

  $scope.verReporte = function(evento){
    //console.log($rootScope.filtroReporte);
    $rootScope.filtroReporte.poblacion = 1;
    $rootScope.filtroReporte.organizadores = 1;
    $rootScope.filtroReporte.actividades = 1;
    $rootScope.filtroReporte.socioeconomica = 1;
    $rootScope.filtroReporte.cultural = 1;
    $rootScope.evento = evento;
    window.location.href= '#/reporte';
  }

  /*---------------------------------------detalles--------------------------------------*/

  $scope.verificaLugar = function(){
    if (!$rootScope.detalle) {
      window.location.href= '#/evento'   
    }else{
      $scope.verDetalle($rootScope.detalle);
    }
  }

  $scope.verDetalle = function(evento){
    $scope.ver = false;
    $rootScope.detalle = evento;
    $rootScope.detalle.fundado = new Date($rootScope.detalle.fundado);
    $rootScope.detalle.fechaInicio = new Date($rootScope.detalle.fechaInicio);
    $rootScope.detalle.fechaFin = new Date($rootScope.detalle.fechaFin);
  //  console.log($rootScope.detalle);
    window.location.href = '#/detalle';

    $scope.buscarActividades();
  }

  $scope.buscarActividades = function(){
    //trae todas las actividades por evento
    //alert('1');
    $http({
        url: path + 'actividad/evento',
        method: 'get',
        params:{
          idEvento: $rootScope.detalle.idEvento //aqui se supone va el id del evento seleccionado 
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //alert('2');
      $scope.actividades = response.actividad;
      $scope.ver = true;
      $scope.initMap2();
    });

    //buscar totales
    $http({
        url: path + 'act/reporte',
        method: 'get',
        params:{
          idEvento: $rootScope.detalle.idEvento //aqui se supone va el id del evento seleccionado 
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.totalActividades = response.total;
    // console.log($scope.totalActividades);
      
    });
    
  }

  $scope.actualizardetalle = function(){
    
    $http({
        url: path + 'evento/update',
        method: 'get',
        params: $scope.detalle,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
    });
  }

  $scope.editar = function(){

    if ($scope.cambio == 0) {
      $scope.cambio = 1;
    }else{
      $scope.cambio = 0;
    }
    
  }

  /*----------------------MAPA-------------------------*/
  $scope.map;
  $scope.markers = [];

  $scope.initMap = function() {
      var haightAshbury = {lat: 10.4742449, lng: -73.2436335};

      //var haightAshbury = {lat: 37.769, lng: -122.446};

       $scope.map = new google.maps.Map(document.getElementById('map2'), {
          zoom: 14,
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

  var map2;
  var markers2 = [];
  $scope.initMap2 = function() {
      //alert('3');
      //console.log($scope.actividades);
      if ($scope.actividades[0]) {
        var haightAshbury = {lat: parseFloat($scope.actividades[0].direccion.lat), lng: parseFloat($scope.actividades[0].direccion.lng)};
      }else{
        var haightAshbury = {lat: 10.4742449, lng: -73.2436335};  
      }
      

      //var haightAshbury = {lat: 37.769, lng: -122.446};

        map2 = new google.maps.Map(document.getElementById('map3'), {
          zoom: 14,
          center: haightAshbury,
          mapTypeId: 'terrain'
        });

        for (var i = $scope.actividades.length - 1; i >= 0; i--) {
          var pos = {lat: parseFloat($scope.actividades[i].direccion.lat), lng: parseFloat($scope.actividades[i].direccion.lng)};
          $scope.addMarker2(pos, $scope.actividades[i].nombre, $scope.actividades[i].direccion.direccion);
        }
    
  }

  $scope.addMarker2 = function(location, nombre, direccion) {

         var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">'+nombre+'</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Dirección:</b>' +direccion+
            '</p>'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var marker = new google.maps.Marker({
          position: location,
          map: map2
        });
        marker.addListener('click', function() {
          infowindow.open(map2, marker);
        });
        markers2.push(marker);
    }

  // Adds a marker to the map and push to the array.
  $scope.addMarker = function(location) {
    $scope.lat = location.lat();
    $scope.lng = location.lng();
    var marker = new google.maps.Marker({
      position: location,
      map: $scope.map
    });
    $scope.markers.push(marker);
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

  /*------------------------------sitios de interes---------------------------------------*/

  $scope.allInteres = function(){
    $http({
        url: path + 'evento/info',
        method: 'get',
        params: {
          idEvento: $rootScope.detalle.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.interes = response.info;
    });
  }

  $scope.nuevoInteres = function(){
    $scope.swichint = true;
  }

  $scope.guardarInteres = function(){
    $scope.int.idEvento = $rootScope.detalle.idEvento;
    $scope.int.lat = $scope.lat;
    $scope.int.lng = $scope.lng;

    $http({
        url: path + 'interes/create',
        method: 'get',
        params: $scope.int,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.interes = response.info;
      //para que busque todos los sitios de interes nuevamente

      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);

      $scope.allInteres();
      //para que se devuelva a la vista 
      $scope.swichint = false;
    });
  }

  $scope.seleccionarInteres = function(id){
    $scope.idInteres = id;
  }

  $scope.eliminarInteres = function(){
    $http({
        url: path + 'interes/delete',
        method: 'get',
        params:{
          idInfo: $scope.idInteres
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.allInteres();
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      
    });
  }
  $scope.atras = function(){
    $scope.swichint = false;
  }
 /*-----------------------------------------------reporte---------------------------------*/
  $scope.filtrarReporte = function(tipo){
    if (tipo == 1) {//Crecion
      if ($rootScope.filtroReporte.poblacion == 0) {
        $rootScope.filtroReporte.poblacion = 1;
      }else{
        $rootScope.filtroReporte.poblacion = 0;
      }

    }else{
      if(tipo == 2){//organizadores
        if ($rootScope.filtroReporte.organizadores == 0) {
          $rootScope.filtroReporte.organizadores = 1;
        }else{
          $rootScope.filtroReporte.organizadores = 0;
        }

      }else{
        if (tipo == 3) {//actividades
          if ($rootScope.filtroReporte.actividades == 0) {
            $rootScope.filtroReporte.actividades = 1;
          }else{
            $rootScope.filtroReporte.actividades = 0;
          }

        }else{
          if (tipo == 4) {//socioeconomica
            if ($rootScope.filtroReporte.socioeconomica == 0) {
              $rootScope.filtroReporte.socioeconomica = 1;
            }else{
              $rootScope.filtroReporte.socioeconomica = 0;
            }

          }else{//cultural
            if ($rootScope.filtroReporte.cultural == 0) {
              $rootScope.filtroReporte.cultural = 1;
            }else{
              $rootScope.filtroReporte.cultural = 0;
            }

          }
        }
      }
    }
  }
  
  /*---------------------------cuando pasa de pantalla-------------------------*/
  $scope.paso = function(evento){
    $rootScope.evento = evento;
  }

  /*----------------------POBLACION--------------------------------------*/

  //busca la poblacio del evento
  $scope.buscarPoblacion = function(id){
    $scope.idEvento = id;
    $http({
        url: path + 'pobla/buscar',
        method: 'get',
        params: {
          idEvento: id
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.poblacion = response.poblacion;
      if ($scope.poblacion.length == 0) {
        $scope.swichPoblacion = true;
      }else{
        $scope.swichPoblacion = false;
      }

    });
  };


  //crear poblacion
  $scope.crearPoblacion = function(){
    $scope.poblacion.idEvento = $scope.idEvento;
    $http({
        url: path + 'pobla/create',
        method: 'get',
        params:$scope.poblacion,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.poblacio = response.poblacion;
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      //console.log($scope.poblacio);
    });
  };

  //actulizar poblacion
  $scope.updatePoblacion = function(){
    $http({
        url: path + 'pobla/update',
        method: 'get',
        params: $scope.poblacion,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.poblacion = response.poblacion;
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      //console.log($scope.poblacion);
    });
  };



  /*-----------------------FIN DE LA POBLACION----------------------------*/


  //------------------------JUNTA DIRECTIVA-----------------------

  //muestra los datos de la junta
  $scope.nuevaJunta = function(){
    //muestra el formulario para crear un nuevo integrante a la junta directiva
    if ($scope.swichJunta) {
      $scope.swichJunta = false;
      $scope.swichActualizarJ = false;
    }else{
      $scope.swichJunta = true;
      $scope.j = {};
      $scope.swichActualizarJ = false;
    }
    
  }

  //editar un integrante de la junta directiva
  $scope.editarIJ =  function(integrante){
 // console.log(integrante);
    integrante.fechaNac = new Date(integrante.fechaNac);
    integrante.telefono = parseInt(integrante.telefono);
    $scope.sexoS = integrante.sexo;
    $scope.j.sexo = integrante.sexo;
    $scope.nivelS = integrante.nivel;
    $scope.j.nivel = integrante.nivel;
    $scope.cargoS = integrante.cargo;
    //$scope.j.nivel = integrante.nivel;
    $scope.j = integrante;
    $scope.swichJunta = true;
    $scope.swichActualizarJ = true;
  }

  //actualiza los datos del integrante de la junta directiva
  $scope.actualizarIJ = function(){
    $http({
        url: path + 'junta/update',
        method: 'get',
        params: $scope.j,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      $scope.editarJunta($scope.eventoSeleccionado);
      $scope.swichJunta = false;
    });
  };

  $scope.seleccionaJunta = function(idJunta){
    $scope.idJunta = idJunta;
  }

  

  $scope.eliminarIJ = function(){
   
      $http({
          url: path + 'junta/delete',
          method: 'get',
          params: {
            idJunta: $scope.idJunta
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.editarJunta($scope.eventoSeleccionado);
        //$scope.swichJunta = false;
      });
    
  }

  //trae los datos del evento seleccionado y la junta directiva asociada a ese evento
  $scope.editarJunta = function(evento){
    $scope.eventoSeleccionado = evento;
    //console.log($scope.eventoSeleccionado);
    $http({
        url: path + 'junta/all',
        method: 'get',
        params:{
          idEvento: evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.junta = response.junta;
      $scope.cargos = response.cargos;
      if ($scope.cargos[0]) {
        $scope.swichCargo = 0;
      }else{
        $scope.swichCargo = 2;
      }
    });
  }

  $scope.cambiaCargo = function(){
    if ($scope.swichCargo == 0) {
      $scope.swichCargo = 1;
    }else{
      $scope.swichCargo = 0;  
    }
    
  }

  //crea un nuevo integrante en la junta directiva
  $scope.nuevoIntegrante  = function(){
    $scope.j.idEvento = $scope.eventoSeleccionado.idEvento;
    if ($scope.swichCargo == 1 || $scope.swichCargo == 2) {
      $http({
          url: path + 'cargo/create',
          method: 'get',
          params:{
            idEvento: $scope.j.idEvento,
            nombre: $scope.j.cargo
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.j.idCargo = response.cargo.idCargo;
        $scope.guardarIntegrante();
      });
    }else{
      $scope.guardarIntegrante();
    }
  }

  $scope.guardarIntegrante = function(){
    $http({
        url: path + 'junta/create',
        method: 'get',
        params: $scope.j,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.junta = response.junta;
      //console.log($scope.junta);
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      $scope.editarJunta($scope.eventoSeleccionado);
      $scope.swichJunta = false;
    });
  }

  //----------------------FIN DE LA JUNTA DIRECTIVA--------------


  //filtra las ciudades despues que se selecciona un departamento
  $scope.filtrarCiudades = function(){
    
    $scope.depar = JSON.parse(document.getElementById("departamento").value);
    //console.log($scope.depar);
    $http({
        url: path + 'ciudad/all',
        method: 'get',
        params:{
          idDepartamento: $scope.depar.idDepartamento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.ciudades = response.ciudades;
      //console.log($scope.ciudades);
    });
  }
  
  /*$scope.convertirFecha = function(fecha){
    $scope.ano = fecha.getFullYear();
    $scope.dia = fecha.getDay() + 1;
    $scope.mes = fecha.getMonth() + 1;
    $scope.fecha = $scope.ano.toString() + '-' + $scope.mes.toString() + '-' + $scope.dia.toString();
    //console.log($scope.ano, $scope.mes, $scope.dia, $scope.fecha);
    return $scope.fecha;
  }*/

  //-----------------------------EVENTO--------------------------------------
  //eliminar los eventos
  $scope.eliminarEvento = function(){
   
      $http({
          url: path + 'evento/delete',
          method: 'get',
          params: {
            idEvento : $scope.idSelect
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.all();
        $('#myModal2').modal('show'); // abrir
          setTimeout(function(){
            $('#myModal2').modal('hide');
        },2000);
        
      }); 
  }

  $scope.guardar = function(){
    //alert('g');
    console.log($scope.evento);
    var url = "";
    url = 'evento/create';
    //convertir formato de fecha para el servidor
    //$scope.evento.fechaInicio2 = $scope.convertirFecha($scope.evento.fechaInicio);
    //$scope.evento.fechaFin2 = $scope.convertirFecha($scope.evento.fechaFin);
    //$scope.evento.fundado2 = $scope.convertirFecha($scope.evento.fundado);

    //convertir en json y pasar los id
    /*$scope.aux = JSON.parse($scope.evento.departamento);
    $scope.evento.departamento = $scope.aux.idDepartamento;
    $scope.aux = JSON.parse($scope.evento.region);
    $scope.evento.region = $scope.aux.idRegion;
    $scope.aux = JSON.parse($scope.evento.ciudad);
    $scope.evento.ciudad = $scope.aux.idCiudad;*/
    //meter el id del usuario
    $scope.evento.usuario = $rootScope.user.idUsuario;
    //insertar

      var fd = new FormData();
      fd.append('file', $scope.evento.imagen);
      fd.append('evento', JSON.stringify( $scope.evento));
      //console.log(fd);
      $http.post(path + url, fd, {
        transformRequest: angular.identity,
        headers: {'Content-Type': undefined}
      }).success(function(response){
      
      //$scope.evento = response.evento;
      //llamar a todos los eventos para que salga en la lista
      $scope.all();
      
      $('#myModal2').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal2').modal('hide');
      },2000);
      
      if (response.error == false) {
       // alert(response.mensaje);
        $scope.finish = true;
      }
     })
    .error(function(response){
      //$scope.all();
    });
  }

  $scope.all = function(){
    //todos los departamentos
    //alert('d');
    $scope.totalesFuncion();

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
    //todos los eventos
    $http({
        url: path + 'evento/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.eventos = response.eventos;
      //console.log($scope.eventos);
      $scope.ver = true;
    });
    $scope.totalBox();
  }
  //Trae el total de los box
  $scope.totalBox = function(){
    $http({
        url: path + 'evento/total',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.total = response.total;
    }); 
  }

//trae los totales de los tipos de actividad
  $scope.totalesFuncion = function(){
    $http({
        url: path + 'evento/reportetipo',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.totales = response.totales;
      //console.log($scope.totales);
     // $scope.labels = ["Sin valor comercial", "Con boleta de ingreso", "Con valor comercial"];
     // $scope.data = [$scope.total.sinvalor, $scope.total.conboleta, $scope.total.convalor];
      //console.log($scope.total);
    }); 
  }
  //se filtra por departamento o todos los eventos el listado y los totales
  $scope.filtrar = function(dep){
    if (dep == 0) {
      $scope.all();
    }else{
      $http({
          url: path + 'evento/totaldep',
          method: 'get',
          params:{
            idDepartamento: dep
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.eventos = response.eventos;
        $scope.total = response.total;
        $scope.labels = ["Sin valor comercial", "Con boleta de ingreso", "Con valor comercial"];
        $scope.data = [$scope.total.sinvalor, $scope.total.conboleta, $scope.total.convalor];
      //  console.log($scope.eventos);
      });
    }
  }

  $scope.buscarCiudades = function(idDepartamento){
    //alert('jhdgd');
   // console.log(idDepartamento);
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
    });
  }

  $scope.eliminarAsociacion = function(p, index){
      var respuesta =  confirm('¿Seguro que desea eliminar esta asociación?');
    if (respuesta) {
      $http({
          url: path + 'asociacion/delete',
          method: 'get',
          params:{
            idParticipa: p.idParticipa
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        alert(response.mensaje);
        $scope.participantesA.splice(index , 1);
      });

    }
  
  }

  $scope.actualizarEvento = function(){

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

  $scope.guardarAsociacion = function(participante){
 
    $http({//Guardar Asociacion
        url: path + 'asociacion/guardar',
        method: 'get',
        params:{
          participante: participante,
          actividad :  $scope.selectact,
          tipo: $scope.tipoS
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.allSub();

  });
  }

  $scope.allSub = function(){
    
    $http({//Guardar Asociacion
        url: path + 'asociacion/Allsub',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.participantesA = response.participantesA;
  });
  }
  //Asociacion de los participantes
  $scope.buscarParticipante = function(tipo){
  $http({//Participantes a los que se asociaran
        url: path + 'participante/tipo',
        method: 'get',
        params:{
          tipo: tipo
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.participantes = response.participante;
  });
}
  $scope.allAsociacion = function(evento){
      $http({//Trae las actividades de un evento, con sus subactividades y premio
        url: path + 'asociacion/all',
        method: 'get',
        params:{
          idEvento: evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.asociacion = response.actividades;
     // console.log($scope.asociacion);
    });
  }

  $scope.seleccionaridEvento = function(id){
    $scope.idSelect = id;
  }

  $scope.selectActividad = function(a){
 
      if ($scope.switchAsociacion == false) {
        $scope.switchAsociacion = true;
        $scope.selectact = a.subactividad;
      }else{
        $scope.switchAsociacion = false;
      }
  }
  $scope.aggParticipante = function(tipoS , evento){
    
      $scope.tipoS = tipoS;
      if ($scope.switchParticipante == false) {
        $scope.switchParticipante = true;
      }else{
        $scope.participantesA = {};
        $scope.switchParticipante = false;

      }
  }

  $scope.buscarDepartamento = function() {
    $http({
        url: path + 'departamento/buscar',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.depEventos = response.departamentos;
  
    });
  }


  $scope.limpiarForm = function(){
   
    document.getElementById("file").value = "";
  }
  $scope.guardarImagen = function(imagen){

      imagen = document.getElementById("file").files[0];
      var file = imagen;
      var fd = new FormData();
      fd.append('file', file);
      fd.append('idEvento', $rootScope.detalle.idEvento);
      $http.post(path + url, fd, {
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined}
       }).success(function(response){
         $rootScope.detalle.imagen = response.evento.imagen;
         $('#myModal5').modal('show'); // abrir
           setTimeout(function(){
         $('#myModal5').modal('hide');
          },2000);
       })
      .error(function(response){

      });
  }

  
  //llamadas 
  $scope.all();
  $scope.buscarDepartamento();
  $scope.totalBox();



}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
