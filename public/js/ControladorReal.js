'use strict';
 
angular.module('myApp.PresupuestoReal', ['ngRoute'])
 
// Declared route  
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/real', {
        templateUrl: 'pages/Presupuesto/real.html',
        controller: 'PresupuestoRealCtrl'
    });
}])

// Home controller
.controller('PresupuestoRealCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  if (!$rootScope.evento) {
    window.location.href = '#/evento';
  }
  $scope.ver = false;
  //console.log($rootScope.evento);
  //declaracion de variables
  $scope.costos ={};
  $scope.ingresos = {};
  $scope.actividades ={};
  $scope.subsidio = 0;
  $scope.series = ['Presupuesto', 'Real'];
  $scope.labels = ['Ingresos', 'Costos'];
  $scope.colores = [{'color': '#00EAB5'}, {'color' : '#FF6C00'}, {'color' : '#00ABF8'}, {'color' : '#F24B45'}, {'color' : '#D03B43'}, {'color' : '#AB313E'}, {'color' : '#503140'}, {'color' : '#322E3F'}];



  /*---------------------FIN DE PRUEBA CHART--------------------*/
  //check de subsidio
  $scope.chequea = function(){
    if ($scope.subsidio == 1) {
      $scope.subsidio = 0;      
    }else{
      $scope.subsidio = 1;
    }
  }
  /*--------------------COSTOS PROVEEDOR--------------------------------------------*/

  //seleccionar el costo al que se le va a agregar o eliminar proveedores y trae los que ya tenia
  $scope.selectCosto = function(costo){
    console.log(costo);
    $scope.costoSeleccionado = costo;
    $scope.allCosto();
  }

  //Selecciona si se eliminara un proveedor o un consumidor 
  $scope.seleccionEliminar = function(id , tipo){
    $scope.idSeleccion = id;
    $scope.tipoSeleccion = tipo;
  }
  //Actualiza el costo dentro de la actividad
  $scope.updateCostoAct = function(act) {

    $http({
        url: path + 'costoprovee/update',
        method: 'get',
        params:{
          idActividad: act.idActividad,
          costoReal: act.costoReal
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      $scope.all();
    });
  }
  //guarda el proveedor de costo
  $scope.guardarCosto = function(){
    
    $scope.costoProvee = $scope.costoProvee.replace(/\./g,'');
    $scope.costoProvee = parseInt($scope.costoProvee); 
    console.log($scope.costoProvee); 
    $http({
        url: path + 'costoprovee/create',
        method: 'get',
        params:{
          idCosto: $scope.costoSeleccionado.idCosto,
          idProveedor: $scope.empresaSeleccionada,
          costo: $scope.costoProvee,
          subsidio: $scope.subsidio
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
      $scope.allCosto();
      $scope.all();
      //limpiar las variables
      $scope.costoSeleccionado.idCosto = '';
      $scope.empresaSeleccionada = '';
      $scope.costoProvee = '';   
    });    
  }

  //elimina un costo provee
  $scope.eliminarCosto = function(id){
    $http({
        url: path + 'costoprovee/delete',
        method: 'get',
        params:{
          idCosto: id
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
      $scope.allCosto();
      $scope.all();
    }); 
  }

  //trae todos los costos provee
  $scope.allCosto = function(){
    $http({
        url: path + 'costoprovee/all',
        method: 'get',
        params:{
          idCosto: $scope.costoSeleccionado.idCosto
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.costosprovee = response.costos;
      console.log($scope.costosprovee);
      
      angular.forEach($scope.costosprovee, function (value, key){
          value.costo2 = $scope.numberFormat(value.costo.toString());
      });
      
    }); 
  }
  /*--------------------------FIN COSTO PROVEEDOR--------------------------------------*/

  /*-----------------------------INGRESO CONSUMIDORES --------------------------------*/

  //seleccionar el ingreso al que se le va a agregar o eliminar consumidores y trae los que ya tenia
  $scope.selectIngreso = function(ingreso){
    $scope.ingresoSeleccionado = ingreso;
    $scope.allIngreso();
  }

  //guarda el consumidor de ingreso
  $scope.guardarIngreso = function(){

    $scope.costoConsume = $scope.costoConsume.replace(/\./g,'');
    $scope.costoConsume = parseInt($scope.costoConsume); 
    $http({
        url: path + 'ingresoconsume/create',
        method: 'get',
        params:{
          idIngreso: $scope.ingresoSeleccionado.idIngreso,
          idConsumidor: $scope.empresaSeleccionada,
          costo: $scope.costoConsume
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      $scope.allIngreso();
      $scope.all();
      //limpiar las variables
      $scope.ingresoSeleccionado.idIngreso = '';
      $scope.empresaSeleccionada = '';
      $scope.costoConsume = '';   
    });    
  }

  //elimina un costo provee o un ingreso consume
  $scope.eliminarCoI = function(id){
    var ruta;
    if ($scope.tipoSeleccion == 1) {
      ruta = 'costoprovee/delete';
    }else{
      ruta = 'ingresoconsume/delete';
    }

    $http({
        url: path + ruta,
        method: 'get',
        params:{
          id: $scope.idSeleccion
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      $scope.all();
       if ($scope.tipoSeleccion == 1) {
          $scope.allCosto();
        }else{
          $scope.allIngreso();
        }
      
    }); 
  }

  //trae todos los costos provee
  $scope.allIngreso = function(){
    $http({
        url: path + 'ingresoconsume/all',
        method: 'get',
        params:{
          idIngreso: $scope.ingresoSeleccionado.idIngreso
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.ingresosConsumidores = response.ingresos;
      console.log($scope.ingresosConsumidores);
      angular.forEach($scope.ingresosConsumidores, function (value, key){
          value.costo2 = $scope.numberFormat(value.costo.toString());
      });
      
      
    }); 
  }
  /*--------------------------FIN INGRESO CONSUMIDORES--------------------------------------*/

  /*-------------------------ACTIVIDADES PALCOS --------------------------------------------*/
  
  //seleccionar la actividad a la que se le va a gestionar los palcos
  $scope.selectActividad = function(actividad){
    $scope.actividadSeleccionada = actividad;
    console.log($scope.actividadSeleccionada);
    $scope.allPalco();
  }

  //guarda los datos de los palcos
  $scope.guardarPalco = function(actividad){
 
     $http({
        url: path + 'actpalco/update',
        method: 'get',
        params:{
          actividad: actividad
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
        $scope.all();
      //alert('¡Se Guardo con exito!');
      //llamar a cargar todo de nuevo   
    });   
  }
  
  //guarda los costos reales de una actividad
  $scope.guardarCostoPalco = function(actividad){
  	alert('guardarPalco');
    console.log(actividad);
    $http({
        url: path + 'actcosto/update',
        method: 'get',
        params: actividad,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
        $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
        $scope.all();
      //alert('¡Se Guardo con exito!');
      //llamar a cargar todo de nuevo   
    });    
  }

  //trae todos los palcos de la actividad
  $scope.allPalco = function(){
    $http({
        url: path + 'actpalco/all',
        method: 'get',
        params:{
          idActividad: $scope.actividadSeleccionada.idActividad
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.actPalco = response.actividad;
      console.log($scope.actPalco);
       
    }); 
  }
  /*---------------------------FIN ACTIVIDADES PALCOS --------------------------------------*/
  
  

  //trae todo el presupuesto del evento seleccionado
  $scope.all = function(){
    //alert('all');
    $scope.costoPresupuesto = 0;
    $scope.costoReal = 0;
    $scope.ingresoPresupuesto = 0;
    $scope.ingresoReal = 0;
    $scope.totalCP = 0;
    $scope.totalCR = 0;
    $scope.totalIP = 0;
    $scope.totalIR = 0;
    $scope.totalACP = 0;
    $scope.totalACR = 0;
    $scope.totalAIP = 0;
    $scope.totalAIR = 0;


    $http({
        url: path + 'real/all',
        method: 'get',
        params:{
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {

      $scope.costos = response.costos;
      $scope.ingresos = response.ingresos;
      $scope.actividades = response.actividades;
      console.log($scope.actividades);

      $scope.ver = true;
      //sumar todos los totales 
      angular.forEach($scope.costos, function (value, key){
          $scope.costoPresupuesto += value.costo;
          value.costo2 = $scope.numberFormat(value.costo.toString());
          $scope.costoReal += value.costoReal;
          value.costoReal2 = $scope.numberFormat(value.costoReal.toString());
          $scope.totalCP += value.costo;
          $scope.totalCP2 = $scope.numberFormat($scope.totalCP.toString());
          $scope.totalCR += value.costoReal;
          $scope.totalCR2 = $scope.numberFormat($scope.totalCR.toString());
      });

      angular.forEach($scope.ingresos, function (value, key){
          $scope.ingresoPresupuesto += value.costo;
          value.costo2 = $scope.numberFormat(value.costo.toString());
          $scope.ingresoReal += value.ingresoReal;
          value.ingresoReal2 = $scope.numberFormat(value.ingresoReal.toString());
          $scope.totalIP += value.costo;
          $scope.totalIP2 = $scope.numberFormat($scope.totalIP.toString());
          $scope.totalIR += value.ingresoReal;
          $scope.totalIR2 = $scope.numberFormat($scope.totalIR.toString());
      });

      angular.forEach($scope.actividades, function (value, key){
          $scope.costoPresupuesto += value.costo;
          value.costo2 = $scope.numberFormat(value.costo.toString());
          value.costoReal2 = $scope.numberFormat(value.costoReal.toString());
          value.ingresoPresupuesto2 = $scope.numberFormat(value.ingresoPresupuesto.toString());
          value.ingresoReal2 = $scope.numberFormat(value.ingresoReal.toString());
          $scope.costoReal += value.costoReal;
          $scope.ingresoPresupuesto += value.ingresoPresupuesto;
          $scope.ingresoReal += value.ingresoReal;
          $scope.totalACP += value.costo;
          $scope.totalACP2 = $scope.numberFormat($scope.totalACP.toString());
          $scope.totalACR += value.costoReal;
          $scope.totalACR2 = $scope.numberFormat($scope.totalACR.toString());
          $scope.totalAIP += value.ingresoPresupuesto;
          $scope.totalAIP2 = $scope.numberFormat($scope.totalAIP.toString());
          $scope.totalAIR += value.ingresoReal;
          $scope.totalAIR2 = $scope.numberFormat($scope.totalAIR.toString());
      });
      //console.log($scope.costos, $scope.ingresos, $scope.actividades);
      //PRESUPUESTO
      $scope.costoPresupuesto2 = $scope.numberFormat($scope.costoPresupuesto.toString());
      $scope.ingresoPresupuesto2 = $scope.numberFormat($scope.ingresoPresupuesto.toString());
      $scope.margenPresupuesto =  $scope.ingresoPresupuesto - $scope.costoPresupuesto;
      $scope.margenPresupuesto = Math.round(($scope.margenPresupuesto/$scope.ingresoPresupuesto)*100);
      $scope.margenPresupuesto = $scope.numberFormat($scope.margenPresupuesto.toString());

      //REAL
      $scope.costoReal2 = $scope.numberFormat($scope.costoReal.toString());
      $scope.ingresoReal2 = $scope.numberFormat($scope.ingresoReal.toString());
      $scope.margenReal = $scope.ingresoReal - $scope.costoReal;
      $scope.margenReal = Math.round(($scope.margenReal/$scope.ingresoReal)*100);
      if ($scope.margenReal) {
        $scope.margenReal = $scope.numberFormat($scope.margenReal.toString());
      }else{
        $scope.margenReal = 0;  
      }
      
      $scope.data = [
        [$scope.costoPresupuesto, $scope.costoReal],
        [$scope.ingresoPresupuesto, $scope.ingresoReal]
      ];
       
       setTimeout(function(){ $scope.cargarBarChart(); }, 2000);
 
    });
  }



    $scope.cargarBarChart = function(){
    console.log($scope.costoPresupuesto, $scope.costoReal , $scope.ingresoPresupuesto, $scope.ingresoReal ); 

    var areaChartData = {
      labels: ["Egresos" , "Ingresos"],
      datasets: [
        {
          label: "Egresos",
          fillColor: "rgba(255, 108, 0, 1)",
          strokeColor: "rgba(255, 108, 0, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [$scope.costoPresupuesto, $scope.costoReal]
        },
        {
          label: "Ingresos",
          fillColor: "rgba(0, 234, 181, 1)",
          strokeColor: "rgba(0, 234, 181, 1)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [$scope.ingresoPresupuesto, $scope.ingresoReal]
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


  //trae todas las empresas
  $http({
      url: path + 'empresa/all',
      method: 'get',
      headers: {
          "Content-Type": "application/json"
      }
  }).success(function (response) {
    $scope.empresas = response.empresa;
    console.log($scope.empresas);
  });
  
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
    $("#costoprovee").on({
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
    $("#costoconsume").on({
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


  //llamadas por defecto
  $scope.all();
  
}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
