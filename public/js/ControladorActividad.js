'use strict';
 
angular.module('myApp.Actividad', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/actividad', {
        templateUrl: 'pages/Actividad/Actividad.html',
        controller: 'ActividadCtrl'
    });
}])

// Home controller
.controller('ActividadCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  if (!$rootScope.evento) {
    window.location.href = '#/evento';
  }
  $scope.ver = false;
  //console.log($rootScope.evento);
  //declaracion de variables
  $scope.swichPremio = false;
  $scope.swichPalco = false;
  $scope.swichsub = false;
  $scope.buttonNuevo = 0;  //Switch del modal de asociar para mostrar a los nuevos a asociar , en 0 muestra los asociados y en 1 los que no
  $scope.buttonPremio = 0;
  $scope.subEditar = false;//switch para editar la sub actividad
  $scope.tipoAsociacion = 0;
  $scope.tipousuarioSelect = 0;
  $scope.tipoUsuario = [
        { name: "Participantes",  id: 0 },
        { name: "Empresas", id: 1 },
        { name: "Agrupaciones",  id: 2 }
  ];
  $scope.prueba = [];
  $scope.swichActividad = false;
  $scope.contadorSiguiente = 0;
  $scope.titulo = 'Seleccione el tipo de actividad';
  $scope.actividad = {};
  $scope.actSeleccionada ={};
  $scope.sub = {};
  //los eventos internos de la actividad de tipo show
  $scope.eventoActividad = [{
    nombre:'',
    duracion:'',
    cantidad:''
  }];

  //los palcos internos de la actividad de tipo show
  $scope.palcoActividad = [{
    detalle: '',
    capacidad: '',
    cu:''
  }];

  $scope.palcoActividadAct = [{
    detalle: '',
    capacidad: '',
    cu:''
  }];

  //los premios y subsidio de la actividad d tipo concurso
  $scope.premioActividad = [{
    detalle: '',
    costo: ''
  }];

  $scope.tipoEvento = [
        { name: "Encuentros y Espectáculos Deportivos",  id: 0 },
        { name: "Eventos Religiosos", id: 1 },
        { name: "Congregaciones Políticas",  id: 2 },
        { name: "Conciertos y Presentaciones Musicales", id: 3 },
        { name: "Ferias, Festivales, Rodeos y Corralejas", id: 4 },
        { name: "Concursos", id: 10 },
        { name: "Congresos, Simposios, Seminarios o similares", id: 5 },
        { name: "Teatro",  id: 6 },
        { name: "Exhibiciones (Desfiles de Modas, Exposiciones, etc.)", id: 7 },
        { name: "Atracciones y Entretenimiento (Parques de Atracciones, Ciudades de Hierro, Circos, etc.)", id: 8 },
        { name: "Otros (Marchas, Ventas, etc.)", id: 9 }
  ];
  $scope.modalidadEvento = [
        { name: "Sin valor comercial",  id: 0 },
        { name: "Con boleta de ingreso", id: 1 },
        { name: "Con valor comercial",  id: 2 }
  ];
    $scope.participanteEvento = [
        { name: "Participante Natural",  id: 0 },
        { name: "Participante Juridico", id: 1 },
        { name: "Grupos Artísticos",  id: 2 }
  ];
  $scope.traeCheck = function(tipo){
    if (tipo == 1) {//tiene palcos
      if ($scope.swichPalco) {
        $scope.swichPalco = false;
      }else{
        $scope.swichPalco = true;
      }
    }else{//tiene premios 
      if ($scope.swichPremio) {
        $scope.swichPremio = false;
      }else{
        $scope.swichPremio = true; 
      }
    }
    
  }
  
  //swich de nueva sub actividad
  $scope.nuevaAct = function(){
    $scope.subEditar = false;    
    if ($scope.swichsub) {
      $scope.swichsub =false;
    }else{
      $scope.swichsub = true;
    }
    $scope.sub = {};
    $scope.palcoActividadAct = [{
      detalle: '',
      capacidad: '',
      cu:''
    }];
    
  };

  //llenar los datos de la sub actividad que se va a actualizar
  $scope.editarSub = function(actividad){
    $scope.swichsub = true;
    console.log(actividad);
    $scope.sub = actividad;
    $scope.tipoeventoSelect = actividad.tipo;
    $scope.modalidadSelect = actividad.modalidad;
    $scope.participanteeventoSelect = actividad.tipoPoblacion;
    if ($scope.sub.direccion) {
        //formatear la fecha
        $scope.sub.direccion.fechaInicio = new Date($scope.sub.direccion.fechaInicio);
        $scope.sub.direccion.fechaFin = new Date($scope.sub.direccion.fechaFin); 
      }

    $scope.subEditar = true;    
  };

  //limpiar formulario
  $scope.limpiarForm = function(){
    $scope.actividad = {};
  }

  $scope.cerrar = function(){
    $scope.swichsub =false;
  }

  //sleccionar una actividad
  $scope.seleccionarAct = function(act){
    $scope.actSeleccionada = act;
    
    $http({
          url: path + 'actividad/subact',
          method: 'get',
          params:{
            idActividad: $scope.actSeleccionada.idActividad
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.subActividades = response.actividad;
        console.log($scope.subActividades);
      });
  }

  //actualizar la sub actividad
  $scope.updateSub = function(){

    if ($scope.palcoActividadAct[0]) {
      //si agrego un nuevo palco
      $http({
          url: path + 'sub/palco',
          method: 'get',
          params: {
            idActividad: $scope.sub.idEventoActividad,
            palco: JSON.stringify($scope.palcoActividadAct)
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.palcoActividadAct =[];
         
      });

    }

    /*if ($scope.actividad.direccion) {
      $scope.actividad.direccion[0].fechaInicio = document.getElementById("myDate1U").value;
      $scope.actividad.direccion[0].fechaFin =document.getElementById("myDate2U").value;
    }*/
    console.log($scope.sub);
    $http({
        url: path + 'sub/update',
        method: 'get',
        params: {
          actividad: JSON.stringify($scope.sub)
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.swichsub = false;
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000); 
    });
    $scope.All();

  }

  //agrega otro premio a la actividad
  $scope.nuevoPremioActividad = function(){
    $scope.aux ={
      detalle: '',
      costo: ''
    };
    $scope.premioActividad.push($scope.aux);
  }


  //agrega otro palco a la actividad
  $scope.nuevoPalcoActividad =  function(){
    $scope.aux ={
      detalle: '',
      capacidad: '',
      cu:''
    };
    $scope.palcoActividad.push($scope.aux);
  }

  //agrega otro palco a la actividad cuandp se actualiza
  $scope.nuevoPalcoActividadAct =  function(){
    $scope.aux ={
      detalle: '',
      capacidad: '',
      cu:''
    };
    $scope.palcoActividadAct.push($scope.aux);
  }

  //agrega otro evento a la actividad
  $scope.nuevoEventoActividad = function(){
    $scope.aux ={
      nombre:'',
      duracion:'',
      cantidad:''
    }
    $scope.eventoActividad.push($scope.aux); 
  }

  //selecciona el tipo de actividad si es concurso o show
  $scope.tipoActividad = function(tipo){
    //si tipo == 0 es show y si es ==1 es concurso
    $scope.swichActividad =true;
    $scope.tipoAct = tipo;
    $scope.titulo = 'Información General';

  }
  //va guardoando los siguientes de la pantalla de insertar
  $scope.siguiente = function(){
    if ($scope.tipoAct == 0) {//si es tipo show
      $scope.contadorSiguiente++;
      if ($scope.contadorSiguiente == 1) {
        $scope.titulo = 'Información de los eventos internos';
      }else{
        if ($scope.contadorSiguiente == 2) {
          $scope.titulo = 'Información de los palcos';
        }else{
          $scope.titulo = 'Seleccione la ubicaión de la actividad en el mapa';
        }
      }
    }else{//si es concurso
      if($scope.contadorSiguiente == 0){
        $scope.contadorSiguiente++;
        $scope.titulo = 'Información de los Premios y subsidios';
      }else{//si es uno 
        $scope.contadorSiguiente = $scope.contadorSiguiente+2;
         $scope.titulo = 'Seleccione la ubicaión de la actividad en el mapa';
      }

    }
    
  }

  //va dando atras a la pantalla de insertar actividad
  $scope.atras = function(){
    if ($scope.contadorSiguiente == 0) {
      $scope.swichActividad=false;
      $scope.titulo = 'Seleccione el tipo de actividad';

    }else{
      if ($scope.tipoAct == 0) {// si es show
        $scope.contadorSiguiente--;
        if ($scope.contadorSiguiente == 1) {
          $scope.titulo = 'Información de los eventos internos';
        }else{
          if ($scope.contadorSiguiente == 2) {
            $scope.titulo = 'Información de los palcos';
          }else{
            if ($scope.contadorSiguiente == 3) {
              $scope.titulo = 'Seleccione la ubicaión de la actividad en el mapa'; 
            }else{
              $scope.titulo = 'Información General';
            }
            
          }
        }
      }else{//si es concurso
        if ($scope.contadorSiguiente == 1) {
          $scope.contadorSiguiente--;
          $scope.titulo = 'Información General';
        }else{
          $scope.contadorSiguiente = $scope.contadorSiguiente - 2;
          $scope.titulo = 'Información de los Premios y subsidios';
        }
      }
      
    }

  }

  $scope.cargarCalendario = function(){
    /* initialize the external events
     -----------------------------------------------------------------*/
    console.log($scope.calen);
    function ini_events(ele) {
      ele.each(function () {
              // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }

    ini_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    if ($scope.calen[0]) {
      var date = new Date($scope.calen[0].start);  
    }else{
      var date = new Date();
    }
    
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
      },
      //Random default events
      events: $scope.calen,
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar !!!
      drop: function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }

      }
    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });

  }

  
    $scope.buscarCiudad = function(idDepartamento){
      //alert("Entro");
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
        console.log($scope.ciudades);
        
      });
    }

    $scope.eliminar = function(idActividad){
      
        var resp = confirm("¿Está seguro que desea eliminar esta actividad?");
        if (resp == true) {
          $http({
              url: path + 'actividad/delete',
              method: 'get',
              params:{
                idActividad: idActividad
              },
              headers: {
                  "Content-Type": "application/json"
              }
          }).success(function (response) {
              alert(response.mensaje);
              $scope.All();
            
          });
        }

    }

    $scope.editarAct = function(act){
      $scope.actividad = act;
      if ($scope.actividad.direccion) {
        //formatear la fecha
        $scope.actividad.direccion[0].fechaInicio = new Date($scope.actividad.direccion[0].fechaInicio);
        $scope.actividad.direccion[0].fechaFin = new Date($scope.actividad.direccion[0].fechaFin); 
      }
      $scope.tipoSelect = $scope.actividad.tipo;
      $scope.modalidadSelect = $scope.actividad.modalidad;
      $scope.participanteSelect = $scope.actividad.tipoPoblacion;
      console.log( $scope.actividad);
    }

    $scope.actualizarAct = function(){

      if ($scope.palcoActividadAct[0]) {
        //si agrego un nuevo palco
        $http({
            url: path + 'act/palco',
            method: 'get',
            params: {
              idActividad: $scope.actividad.idActividad,
              palco: JSON.stringify($scope.palcoActividadAct)
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).success(function (response) {
          $scope.palcoActividadAct =[];
           $('#myModal5').modal('show'); // abrir
            setTimeout(function(){
              $('#myModal5').modal('hide');
            },2000);
          $scope.All();
        });

      }

      if ($scope.actividad.direccion) {
        $scope.actividad.direccion[0].fechaInicio = document.getElementById("myDate1U").value;
        $scope.actividad.direccion[0].fechaFin =document.getElementById("myDate2U").value;
      }
      console.log($scope.actividad);
      $http({
          url: path + 'act/update',
          method: 'get',
          params: {
            actividad: JSON.stringify($scope.actividad)
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        
      });
       $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
      $scope.All();

    }

    $scope.eliminarPalco = function(idPalco, index){
      
      $http({
          url: path + 'act/deletepalco',
          method: 'get',
          params: {
            idPalco: idPalco
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.actividad.palco.splice(index, 1);
      });
    }

    $scope.eliminarPalcoSub = function(idPalco, index){
      
      $http({
          url: path + 'sub/deletepalco',
          method: 'get',
          params: {
            idPalco: idPalco
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.sub.palco.splice(index, 1);
      });
    }


    $scope.eliminarPremio = function(idPremio, index){
      
      $http({
          url: path + 'act/deletepremio',
          method: 'get',
          params: {
            idPremio: idPremio
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.actividad.premioD.splice(index, 1);
        $scope.cambio = response.cambio;
        if ($scope.cambio == 1) {
          $scope.actividad.premio = 0;
        }
      });
    }

    $scope.guardar = function(){
      //Auxiliares de las variables con input con puntos
  /*    $scope.costoAux = $scope.costoAux.replace(/\./g,'');
      $scope.costoAux = parseInt($scope.costoAux);
      $scope.actividad.costo = $scope.costoAux;
      $scope.poblacionAux = $scope.poblacionAux.replace(/\./g,'');
      $scope.poblacionAux = parseInt($scope.poblacionAux);
      $scope.actividad.poblacion = $scope.poblacionAux;*/

      if ($scope.swichPalco == true) {//osea que si es tipo show meto eventos y palcos
        //$scope.actividad.evento = JSON.stringify($scope.eventoActividad);
        $scope.actividad.lugar = 1;
        $scope.actividad.palco = JSON.stringify($scope.palcoActividad);
      }else{
        $scope.actividad.lugar = 0;
      }
      if ($scope.swichPremio == true){// si no meto los premios porque se supone que es tipo concurso
        $scope.actividad.p = 1;
        $scope.actividad.premio = JSON.stringify($scope.premioActividad);
      }else{
        $scope.actividad.p = 0;
      }
      //ejemplo mientras pongo el mapa :D
      $scope.actividad.lat = $scope.lat;
      $scope.actividad.lng = $scope.lng;
    //  var value = element(by.binding( $scope.actividad.fechaInicio | date: "yyyy-MM-ddTHH:mm:ss"));
      $scope.actividad.idEvento = $rootScope.evento.idEvento; //id del evento al cual pertecen las actividades 
      console.log($scope.actividad);

    if ( $("#myDate1").length > 0 && $("#myDate2").length) {
      $scope.fechaInicio = document.getElementById("myDate1").value;
      $scope.fechaFin = document.getElementById("myDate2").value;
    }
      $http({
          url: path + 'actividad/create',
          method: 'get',
          params: {
            actividad: $scope.actividad,
            fechaInicio:$scope.fechaInicio,
            fechaFin: $scope.fechaFin 
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.actividad = response.actividad;
        console.log($scope.actividad);
        $scope.swichPremio = false;
        $scope.swichPalco = false;

        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);

        $scope.markers = [];
        $scope.All();

        $scope.swichActividad = false;
        $scope.contadorSiguiente = 0;
        $scope.titulo = 'Seleccione el tipo de actividad';
        $scope.actividad = {};
        //los eventos internos de la actividad de tipo show
        $scope.eventoActividad = [{
          nombre:'',
          duracion:'',
          cantidad:''
        }];

        //los palcos internos de la actividad de tipo show
        $scope.palcoActividad = [{
          detalle: '',
          capacidad: '',
          cu:''
        }];

        //los premios y subsidio de la actividad d tipo concurso
        $scope.premioActividad = [{
          detalle: '',
          costo: ''
        }];

        
      });
      $scope.All();
      
    }

    //GUARDAR SUB ACRITIVIDAD
    $scope.guardarSub = function(){
      
      $scope.swichsub = false;
      if ($scope.actSeleccionada.lugar == 0) {//osea que si tiene dierccion
        $scope.sub.palco = JSON.stringify($scope.palcoActividadAct);
      }
      
      //ejemplo mientras pongo el mapa :D
      $scope.sub.lat = $scope.lat;
      $scope.sub.lng = $scope.lng;
      $scope.sub.lugar = $scope.actSeleccionada.lugar;
     
      $scope.sub.idActividad = $scope.actSeleccionada.idActividad; //id del evento al cual pertecen las actividades 
      console.log($scope.sub);

      if ( $("#myDate3").length > 0 && $("#myDate4").length) {
        $scope.fechaInicio2 = document.getElementById("myDate3").value;
        $scope.fechaFin2 = document.getElementById("myDate4").value;
     
      }
  

      $http({
          url: path + 'actividad/createsub',
          method: 'get',
          params: {
           sub: $scope.sub,
           fechaInicio: $scope.fechaInicio2,
           fechaFin: $scope.fechaFin2

          },

          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
                
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
        //busca todas las subactividades
        $http({
            url: path + 'actividad/subact',
            method: 'get',
            params:{
              idActividad: $scope.actSeleccionada.idActividad
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).success(function (response) {
          $scope.subActividades = response.actividad;
          console.log($scope.subActividades);
          //limpiar variables   
          $scope.sub ={};
          $scope.markers = [];
        });
       

      //inicializar variables


      //los palcos internos de la actividad de tipo show
      $scope.palcoActividad = [{
        detalle: '',
        capacidad: '',
        cu:''
      }];

       

        
      });

      $scope.All();
    }

    $scope.seleccionarActividad = function(idAct){
      $scope.idAct = idAct;
    }


    //eliminar actividades
    $scope.eliminarAct = function(){
      $http({
          url: path + 'actividad/delete',
          method: 'get',
          params:{
            idActividad: $scope.idAct
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
        $scope.All();
      });
    }

    $scope.seleccionarSub = function(id, index){
      $scope.idSub = id;
      $scope.indexSub = index;
    }

    //eliminar sub actividades 
    $scope.eliminarSub = function(id , index){
  
        $http({
            url: path + 'sub/delete',
            method: 'get',
            params:{
              idEventoActividad: $scope.idSub
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).success(function (response) {
          $scope.subActividades.splice($scope.indexSub , 1);
          $scope.All();
        });
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
        //console.log(location.lat(), location.lng());
        var marker = new google.maps.Marker({
          position: location,
          map: $scope.map
        });
        //console.log(marker.getPosition());
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

  
    $scope.Reporte = function(){
      //console.log(id);
      $http({
          url: path + 'act/reporte',
          method: 'get',
          params:{
            idEvento: $rootScope.evento.idEvento //aqui se supone va el id del evento seleccionado 
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.total = response.total;
        console.log(response.total);
        
      });
    }

   

  $scope.All = function(){
      //trae todas las actividades por evento
      $http({
          url: path + 'actividad/all',
          method: 'get',
          params:{
            idEvento: $rootScope.evento.idEvento //aqui se supone va el id del evento seleccionado 
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.actividades = response.actividad;
        console.log($scope.actividades);
        $scope.ver = true;
        
      });
      
      //llena el calendario con las actividades y las sub actividades
      $http({
          url: path + 'actividad/calendario',
          method: 'get',
          params:{
            idEvento: $rootScope.evento.idEvento //aqui se supone va el id del evento seleccionado 
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.calendario = response.calendario;
        $scope.calen = []; 
        angular.forEach($scope.calendario, function (value, key){
          console.log(value);
          $scope.aux = {
            title: value.nombre,
            start: value.direccion[0].fechaInicio,
            end: value.direccion[0].fechaFin,
            backgroundColor: value.color, //yellow
            borderColor: value.color //yellow
          };
          $scope.calen.push($scope.aux);
        });
        
        setTimeout(function(){ $scope.cargarCalendario(); }, 500);
        //console.log($scope.calendario, $scope.calen);
        
      });

      $scope.Reporte();
    }
    $scope.asociar = function(actividad) {
      console.log(actividad);

    }

/*-----------------------AREA DEL ASIGNAR----------------------------*/

    $scope.funcionAtras = function () {
      if ($scope.buttonNuevo == 0) {
        $scope.buttonNuevo = 1;
      }else{
        $scope.buttonNuevo = 0;
      }

    }

    $scope.cambiarUsuarios = function (tipousuario) {
      $scope.tipousuarioSelect = tipousuario; //Asigna el tipo de usuario que trae el select
    }
    $scope.buscarAsociar = function(actividad) {//Esta función busca a los participantes o a las empresas o a las agrupaciones que ya están asociadas a la actividad.
     $scope.actividadSelect = actividad;
     console.log($scope.tipousuarioSelect);
      /*
        0: Participantes
        1: Empresas
        2: Agrupaciones
      */
      $http({
          url: path + 'asociar/all2',
          method: 'get',
          params:{
            actividad: actividad
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        if (response.error == false) {
          $scope.agrupaciones = response.agrupaciones;
          $scope.empresas = response.empresas;
          $scope.participantes = response.participantes;  
          console.log($scope.agrupaciones , $scope.empresas , $scope.participantes);
        }

        if ($scope.empresas == []) {
          $scope.mensajeAsociacion = 'No hay empresas asociadas';
        }
        if ($scope.participantes == []) {
          $scope.mensajeAsociacion = 'No hay participantes asociados';
        }
        if ($scope.agrupaciones == []) {
          $scope.mensajeAsociacion = 'No hay agrupaciones asociados';
        }
        
      });
    }

    $scope.limpiarAsociar = function(){
      $scope.asociacion = {};
      $scope.nuevo = {};
      $scope.buttonNuevo = 0;
    }

    $scope.selectActividad = function(actividad){
      
      $scope.actividadSelect = actividad;
    }
    $scope.buscarPremiado = function(premio){
      $scope.premioSelect = premio;
      console.log($scope.premioSelect);
        $http({
          url: path + 'buscar/premiado',
          method: 'get',
          params:{
            actividad: $scope.actividadSelect //aqui se manda la actividad con el tipo seleccionado 
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.resultado = response.resultado;
        console.log($scope.resultado);
        $scope.buttonPremio = 1;
    
      });
    }

    $scope.guardarPremiado = function(r){
      console.log(r);
        $http({
          url: path + 'guardar/premiado',
          method: 'get',
          params:{
            actividad: $scope.actividadSelect, //aqui se manda la actividad con el tipo seleccionado 
            premio : $scope.premioSelect,
            persona: r
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        alert(response.mensaje);
        console.log($scope.resultado);
        $scope.buttonPremio = 1;
    
      });
    }   
    $scope.cambiarButton = function(idActividad){
      if ($scope.buttonPremio == 0) {
        $scope.buttonPremio = 1;
      }else{
        $scope.buttonPremio = 0;
      }
    }
   $scope.buscarPremio = function(idActividad){
      $http({
          url: path + 'buscar/premio',
          method: 'get',
          params:{
            idActividad: idActividad //aqui se manda la actividad con el tipo seleccionado 
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.premios = response.premios;
        console.log($scope.premios);
      });
    }

    $scope.nuevoAsociar = function() { //Busca dependiendo del tipo de actividad a los a los participantes, a las empresas o agrupaciones
      
     $http({
          url: path + 'buscar/asociar',
          method: 'get',
          params:{
            actividad: $scope.actividadSelect //aqui se manda la actividad con el tipo seleccionado 
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.agrupacionesN = response.agrupaciones;
        $scope.empresasN = response.empresas;
        $scope.participantesN = response.participantes;  
    //    $scope.tipousuarioSelect = 0;
    //    $scope.buttonNuevo = 1;
      });

    }
    $scope.desAsociar = function(asociada , index){
      console.log(asociada);
      console.log($scope.tipousuarioSelect);
        $http({
          url: path + 'nuevo/desasociar',
          method: 'get',
          params:{
            id: asociada.idAsociacion, //aqui se manda la actividad con el tipo seleccionado 
            tipo : $scope.tipousuarioSelect
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        //$scope.nuevo = response.nuevo;
        $scope.nuevoAsociar();
        $scope.buscarAsociar($scope.actividadSelect);
    //    $scope.buttonNuevo = 0;

      });
    }
    $scope.Asociar = function(nuevo){
      $http({
          url: path + 'nuevo/asociar',
          method: 'get',
          params:{
            actividad: $scope.actividadSelect, //aqui se manda la actividad con el tipo seleccionado 
            nuevo: nuevo,
            tipo : $scope.tipousuarioSelect
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        //$scope.nuevo = response.nuevo;
        $scope.nuevoAsociar();
        $scope.buscarAsociar($scope.actividadSelect);
        $scope.buttonNuevo = 0;
       
      });

    }

    /*----------------------PUNTOS EN LOS INPUT----------------------*/
      $("#costoActividad").on({
        "focus": function (event) {
            $(event.target).select();
        },
        "keyup": function (event) {
            $(event.target).val(function (index, value ) {
                return value.replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            });
        }
      });
      $("#poblacionparticipante").on({
        "focus": function (event) {
            $(event.target).select();
        },
        "keyup": function (event) {
            $(event.target).val(function (index, value ) {
                return value.replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            });
        }
      }); 

  //llamadas
  $scope.All();

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
