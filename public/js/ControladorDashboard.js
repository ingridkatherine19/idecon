'use strict';
 
angular.module('myApp.Dashboard', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/dashboard', {
        templateUrl: 'pages/Dashboard/dashboard.html',
        controller: 'DashboardCtrl'
    });
}])

// Home controller
.controller('DashboardCtrl', ['$http', '$scope', '$rootScope','$interval', function($http, $scope, $rootScope , $interval) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  //console.log($rootScope.user);
  $scope.ver = false;
  $scope.data = []; 
  $scope.dataGrafica = [];
  $scope.labelData =[];
  $scope.cantidadData=[];
  $scope.ruta = 'evento/all';
  $scope.mostrarTab = 1;
  $scope.recarga = false;
  var interval;
  var interval2;
  var interval3;
  $scope.fechaActual = new Date();
  $scope.colores = [
    {
        "color": "#eca64f"
    },
    {
        "color": "#d18166"
    },
    {
        "color": "#c63445"
    },
    {
        "color": "#4e313c"
    }
  ];

  /*prueba barras*/

  $scope.s = ['Patrocinadoras', 'Consumidoras', 'Colaboradoras'];

 

  /*prueba barra lineal*/

  $scope.l1 = ["January", "February", "March", "April", "May", "June", "July"];
  $scope.s1 = ['Series A'];
  $scope.d1 = [
    [28, 48, 40, 19, 86, 27, 90]
  ];
   /*Grafica de cantidades de usuarios */

   /*PRUEBAAAA DE GRAFICAAAA*/
 
   /* FIN PRUEBAAAA*/

  $scope.labelUsuario = ["Empresas", "Participantes", "Agrupaciones"];
  
  $scope.onClick = function (points, evt) {
    //console.log(points, evt);
  };


  /*--------------------Sección que busca en general---------------------*/
  //todas las empresas 
  $scope.empresasAll = function() {

   $http({
        url: path + 'empresa/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.empresas = response.empresa;
       //console.log($scope.empresas);
    });
  }
  //todas las agrupaciones
  $scope.agrupacionesAll = function() {
   $http({
        url: path + 'agrupacion/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.agrupaciones = response.agrupacion;
       //console.log($scope.agrupaciones);
    });
  }

  //todas las agrupaciones
  $scope.participantesAll = function() {
   $http({
        url: path + 'participante/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.participantes = response.participante;
       //console.log($scope.participantes);
    });
  }

  //todos los hoteles
  $scope.hotelesAll = function() {
   $http({
        url: path + 'hotel/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.hoteles = response.hotel;
       //console.log($scope.hoteles);
    });
  }
  //todos los restaurantes
  $scope.restaurantesAll = function() {
   $http({
        url: path + 'restaurante/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.restaurantes = response.restaurante;
       
       //console.log($scope.restaurantes);
    });
  }
  //todos los lugares
  $scope.lugaresAll = function() {
   $http({
        url: path + 'lugar/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.lugares = response.lugar;
       //console.log($scope.lugares);
    });
  }

  /*-------------------FIN DE SECCIÓN GENERAL---------------------------*/
  /*PARTE MEDIOAMBIENTAL*/
  /*$scope.medioambiental = function(){

    $http({
        url: path + 'consumo/all',
        method: 'get',
        params:{
          idEvento: $rootScope.user.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      
      $scope.reciclado = response.reciclado;//RECICLADO
      $scope.impacto = response.impacto;
      $scope.selectPalco = response.selectPalco;
      $scope.selectCalle = response.selectCalle;
      $scope.selectOrganico = response.selectOrganico;

      //reporte individual de cada materia
      $scope.aluminio = response.reporteAluminio;
      $scope.vidrio = response.reporteVidrio;
      $scope.plastico = response.reportePlastico;
      $scope.carton = response.reporteCarton;
      $scope.organico = response.reporteOrganico;

      //agregar puntos a las variables
      $scope.aluminio.basura = $scope.numberFormat(Math.round($scope.aluminio.basura).toString());
      $scope.aluminio.kwh = $scope.numberFormat(Math.round($scope.aluminio.kwh).toString()); 
      $scope.aluminio.agua = $scope.numberFormat(Math.round($scope.aluminio.agua).toString());
      $scope.aluminio.petroleo = $scope.numberFormat(Math.round($scope.aluminio.petroleo).toString());
      $scope.aluminio.co2 = $scope.numberFormat(Math.round($scope.aluminio.co2).toString());
      $scope.aluminio.bauxita = $scope.numberFormat(Math.round($scope.aluminio.bauxita).toString());
      $scope.aluminio.hierro = $scope.numberFormat(Math.round($scope.aluminio.hierro).toString());
      $scope.vidrio.basura = $scope.numberFormat(Math.round($scope.vidrio.basura).toString());
      $scope.vidrio.prima = $scope.numberFormat(Math.round($scope.vidrio.prima).toString());
      $scope.vidrio.kwh = $scope.numberFormat(Math.round($scope.vidrio.kwh).toString());
      $scope.vidrio.petroleo = $scope.numberFormat(Math.round($scope.vidrio.petroleo).toString());
      $scope.vidrio.co2 = $scope.numberFormat(Math.round($scope.vidrio.co2).toString());
      $scope.plastico.basura = $scope.numberFormat(Math.round($scope.plastico.basura).toString());
      $scope.plastico.petroleo = $scope.numberFormat(Math.round($scope.plastico.petroleo).toString());
      $scope.plastico.kwh = $scope.numberFormat(Math.round($scope.plastico.kwh).toString());
      $scope.plastico.agua = $scope.numberFormat(Math.round($scope.plastico.agua).toString());
      $scope.plastico.co2 = $scope.numberFormat(Math.round($scope.plastico.co2).toString());
      $scope.carton.basura = $scope.numberFormat(Math.round($scope.carton.basura).toString());
      $scope.carton.arbol = $scope.numberFormat(Math.round($scope.carton.arbol).toString());
      $scope.carton.agua = $scope.numberFormat(Math.round($scope.carton.agua).toString());
      $scope.carton.kwh = $scope.numberFormat(Math.round($scope.carton.kwh).toString());
      $scope.carton.petroleo = $scope.numberFormat(Math.round($scope.carton.petroleo).toString());
      $scope.carton.co2 = $scope.numberFormat(Math.round($scope.carton.co2).toString());
      $scope.organico.basura = $scope.numberFormat(Math.round($scope.organico.basura).toString());
      $scope.organico.compostaje = $scope.numberFormat(Math.round($scope.organico.compostaje).toString());
      $scope.organico.organico = $scope.numberFormat(Math.round($scope.organico.organico).toString());
      $scope.organico.natural = $scope.numberFormat(Math.round($scope.organico.natural).toString());
      $scope.organico.gas = $scope.numberFormat(Math.round($scope.organico.gas).toString());
      $scope.organico.bio = $scope.numberFormat(Math.round($scope.organico.bio).toString());
      $scope.organico.co2 = $scope.numberFormat(Math.round($scope.organico.co2).toString());

      //Puntos en la tabla de impacto 
      $scope.impacto.costoArboles = $scope.numberFormat(Math.round($scope.impacto.costoArboles).toString());
      $scope.impacto.reduccionArboles = $scope.numberFormat(Math.round($scope.impacto.reduccionArboles).toString());
      $scope.impacto.totalArboles =  $scope.numberFormat(Math.round($scope.impacto.totalArboles).toString());
      
      $scope.impacto.costoCompo = $scope.numberFormat(Math.round($scope.impacto.costoCompo).toString());
      $scope.impacto.reduccionCompo = $scope.numberFormat(Math.round($scope.impacto.reduccionCompo).toString());
      $scope.impacto.totalCompo =  $scope.numberFormat(Math.round($scope.impacto.totalCompo).toString());
      
      $scope.impacto.costoDese = $scope.numberFormat(Math.round($scope.impacto.costoDese).toString());
      $scope.impacto.reduccionDese = $scope.numberFormat(Math.round($scope.impacto.reduccionDese).toString());
      $scope.impacto.totalDese =  $scope.numberFormat(Math.round($scope.impacto.totalDese).toString());
      
      $scope.impacto.costoPrima = $scope.numberFormat(Math.round($scope.impacto.costoPrima).toString());
      $scope.impacto.reduccionPrima = $scope.numberFormat(Math.round($scope.impacto.reduccionPrima).toString());
      $scope.impacto.totalPrima =  $scope.numberFormat(Math.round($scope.impacto.totalPrima).toString());

      $scope.impacto.costoVerte = $scope.numberFormat(Math.round($scope.impacto.costoVerte).toString());
      $scope.impacto.reduccionVerte = $scope.numberFormat(Math.round($scope.impacto.reduccionVerte).toString());
      $scope.impacto.totalVerte =  $scope.numberFormat(Math.round($scope.impacto.totalVerte).toString());

      $scope.impacto.costoKwh = $scope.numberFormat(Math.round($scope.impacto.costoKwh).toString());
      $scope.impacto.reduccionKwh = $scope.numberFormat(Math.round($scope.impacto.reduccionKwh).toString());
      $scope.impacto.totalKwh =  $scope.numberFormat(Math.round($scope.impacto.totalKwh).toString());
      
      $scope.impacto.costoAgua = $scope.numberFormat(Math.round($scope.impacto.costoAgua).toString());
      $scope.impacto.reduccionAgua = $scope.numberFormat(Math.round($scope.impacto.reduccionAgua).toString());
      $scope.impacto.totalAgua =  $scope.numberFormat(Math.round($scope.impacto.totalAgua).toString());
      
      $scope.impacto.costoPetro = $scope.numberFormat(Math.round($scope.impacto.costoPetro).toString());
      $scope.impacto.reduccionPetro = $scope.numberFormat(Math.round($scope.impacto.reduccionPetro).toString());
      $scope.impacto.totalPetro =  $scope.numberFormat(Math.round($scope.impacto.totalPetro).toString());
      
      $scope.impacto.costoNatural = $scope.numberFormat(Math.round($scope.impacto.costoNatural).toString());
      $scope.impacto.reduccionNatural = $scope.numberFormat(Math.round($scope.impacto.reduccionNatural).toString());
      $scope.impacto.totalNatural =  $scope.numberFormat(Math.round($scope.impacto.totalNatural).toString());

      $scope.impacto.costoGas = $scope.numberFormat(Math.round($scope.impacto.costoGas).toString());
      $scope.impacto.reduccionGas = $scope.numberFormat(Math.round($scope.impacto.reduccionGas).toString());
      $scope.impacto.totalGas =  $scope.numberFormat(Math.round($scope.impacto.totalGas).toString());

      $scope.impacto.costoBio = $scope.numberFormat(Math.round($scope.impacto.costoBio).toString());
      $scope.impacto.reduccionBio = $scope.numberFormat(Math.round($scope.impacto.reduccionBio).toString());
      $scope.impacto.totalBio =  $scope.numberFormat(Math.round($scope.impacto.totalBio).toString());

      $scope.impacto.costoCo2 = $scope.numberFormat(Math.round($scope.impacto.costoCo2).toString());
      $scope.impacto.reduccionCo2 = $scope.numberFormat(Math.round($scope.impacto.reduccionCo2).toString());
      $scope.impacto.totalCo2 =  $scope.numberFormat(Math.round($scope.impacto.totalCo2).toString());

      $scope.impacto.costoBauxita = $scope.numberFormat(Math.round($scope.impacto.costoBauxita).toString());
      $scope.impacto.reduccionBauxita = $scope.numberFormat(Math.round($scope.impacto.reduccionBauxita).toString());
      $scope.impacto.totalBauxita =  $scope.numberFormat(Math.round($scope.impacto.totalBauxita).toString());

      $scope.impacto.costoHierro = $scope.numberFormat(Math.round($scope.impacto.costoHierro).toString());
      $scope.impacto.reduccionHierro = $scope.numberFormat(Math.round($scope.impacto.reduccionHierro).toString());
      $scope.impacto.totalHierro =  $scope.numberFormat(Math.round($scope.impacto.totalHierro).toString());
      console.log($scope.aluminio,$scope.vidrio,$scope.plastico,$scope.carton,$scope.organico); 
      //
      $scope.totalReciclado =0;
      angular.forEach($scope.reciclado, function (value, key){
        value.kg2 = $scope.numberFormat(Math.round(value.kg).toString());
        value.valor2 = $scope.numberFormat(Math.round(value.valor).toString());
        value.total2 = $scope.numberFormat(Math.round(value.total).toString());
        $scope.totalReciclado += value.kg;
      });
      $scope.labels11 = [$scope.reciclado[0].material, $scope.reciclado[1].material, $scope.reciclado[2].material , $scope.reciclado[3].material , $scope.reciclado[4].material];
      $scope.data10 = [$scope.reciclado[0].kg, $scope.reciclado[1].kg, $scope.reciclado[2].kg , $scope.reciclado[3].kg , $scope.reciclado[4].kg ];
      $scope.reciclado[0].porcentaje = ($scope.reciclado[0].kg*100)/$scope.totalReciclado;
      $scope.reciclado[1].porcentaje = ($scope.reciclado[1].kg*100)/$scope.totalReciclado;
      $scope.reciclado[2].porcentaje = ($scope.reciclado[2].kg*100)/$scope.totalReciclado;
      $scope.reciclado[3].porcentaje = ($scope.reciclado[3].kg*100)/$scope.totalReciclado;
      $scope.reciclado[4].porcentaje = ($scope.reciclado[4].kg*100)/$scope.totalReciclado;
      console.log($scope.reciclado);
      //reutilizacion de material
      //plastico
      $scope.reciclado[2].marco = $scope.reciclado[2].kg / 6;
      $scope.reciclado[2].marco = $scope.numberFormat(Math.round($scope.reciclado[2].marco).toString());
      $scope.reciclado[2].cantidad = $scope.reciclado[2].kg / 30;
      $scope.reciclado[2].cantidad = $scope.numberFormat(Math.round($scope.reciclado[2].cantidad).toString());
      $scope.reciclado[2].camisa = $scope.reciclado[2].cantidad / 40;
      $scope.reciclado[2].camisa = $scope.numberFormat(Math.round($scope.reciclado[2].camisa).toString());
      //aluminio
      $scope.reciclado[0].llanta = $scope.reciclado[0].cantidad / 80;
      $scope.reciclado[0].llanta = $scope.numberFormat(Math.round($scope.reciclado[0].llanta).toString());
      $scope.reciclado[0].cantidad = $scope.numberFormat(Math.round($scope.reciclado[0].cantidad).toString());
      
      
      $scope.ver = true;
    });
  }*/

  /*------------------INICIO DE SECCIÓN POR DEPARTAMENTO---------------*/
  $scope.empresasAllDepartamento = function() {
 
   $http({
        url: path + 'empresa/alldepartamento',
        method: 'get',
        params:{
          idDepartamento: $scope.departamentoSelect
        },
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.empresas = response.empresa;
      
    });
  }
  //todas las agrupaciones
  $scope.agrupacionesAllDepartamento = function() {

   $http({
        url: path + 'agrupacion/alldepartamento',
        method: 'get',
        params:{
          idDepartamento: $scope.departamentoSelect
        },
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.agrupaciones = response.agrupacion;
       //console.log($scope.agrupaciones);
    });
  }

  //todas las agrupaciones
  $scope.participantesAllDepartamento = function() {
   $http({
        url: path + 'participante/alldepartamento',
        method: 'get',
        params:{
          idDepartamento: $scope.departamentoSelect
        },
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.participantes = response.participante;
    });
  }

  //todos los hoteles
  $scope.hotelesAllDepartamento = function() {
  
   $http({
        url: path + 'hotel/alldepartamento',
        method: 'get',
        params:{
          idDepartamento: $scope.departamentoSelect
        },
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.hoteles = response.hotel;
       //console.log($scope.hoteles);
    });
  }
  //todos los restaurantes
  $scope.restaurantesAllDepartamento = function() {
  
   $http({
        url: path + 'restaurante/alldepartamento',
        method: 'get',
        params:{
          idDepartamento: $scope.departamentoSelect
        },
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.restaurantes = response.restaurante;
    });
  }
  //todos los lugares
  $scope.lugaresAll = function() {
    
   $http({
        url: path + 'lugar/all',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
       $scope.lugares = response.lugar;
       //console.log($scope.lugares);
    });
  }
  /*------------------FIN DE SECCIÓN POR DEPARTAMENTO---------------*/

  //todos los eventos 
  $scope.allEvent = function(){
  
    if ($scope.departamentoSelect == undefined || $scope.departamentoSelect == 0) {
      $scope.ruta = 'evento/all';
    }else{

      $scope.ruta = 'evento/alldepartamento';
    }

    $http({
        url: path + $scope.ruta,
        method: 'get',
        params:{
          idDepartamento: $scope.departamentoSelect
        },
        headers: {
            "Content-Type": "application/json"
        }

    }).success(function (response) {
        $scope.eventos = response.eventos;
        
        //trae todo el reporte semanal de la cantidad de actividades realizadas
        $scope.semanal = response.semanal;
    //    console.log($scope.semanal);
        var index = 0;
        angular.forEach($scope.eventos, function (value, key){
          $scope.color = $scope.colores[index].color;
          index +=  1;
          if (index == 4 ) {
            index = 0;
          }
        /*calendario*/
          $scope.prueba = {
            title: value.descripcion,
            start: new Date(value.fechaInicio),
            end: new Date(value.fechaFin),
            backgroundColor: $scope.color, //Info (aqua)
            borderColor: $scope.color, //Info (aqua)
            url: '#/actividad',
            datos: value
            
          }

          $scope.data.push($scope.prueba);
          /*fin de calendario*/
          /*grafica*/
          var dia = new Date(value.fechaInicio);
          var mes = dia.getMonth()+1;
          var esta=0;
          for (var i = $scope.dataGrafica.length - 1; i >= 0; i--) {
            if($scope.dataGrafica[i].codigo == mes){
              esta=1;
              $scope.dataGrafica[i].cantidad++;
            }
            
          }

          if (esta==0) {

            $scope.nuevo = {
              codigo: mes,
              cantidad:1
            }
            if (mes == 1) {
              $scope.nuevo.mes = 'Ene';
            }
            if (mes == 2) {
              $scope.nuevo.mes = 'Feb';
            }
            if (mes == 3) {
              $scope.nuevo.mes = 'Mar';
            }
            if (mes == 4) {
              $scope.nuevo.mes = 'Abr';
            }
            if (mes == 5) {
              $scope.nuevo.mes = 'May';
            }
            if (mes == 6) {
              $scope.nuevo.mes = 'Jun';
            }
            if (mes == 7) {
              $scope.nuevo.mes = 'Jul';
            }
            if (mes == 8) {
              $scope.nuevo.mes = 'Ago';
            }
            if (mes == 9) {
              $scope.nuevo.mes = 'Sep';
            }
            if (mes == 10) {
              $scope.nuevo.mes = 'Oct';
            }
            if (mes == 11) {
              $scope.nuevo.mes = 'Nov';
            }
            if (mes == 12) {
              $scope.nuevo.mes = 'Dic';
            }

            $scope.dataGrafica.push($scope.nuevo);
          }


        });

        $scope.labels = [];
        $scope.graficaUsuario = [];
        $scope.aux = [];
        $scope.aux2 = [];
        $scope.data22 = [];
        $scope.data23 = [];
        //recorre los datos de los reportes mensuales
        angular.forEach($scope.dataGrafica, function (value, key){

          $scope.labelData.push(value.mes);

          $scope.cantidadData.push(value.cantidad);
          $scope.labels.push(value.mes);
          $scope.aux.push(value.cantidad); 
          
        });
        
        $scope.data22.push($scope.aux);
        //recorre el re´porte semanal para llenar la grafica
        angular.forEach($scope.semanal, function (value, key){

          $scope.graficaUsuario.push(value.dia);
          $scope.aux2.push(value.cantidad); 
          
        });

        $scope.data23.push($scope.aux2);
      //  console.log($scope.graficaUsuario);
    //  $scope.cargarGrafica();
      /* initialize the external events
     -----------------------------------------------------------------*/
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
    var date = new Date();
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
      events: $scope.data,
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


    });
  }

  $scope.colorRandom = function(){

    var color = '';
    for (var i = 0; i < 4; i++) {
      color = $scope.colores[i].color;
    }
    return color;

  }
  //llamada a los metodos 
  

  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */


  setTimeout(function(){ $scope.cargarBarChart(); }, 1000);

    //$scope.cargarBarChart();
   //Cambiar tab
  $scope.tab = function(seleccionado){
  
    $scope.mostrarTab = seleccionado;   
    if ($scope.mostrarTab == 0) {
      setTimeout(function(){ $scope.cargarBarChart2(); }, 300);
    }else{
   //   setTimeout(function(){ $scope.cargarBarChart(); }, 1000);
    }
  
  }
  
  /*Inicio de BarChart*/

  $scope.cargarBarChart = function(){
    //alert('2');
   // console.log($scope.labels , $scope.data22);
    var areaChartData = {
      labels: $scope.labels,
      datasets: [
        {
          label: "Cantidad",
          fillColor: "rgba(0, 234, 181, 1)",
          strokeColor: "rgba(0, 234, 181, 1)",
          pointColor: "rgba(0, 234, 181, 1)",
          pointStrokeColor: "rgba(0, 234, 181, 1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(0, 234, 181, 1)",
          data: $scope.data22[0]
        }
      ]
    };
   
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    //barChartData.datasets[1].fillColor = "#00a65a";
    //barChartData.datasets[1].strokeColor = "#00a65a";
    //barChartData.datasets[1].pointColor = "#00a65a";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  }

    $scope.cargarBarChart2 = function(){
    if ($scope.recarga == false) {
      var areaChartData = {
      labels: $scope.graficaUsuario,
      datasets: [
        {
          label: "Cantidad",
          fillColor: "rgba(0, 234, 181, 1)",
          strokeColor: "rgba(0, 234, 181, 1)",
          pointColor: "rgba(0, 234, 181, 1)",
          pointStrokeColor: "rgba(0, 234, 181, 1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(0, 234, 181, 1)",
          data: $scope.data23[0]
        }
      ]
    };
   
    var barChartCanvas = $("#barChart2").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    //barChartData.datasets[1].fillColor = "#00a65a";
    //barChartData.datasets[1].strokeColor = "#00a65a";
    //barChartData.datasets[1].pointColor = "#00a65a";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
    $scope.recarga = true;
    }
   
  }


  /*--------------------Fin BarChart----------------------*/  

  /*FIN DE PRUEBA BARCHART*/


  /*---------------------INICIO DE FUNCIONES DEL FILTRO------------------------*/
  
  //Buscar departamentos que tengan una actividad
    $scope.buscarDepartamento = function() {
      $http({
          url: path + 'departamento/buscar',
          method: 'get',
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.departamentos = response.departamentos;
    
      });
    }
  /*-------------------------INICIO DE MEDIOAMBIENTAL------------------*/
    $scope.medioambientalAll = function(){
     
      $http({
          url: path + 'consumo/dashboard',
          method: 'get',
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.reciclado = response.reciclado;
        $scope.impacto = response.impacto;
   //     console.log($scope.impacto);
        angular.forEach($scope.reciclado, function (value, key){
          value.kg2 = $scope.numberFormat(Math.round(value.kg).toString()); 
          value.total2 = $scope.numberFormat(Math.round(value.total).toString());
           
        });

        //reutilizacion de material
        //plastico
        $scope.reciclado[2].marco = $scope.reciclado[2].kg / 6;
        $scope.reciclado[2].cantidad = $scope.reciclado[2].kg / 30;
        $scope.reciclado[2].camisa = $scope.reciclado[2].cantidad / 40;
        $scope.reciclado[2].marco = $scope.numberFormat(Math.round($scope.reciclado[2].marco).toString());
        $scope.reciclado[2].cantidad = $scope.numberFormat(Math.round($scope.reciclado[2].cantidad).toString());
        $scope.reciclado[2].camisa = $scope.numberFormat(Math.round($scope.reciclado[2].camisa).toString());
        //aluminio
        $scope.reciclado[0].llanta = $scope.reciclado[0].cantidad / 80;
        $scope.reciclado[0].silla = $scope.reciclado[0].cantidad / 550;
        $scope.reciclado[0].llanta = $scope.numberFormat(Math.round($scope.reciclado[0].llanta).toString());
        $scope.reciclado[0].cantidad = $scope.numberFormat(Math.round($scope.reciclado[0].cantidad).toString());
        $scope.reciclado[0].silla = $scope.numberFormat(Math.round($scope.reciclado[0].silla).toString());
        $scope.ver = true;
        

        //impacto
        $scope.impacto.reduccionArboles = $scope.numberFormat(Math.round($scope.impacto.reduccionArboles).toString());
        $scope.impacto.reduccionAgua = $scope.numberFormat(Math.round($scope.impacto.reduccionAgua).toString());
        $scope.impacto.reduccionPetro = $scope.numberFormat(Math.round($scope.impacto.reduccionPetro).toString());
        $scope.impacto.reduccionKwh = $scope.numberFormat(Math.round($scope.impacto.reduccionKwh).toString());
        $scope.impacto.reduccionCo2 = $scope.numberFormat(Math.round($scope.impacto.reduccionCo2).toString());
        $scope.impacto.reduccionNatural = $scope.numberFormat(Math.round($scope.impacto.reduccionNatural).toString());
        $scope.impacto.reduccionGas = $scope.numberFormat(Math.round($scope.impacto.reduccionGas).toString());
        $scope.impacto.reduccionBio = $scope.numberFormat(Math.round($scope.impacto.reduccionBio).toString());
        
      });
    }
    $scope.medioambientalAllDepartamento = function(){
     
      $http({
          url: path + 'consumo/dashboarddesp',
          method: 'get',
          params:{
            idDepartamento: $scope.departamentoSelect
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.reciclado = response.reciclado;
        $scope.impacto = response.impacto;
      //  console.log($scope.impacto);
        angular.forEach($scope.reciclado, function (value, key){
          value.kg2 = $scope.numberFormat(Math.round(value.kg).toString()); 
          value.total2 = $scope.numberFormat(Math.round(value.total).toString());
           
        });

        //reutilizacion de material
        //plastico
        $scope.reciclado[2].marco = $scope.reciclado[2].kg / 6;
        $scope.reciclado[2].cantidad = $scope.reciclado[2].kg / 30;
        $scope.reciclado[2].camisa = $scope.reciclado[2].cantidad / 40;
        $scope.reciclado[2].marco = $scope.numberFormat(Math.round($scope.reciclado[2].marco).toString());
        $scope.reciclado[2].cantidad = $scope.numberFormat(Math.round($scope.reciclado[2].cantidad).toString());
        $scope.reciclado[2].camisa = $scope.numberFormat(Math.round($scope.reciclado[2].camisa).toString());
        //aluminio
        $scope.reciclado[0].llanta = $scope.reciclado[0].cantidad / 80;
        $scope.reciclado[0].silla = $scope.reciclado[0].cantidad / 550;
        $scope.reciclado[0].llanta = $scope.numberFormat(Math.round($scope.reciclado[0].llanta).toString());
        $scope.reciclado[0].cantidad = $scope.numberFormat(Math.round($scope.reciclado[0].cantidad).toString());
        $scope.reciclado[0].silla = $scope.numberFormat(Math.round($scope.reciclado[0].silla).toString());
        $scope.ver = true;
        

        //impacto
        $scope.impacto.reduccionArboles = $scope.numberFormat(Math.round($scope.impacto.reduccionArboles).toString());
        $scope.impacto.reduccionAgua = $scope.numberFormat(Math.round($scope.impacto.reduccionAgua).toString());
        $scope.impacto.reduccionPetro = $scope.numberFormat(Math.round($scope.impacto.reduccionPetro).toString());
        $scope.impacto.reduccionKwh = $scope.numberFormat(Math.round($scope.impacto.reduccionKwh).toString());
        $scope.impacto.reduccionCo2 = $scope.numberFormat(Math.round($scope.impacto.reduccionCo2).toString());
        $scope.impacto.reduccionNatural = $scope.numberFormat(Math.round($scope.impacto.reduccionNatural).toString());
        $scope.impacto.reduccionGas = $scope.numberFormat(Math.round($scope.impacto.reduccionGas).toString());
        $scope.impacto.reduccionBio = $scope.numberFormat(Math.round($scope.impacto.reduccionBio).toString());
        
      });
    }
    
  /*----------------------FIN DE MEDIOAMBIENTAL--------------------------*/

    $scope.buscarDashboard = function(opc) {//Esta función se encarga de llamar a las demás funciones si es por departamento o es por todas

     $scope.departamentoSelect = opc;
     $scope.allEvent();
      if (opc == 0) {
        $scope.actAll();
        $scope.empresasAll();
        $scope.agrupacionesAll();
        $scope.participantesAll();
        $scope.hotelesAll();
        $scope.restaurantesAll();
        $scope.lugaresAll();
        $scope.medioambientalAll();
      }else{

        $scope.actAllDepartamento();
        $scope.empresasAllDepartamento();
        $scope.agrupacionesAllDepartamento();
        $scope.participantesAllDepartamento();
        $scope.hotelesAllDepartamento();
        $scope.restaurantesAllDepartamento();
        $scope.actTipoDepartamento();
        $scope.medioambientalAllDepartamento();
      
      }
    }
 /*---------------------FIN DE FUNCIONES DEL FILTRO------------------------*/
    
 /*---------FUNCION DE LA GRAFICA CON LOS TIPOS DE ACTIVIDADES----------- */
 
  $scope.actTipo = function(){
    $http({
        url: path + 'evento/total',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.totalTipo = response.total;
      $scope.labelsTipo = ["Sin valor comercial", "Con boleta de ingreso", "Con valor comercial"];
      $scope.dataTipo = [$scope.totalTipo.sinvalor, $scope.totalTipo.conboleta, $scope.totalTipo.convalor];
  //    console.log($scope.totalTipo);
    }); 
  }
  $scope.actTipoDepartamento = function(){
    $http({
        url: path + 'evento/totaldep',
        params:{
          idDepartamento: $scope.departamentoSelect
        },
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.totalTipo = response.total;
      $scope.labelsTipo = ["Sin valor comercial", "Con boleta de ingreso", "Con valor comercial"];
      $scope.dataTipo = [$scope.totalTipo.sinvalor, $scope.totalTipo.conboleta, $scope.totalTipo.convalor];
   //   console.log($scope.totalTipo);
    }); 
  }
/*----------------------FIN GRAFICA TIPO DE ACTIVIDADES-------------------*/


  /*------select del mapa para filtrar los puntos---------*/
  $scope.tituloMapa = "Actividades"
  $scope.selectMapa = function(tipo){

    if (tipo == 0) { // llama a  eventos
      $scope.tituloMapa = "Eventos"  
    }
    if (tipo == 1) { //llama a actividades
      $scope.tituloMapa = "Actividades"
    }
    if (tipo == 2) { // llama a empresas
      $scope.tituloMapa = "Empresas"
    }
    if (tipo == 3) { //llama a agrupaciones
      $scope.tituloMapa = "Agrupaciones"
    }
    if (tipo == 4) { // llama a participantes
      $scope.tituloMapa = "Participantes"
    }
    if (tipo == 5) { //llama hoteles
      $scope.tituloMapa = "Hoteles"
    }
    if (tipo == 6) { // llama a restaurantes
      $scope.tituloMapa = "Restaurantes"
    }
    if (tipo == 7) { //llama lugares turisticos
      $scope.tituloMapa = "Lugares Turisticos"
    }

    $scope.initMap(tipo); 

  }
  /*------------------------fin del select------------*/

  /*----------------------MAPA-------------------------*/
    $scope.actAllDepartamento = function(){
   
      $http({
          url: path + 'dashboard/alldepartamento',
          method: 'get',
          params:{
            idDepartamento : $scope.departamentoSelect
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.actividades = response.actividad;
        $scope.totales = response.totales;
        $scope.totales.palco = $scope.numberFormat($scope.totales.palco.toString());
        $scope.totales.calle = $scope.numberFormat($scope.totales.calle.toString());
        $scope.totalModalidad = response.modalidad;
    //    console.log(response.horas);
        $scope.horas = response.horas;
        $scope.minutos = $scope.horas*60;

        //total de ingresos y egresos
        $scope.totalIngCos = response.ingCos;
        $scope.totalIngCos.costosxhora = $scope.totalIngCos.totalCostos/$scope.horas;
        $scope.totalIngCos.ingresosxhora = $scope.totalIngCos.totalIngresos/$scope.horas;
        $scope.totalIngCos.costosxminuto = $scope.totalIngCos.totalCostos/$scope.minutos;
        $scope.totalIngCos.ingresosxminuto = $scope.totalIngCos.totalIngresos/$scope.minutos;
        $scope.totalIngCos.costosxhora = $scope.numberFormat(Math.round($scope.totalIngCos.costosxhora).toString());
        $scope.totalIngCos.ingresosxhora = $scope.numberFormat(Math.round($scope.totalIngCos.ingresosxhora).toString());;
        $scope.totalIngCos.costosxminuto = $scope.numberFormat(Math.round($scope.totalIngCos.costosxminuto).toString());;
        $scope.totalIngCos.ingresosxminuto = $scope.numberFormat(Math.round($scope.totalIngCos.ingresosxminuto).toString());;
        $scope.totalIngCos.costosxact = $scope.numberFormat($scope.totalIngCos.costosxact.toString());
        $scope.totalIngCos.ingresosxact = $scope.numberFormat($scope.totalIngCos.ingresosxact.toString());
        $scope.totalIngCos.otrosCostos = $scope.numberFormat($scope.totalIngCos.otrosCostos.toString());
        $scope.totalIngCos.otrosIngresos = $scope.numberFormat($scope.totalIngCos.otrosIngresos.toString());
        $scope.totalIngCos.totalCostos = $scope.numberFormat($scope.totalIngCos.totalCostos.toString());
        $scope.totalIngCos.totalIngresos = $scope.numberFormat($scope.totalIngCos.totalIngresos.toString());
     
        if ($scope.totalIngCos.costosxhora) {
          $scope.totalIngCos.costosxhora = 0;
        }
        if ($scope.totalIngCos.costosxminuto) {
          $scope.totalIngCos.costosxminuto = 0;
        }
        if ($scope.totalIngCos.ingresosxhora) {
          $scope.totalIngCos.ingresosxhora = 0;
        }
        if ($scope.totalIngCos.ingresosxminuto) {
          $scope.totalIngCos.ingresosxminuto = 0;
        }
        
        //consumo de bebidas, snacks y comidas en palcos y calle
        $scope.totalConsumo = response.consumo;
        $scope.totalConsumo.bebidasPalco = $scope.numberFormat($scope.totalConsumo.bebidasPalco.toString());
        $scope.totalConsumo.bebidascalle = $scope.numberFormat($scope.totalConsumo.bebidascalle.toString());
        $scope.totalConsumo.comidasPalco = $scope.numberFormat($scope.totalConsumo.comidasPalco.toString());
        $scope.totalConsumo.comidascalle = $scope.numberFormat($scope.totalConsumo.comidascalle.toString());
        $scope.totalConsumo.snacksPalco = $scope.numberFormat($scope.totalConsumo.snacksPalco.toString());
        $scope.totalConsumo.snackscalle = $scope.numberFormat($scope.totalConsumo.snackscalle.toString());
        $scope.totalConsumo.totalBebidas = $scope.numberFormat($scope.totalConsumo.totalBebidas.toString());
        $scope.totalConsumo.totalCalle = $scope.numberFormat($scope.totalConsumo.totalCalle.toString());
        $scope.totalConsumo.totalPalco = $scope.numberFormat($scope.totalConsumo.totalPalco.toString());      
        $scope.totalConsumo.totalSnacks = $scope.numberFormat($scope.totalConsumo.totalSnacks.toString()); 
        $scope.totalConsumo.totalComidas = $scope.numberFormat($scope.totalConsumo.totalComidas.toString()); 
        
      //  console.log($scope.totalConsumo);

        $scope.totalEmpresa = response.totalEmpresa;
        
        
        $scope.cantidadEmpleos = response.cantidadEmpleos;
        $scope.cantActividades = response.cantActividades;
        $scope.totalAgrupacion = response.totalAgrupacion;
        $scope.totalParticipante = response.totalParticipante;
        $scope.sum = response.sum; 
        $scope.cantSub = response.cantSub;
        $scope.capacidad = response.capacidad;
       // $scope.capacidad = $scope.numberFormat($scope.capacidad.toString());
        $scope.cantidadEmpleos = $scope.numberFormat($scope.cantidadEmpleos.toString());
        $scope.sum.costos = $scope.numberFormat($scope.sum.costos.toString());
        $scope.sum.ingresos = $scope.numberFormat($scope.sum.ingresos.toString());
        $scope.sum.nempleados = $scope.numberFormat($scope.sum.nempleados.toString());
        $scope.sum.cantMujeres = $scope.numberFormat($scope.sum.cantMujeres.toString());
        $scope.sum.cantHombres = $scope.numberFormat($scope.sum.cantHombres.toString());
           
        /*datos de las barras*/
        $scope.totalEmpresa.totalGeneral = $scope.totalEmpresa.cantPatrocinio + $scope.totalEmpresa.cantProvee + $scope.totalEmpresa.cantConsumo;  
        $scope.totalEmpresa.promPatrocinio = ($scope.totalEmpresa.cantPatrocinio * 100) / $scope.totalEmpresa.totalGeneral;
        $scope.totalEmpresa.promPatrocinio = Math.round($scope.totalEmpresa.promPatrocinio);
        $scope.totalEmpresa.promProvee = ($scope.totalEmpresa.cantProvee * 100) / $scope.totalEmpresa.totalGeneral;
        $scope.totalEmpresa.promProvee = Math.round($scope.totalEmpresa.promProvee);
        $scope.totalEmpresa.promConsumo = ($scope.totalEmpresa.cantConsumo * 100) / $scope.totalEmpresa.totalGeneral;    
        $scope.totalEmpresa.promConsumo = Math.round($scope.totalEmpresa.promConsumo);
        $scope.cantEmpresas = [ $scope.totalEmpresa.cantPatrocinio, $scope.totalEmpresa.cantProvee , $scope.totalEmpresa.cantConsumo
        ];
      //  console.log($scope.totalEmpresa);
        if (!$scope.totalEmpresa.promConsumo) {
          $scope.totalEmpresa.promConsumo = 0;
        }
        if (!$scope.totalEmpresa.promPatrocinio) {
          $scope.totalEmpresa.promPatrocinio = 0; 
        }
        if (!$scope.totalEmpresa.promProvee) {
          $scope.totalEmpresa.promProvee = 0; 
        }
        $scope.dataUsuario = [$scope.totales.empresas, $scope.totales.participantes, $scope.totales.agrupaciones];
     	
     //   $scope.cargarSkills();
     //   console.log($scope.totales);
        $scope.tipo = 1;
        $scope.initMap(1);
      //  $scope.graficaEmpresa();
      });
    }

    $scope.actAll = function(){
      $http({
          url: path + 'dashboard/act',
          method: 'get',
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.actividades = response.actividad;
        $scope.totales = response.totales;
        $scope.totales.palco = $scope.numberFormat($scope.totales.palco.toString());
        $scope.totales.calle = $scope.numberFormat($scope.totales.calle.toString());
        $scope.totalModalidad = response.modalidad;
        $scope.horas = response.horas;
        $scope.minutos = $scope.horas*60;
        //total de ingresos y egresos
        $scope.totalIngCos = response.ingCos;
        $scope.totalIngCos.costosxhora = $scope.totalIngCos.totalCostos/$scope.horas;
        $scope.totalIngCos.ingresosxhora = $scope.totalIngCos.totalIngresos/$scope.horas;
        $scope.totalIngCos.costosxminuto = $scope.totalIngCos.totalCostos/$scope.minutos;
        $scope.totalIngCos.ingresosxminuto = $scope.totalIngCos.totalIngresos/$scope.minutos;
        $scope.totalIngCos.costosxhora = $scope.numberFormat(Math.round($scope.totalIngCos.costosxhora).toString());
        $scope.totalIngCos.ingresosxhora = $scope.numberFormat(Math.round($scope.totalIngCos.ingresosxhora).toString());;
        $scope.totalIngCos.costosxminuto = $scope.numberFormat(Math.round($scope.totalIngCos.costosxminuto).toString());;
        $scope.totalIngCos.ingresosxminuto = $scope.numberFormat(Math.round($scope.totalIngCos.ingresosxminuto).toString());;
        $scope.totalIngCos.costosxact = $scope.numberFormat($scope.totalIngCos.costosxact.toString());
        $scope.totalIngCos.ingresosxact = $scope.numberFormat($scope.totalIngCos.ingresosxact.toString());
        $scope.totalIngCos.otrosCostos = $scope.numberFormat($scope.totalIngCos.otrosCostos.toString());
        $scope.totalIngCos.otrosIngresos = $scope.numberFormat($scope.totalIngCos.otrosIngresos.toString());
        $scope.totalIngCos.totalCostos = $scope.numberFormat($scope.totalIngCos.totalCostos.toString());
        $scope.totalIngCos.totalIngresos = $scope.numberFormat($scope.totalIngCos.totalIngresos.toString());
        
        //consumo de bebidas, snacks y comidas en palcos y calle
        $scope.totalConsumo = response.consumo;
        $scope.totalConsumo.bebidasPalco = $scope.numberFormat($scope.totalConsumo.bebidasPalco.toString());
        $scope.totalConsumo.bebidascalle = $scope.numberFormat($scope.totalConsumo.bebidascalle.toString());
        $scope.totalConsumo.comidasPalco = $scope.numberFormat($scope.totalConsumo.comidasPalco.toString());
        $scope.totalConsumo.comidascalle = $scope.numberFormat($scope.totalConsumo.comidascalle.toString());
        $scope.totalConsumo.snacksPalco = $scope.numberFormat($scope.totalConsumo.snacksPalco.toString());
        $scope.totalConsumo.snackscalle = $scope.numberFormat($scope.totalConsumo.snackscalle.toString());
        $scope.totalConsumo.totalBebidas = $scope.numberFormat($scope.totalConsumo.totalBebidas.toString());
        $scope.totalConsumo.totalCalle = $scope.numberFormat($scope.totalConsumo.totalCalle.toString());
        $scope.totalConsumo.totalPalco = $scope.numberFormat($scope.totalConsumo.totalPalco.toString());      
        $scope.totalConsumo.totalSnacks = $scope.numberFormat($scope.totalConsumo.totalSnacks.toString()); 
        $scope.totalConsumo.totalComidas = $scope.numberFormat($scope.totalConsumo.totalComidas.toString()); 
        
       // console.log($scope.totalConsumo);

        $scope.totalEmpresa = response.totalEmpresa;
        
        $scope.cantidadEmpleos = response.cantidadEmpleos;
        $scope.cantActividades = response.cantActividades;
        $scope.totalAgrupacion = response.totalAgrupacion;
        $scope.totalParticipante = response.totalParticipante;
        $scope.sum = response.sum; 
        $scope.cantSub = response.cantSub;
        $scope.capacidad = response.capacidad;
        $scope.capacidad = $scope.numberFormat($scope.capacidad.toString());
        $scope.cantidadEmpleos = $scope.numberFormat($scope.cantidadEmpleos.toString());
      //  $scope.sum.costos = $scope.numberFormat($scope.sum.costos.toString());
     //   $scope.sum.ingresos = $scope.numberFormat($scope.sum.ingresos.toString());
        $scope.sum.nempleados = $scope.numberFormat($scope.sum.nempleados.toString());
        $scope.sum.cantMujeres = $scope.numberFormat($scope.sum.cantMujeres.toString());
        $scope.sum.cantHombres = $scope.numberFormat($scope.sum.cantHombres.toString());
           
        /*datos de las barras*/
        $scope.totalEmpresa.totalGeneral = $scope.totalEmpresa.cantPatrocinio + $scope.totalEmpresa.cantProvee + $scope.totalEmpresa.cantConsumo;  
        $scope.totalEmpresa.promPatrocinio = ($scope.totalEmpresa.cantPatrocinio * 100) / $scope.totalEmpresa.totalGeneral;
        $scope.totalEmpresa.promPatrocinio = Math.round($scope.totalEmpresa.promPatrocinio);
        $scope.totalEmpresa.promProvee = ($scope.totalEmpresa.cantProvee * 100) / $scope.totalEmpresa.totalGeneral;
        $scope.totalEmpresa.promProvee = Math.round($scope.totalEmpresa.promProvee);
        $scope.totalEmpresa.promConsumo = ($scope.totalEmpresa.cantConsumo * 100) / $scope.totalEmpresa.totalGeneral;    
        $scope.totalEmpresa.promConsumo = Math.round($scope.totalEmpresa.promConsumo);
        $scope.cantEmpresas = [ $scope.totalEmpresa.cantPatrocinio, $scope.totalEmpresa.cantProvee , $scope.totalEmpresa.cantConsumo
        ];
        $scope.dataUsuario = [$scope.totales.empresas, $scope.totales.participantes, $scope.totales.agrupaciones];
     //   $scope.cargarSkills();
     //   console.log($scope.totales);
        $scope.tipo = 1;
        $scope.initMap(1);
      //  $scope.graficaEmpresa();
      });
    }


    var map;
    var markers = [];
    $scope.initMap = function(tipo) {
        var myLatlng = {lat: 10.4742449, lng: -73.2436335};

        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: myLatlng,
          mapTypeId: 'terrain'
        });

        //eventos
        if (tipo == 0) {
          for (var i = $scope.eventos.length - 1; i >= 0; i--) {
            var haightAshbury = {lat: parseFloat($scope.eventos[i].lat), lng: parseFloat($scope.eventos[i].lng)};
            $scope.addMarker(haightAshbury, $scope.eventos[i].descripcion, $scope.eventos[i].Direccion);
          }
    
        }
        //actividades
        if (tipo == 1) {
          for (var i = $scope.actividades.length - 1; i >= 0; i--) {
            var haightAshbury = {lat: parseFloat($scope.actividades[i].direccion.lat), lng: parseFloat($scope.actividades[i].direccion.lng)};
            $scope.addMarker(haightAshbury, $scope.actividades[i].nombre, $scope.actividades[i].direccion.direccion);
          }
        }
        //empresas
        if (tipo == 2) {
          for (var i = $scope.empresas.length - 1; i >= 0; i--) {
            var haightAshbury = {lat: parseFloat($scope.empresas[i].lat), lng: parseFloat($scope.empresas[i].lng)};
            $scope.addMarker(haightAshbury, $scope.empresas[i].nombre, $scope.empresas[i].direccion);
          }
        }
        //agrupaciones
        if (tipo == 3) {
          for (var i = $scope.agrupaciones.length - 1; i >= 0; i--) {
            var haightAshbury = {lat: parseFloat($scope.agrupaciones[i].lat), lng: parseFloat($scope.agrupaciones[i].lng)};
            var nombre = "" + $scope.agrupaciones[i].nombre+"- "+ $scope.agrupaciones[i].nombreGenero; 
            $scope.addMarker(haightAshbury, nombre, $scope.agrupaciones[i].direccion);
          }
        }
        //paticipantes
        if (tipo == 4) {
          for (var i = $scope.participantes.length - 1; i >= 0; i--) {
            var haightAshbury = {lat: parseFloat($scope.participantes[i].lat), lng: parseFloat($scope.participantes[i].lng)};
            var nombre = "" + $scope.participantes[i].nombre + " - " + $scope.participantes[i].profesion;
            $scope.addMarker(haightAshbury, nombre, $scope.participantes[i].direccion);
          }
        }
        //hoteles
        if (tipo == 5) {
          for (var i = $scope.hoteles.length - 1; i >= 0; i--) {
            var haightAshbury = {lat: parseFloat($scope.hoteles[i].lat), lng: parseFloat($scope.hoteles[i].lng)};
            $scope.addMarker(haightAshbury, $scope.hoteles[i].nombre, $scope.hoteles[i].direccion);
          }
        }
        //restaurantes
        if (tipo == 6) {
          for (var i = $scope.restaurantes.length - 1; i >= 0; i--) {
            var haightAshbury = {lat: parseFloat($scope.restaurantes[i].lat), lng: parseFloat($scope.restaurantes[i].lng)};
            $scope.addMarker(haightAshbury,  $scope.restaurantes[i].nombre, $scope.restaurantes[i].direccion);
          }
        }
        //lugares
        if (tipo == 7) {
          for (var i = $scope.lugares.length - 1; i >= 0; i--) {
            var haightAshbury = {lat: parseFloat($scope.lugares[i].lat), lng: parseFloat($scope.lugares[i].lng)};
            $scope.addMarker(haightAshbury, $scope.lugares[i].nombre, $scope.lugares[i].direccion);
          }
        }
    }

    $scope.addMarker = function(location, nombre, direccion) {

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
          map: map
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
        markers.push(marker);
    }

    $scope.deleteMarkers = function() {
      clearMarkers();
      markers = [];
    }


  /*-------------------FIN DEL MAPA---------------------*/

  /*--------------datos de un usuario del evento-------------------*/

  $scope.allUser = function(){
    //trae todas las actividades por evento
    $http({
        url: path + 'actividad/evento',
        method: 'get',
        params:{
          idEvento: $rootScope.user.idEvento //aqui se supone va el id del evento seleccionado 
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.actividades = response.actividad;
     // console.log($scope.actividades);
      $scope.initMap2();
    });

    //buscar totales
    $http({
        url: path + 'act/reporte',
        method: 'get',
        params:{
          idEvento: $rootScope.user.idEvento //aqui se supone va el id del evento seleccionado 
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.totalActividades = response.total;
   //   console.log($scope.totalActividades);
    });
  }
  var map2;
  var markers2 = [];
  $scope.initMap2 = function() {
      var haightAshbury = {lat: 10.4742449, lng: -73.2436335};

      //var haightAshbury = {lat: 37.769, lng: -122.446};

        map2 = new google.maps.Map(document.getElementById('map2'), {
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

   $scope.allPresupuesto = function(){
    $scope.subCosto = 0;
    $scope.subImpuesto = 0;
    $scope.subIngreso = 0;
    $scope.neto = 0;
    $scope.resta = 0;
    $scope.sinImpuesto = 0;
    $scope.costoxact = 0;
    $scope.porcCostoxact = 0;
    $scope.otrosCostos = 0;
    $scope.porcOtrosCostos = 0;
    $scope.ingresoxact = 0;
    $scope.porcIngresoxact = 0;
    $scope.otrosIngresos = 0;
    $scope.porcOtrosIngresos = 0;
    $scope.porcCosto = 0;
    $scope.porcIngreso = 0;
    
    $http({
        url: path + 'presupuesto/all',
        method: 'get',
        params:{
          idEvento: $rootScope.user.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.costos = response.presupuestoCosto;
      $scope.ingresos = response.presupuestoIngreso;
   //   console.log($scope.costos.length, $scope.ingresos.length);
      //sumo el total de costos e impuestos
      angular.forEach($scope.costos, function (value, key){
          $scope.subCosto += value.costo;
          value.costo2 = $scope.numberFormat(value.costo.toString());
          //console.log(value);
          if (value.tipo == 2) {// 2 porque el dos es tipo impuesto
           $scope.subImpuesto += value.costo;
          }
          //si es actvidad
          if(value.tipo == 0){
            $scope.costoxact += value.costo;  
          }else{
            $scope.otrosCostos += value.costo;
          }
          /*if (value.tipo == 2) {// 2 porque el dos es tipo impuesto
            $scope.subImpuesto += value.costo;
          }*/
      });
    
      $scope.data = [$scope.costoxact, $scope.otrosCostos];
      $scope.costoxact2 = $scope.numberFormat($scope.costoxact.toString());
      $scope.otrosCostos2 = $scope.numberFormat($scope.otrosCostos.toString());
      //sumo el total de ingresos
      angular.forEach($scope.ingresos, function (value, key){
          $scope.subIngreso += value.costo;
          value.costo2 = $scope.numberFormat(value.costo.toString());
          //si es actvidad
          if(value.tipo == 0){
            $scope.ingresoxact += value.costo;  
          }else{
            $scope.otrosIngresos += value.costo;
          }
      });
       $scope.data2 = [$scope.ingresoxact, $scope.otrosIngresos];
       $scope.data3 = [[$scope.subCosto], [$scope.subIngreso]];

      $scope.subCosto2 = $scope.numberFormat($scope.subCosto.toString());
      $scope.ingresoxact2 = $scope.numberFormat($scope.ingresoxact.toString());
      $scope.otrosIngresos2 = $scope.numberFormat($scope.otrosIngresos.toString());
      $scope.subIngreso2 = $scope.numberFormat($scope.subIngreso.toString());
      //calculo de los porcentajes 
      $scope.porcCostoxact = ($scope.costoxact * 100) / $scope.subCosto;
      $scope.porcCostoxact = Math.round($scope.porcCostoxact);
      $scope.porcOtrosCostos = ($scope.otrosCostos * 100) / $scope.subCosto;
      $scope.porcOtrosCostos = Math.round($scope.porcOtrosCostos);

      $scope.porcIngresoxact = ($scope.ingresoxact * 100) / $scope.subIngreso;
      $scope.porcIngresoxact = Math.round($scope.porcIngresoxact);
      $scope.porcOtrosIngresos = ($scope.otrosIngresos * 100) / $scope.subIngreso;
      $scope.porcOtrosIngresos = Math.round($scope.porcOtrosIngresos);

      $scope.suma = $scope.subIngreso + $scope.subCosto;
      $scope.porcCosto = ($scope.subCosto * 100) / $scope.suma;
      $scope.porcCosto = Math.round($scope.porcCosto);    
      $scope.porcIngreso = ($scope.subIngreso * 100) / $scope.suma;
      $scope.porcIngreso = Math.round($scope.porcIngreso);
      //calculo el total ingresos - costos (Margen)
      $scope.neto =  $scope.subIngreso - $scope.subCosto;
      $scope.neto =  Math.round(($scope.neto/$scope.subIngreso)*100);
      $scope.neto2 = $scope.numberFormat($scope.neto.toString());
      //el calculo del total sin los impuestos
      $scope.resta = $scope.subCosto - $scope.subImpuesto;
      $scope.sinImpuesto = $scope.subIngreso - $scope.resta;
    //  $scope.cargarGrafica();      
    });
  }

  $scope.numberFormat = function (numero){
    // Variable que contendra el resultado final
    var resultado = "";
    var nuevoNumero = "";

    // Si el numero empieza por el valor "-" (numero negativo)
    if(numero[0]=="-")
    {
        // Cogemos el numero eliminando los posibles puntos que tenga, y sin
        // el signo negativo
        nuevoNumero = numero.replace(/\./g,'').substring(1);
    }else{
        // Cogemos el numero eliminando los posibles puntos que tenga
        nuevoNumero= numero.replace(/\./g,'');
    }

    // Si tiene decimales, se los quitamos al numero
    if(numero.indexOf(",")>=0)
        nuevoNumero=nuevoNumero.substring(0,nuevoNumero.indexOf(","));

    // Ponemos un punto cada 3 caracteres
    for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++)
        resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0)? ".": "") + resultado;

    // Si tiene decimales, se lo añadimos al numero una vez forateado con 
    // los separadores de miles
    if(numero.indexOf(",")>=0)
        resultado +=numero.substring(numero.indexOf(","));

    if(numero[0]=="-")
    {
        // Devolvemos el valor añadiendo al inicio el signo negativo
      return "-"+resultado;
    }else{
  
        return resultado;
    }
  }

  $scope.junta = function(){
    //buscar totales
    $http({
        url: path + 'junta/count',
        method: 'get',
        params:{
          idEvento: $rootScope.user.idEvento //aqui se supone va el id del evento seleccionado 
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.totaljunta = response.junta;     
      
    });
  }

  /*---------------fin del usuario del evento----------------------*/

  if ($rootScope.user.tipo != 5) {
    $scope.buscarDepartamento();  
    $scope.actAll();
    $scope.empresasAll();
    $scope.agrupacionesAll();
    $scope.participantesAll();
    $scope.hotelesAll();
    $scope.restaurantesAll();
    $scope.lugaresAll();
    $scope.allEvent();
    $scope.medioambientalAll();
    $scope.actTipo();   

  
  }else{
    $scope.allUser();
    $scope.allPresupuesto();
    $scope.junta();
    //$scope.medioambientalAll();
    $scope.medioambiental();
    $scope.actTipo();    
  }
  
 

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
