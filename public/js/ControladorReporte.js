'use strict';
 
angular.module('myApp.Reporte', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/reporte', {
        templateUrl: 'pages/Reporte/reporte.html',
        controller: 'ReporteCtrl'
    });
}])

// Home controller
.controller('ReporteCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  if (!$rootScope.evento) {
    window.location.href = '#/evento';
  }
  $scope.ver = false;
  //console.log($rootScope.evento.idEvento);
  //console.log($rootScope.filtroReporte);
  $scope.labels2 = [];//Niveles academicos
  $scope.data2 = [];//Niveles academicos
  $scope.labels3 = [];//Cargos
  $scope.data3 = [];//Cargos
  $scope.labels4 = [];//Actividades Modalidad Cantidad
  $scope.data4 = [];//Actividades Modalidad Cantidad
  $scope.labels5 = []; //Actividades Modalidad Horas
  $scope.data5 = [];//Actividades Modalidad Horas
  $scope.labels6 = []; //Actividades Tipo Cantidad
  $scope.data6 = [];//Actividades Tipo Cantidad
  $scope.labels7 = []; //Actividades Tipo Horas
  $scope.data7 = [];//Actividades Tipo Horas
  $scope.labels8 = ['', ''];
  $scope.labels9 = []; //Empleos generados
  $scope.data8 = [];//Empleos generados
  $scope.labels10 = []; //Empresas
  $scope.data9 = [];//Empresas
  $scope.labels11 = []; //Arreglo de kilos en el area medioambiental
  $scope.data10 = [];//Arreglo de kilos en el area medioambiental
  $scope.mostrarTab = 0;//mostrar la primera opcion del tab de ingresos
  $scope.mostrarTab2 = 0;//mostrar la primera opcion del tab de costos
  $scope.colores = [{'color': '#00EAB5'}, {'color' : '#FF6C00'}, {'color' : '#00ABF8'}, {'color' : '#F24B45'}, {'color' : '#D03B43'}, {'color' : '#AB313E'}, {'color' : '#503140'}, {'color' : '#322E3F'}];
  
  
  $scope.graficaIngreso = function(act, otros){
      var dataIngreso = {
      labels: ["Ingresos"],
      datasets: [
          {
            label: "Actividad",
            fillColor: "#00eab5",
            strokeColor: "#00eab5",
            pointColor: "#00eab5",
            pointStrokeColor: "#00eab5",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#00eab5",
            data: [act]
          },
          {
            label: "Otros",
            fillColor: "#ff6c00",
            strokeColor: "#ff6c00",
            pointColor: "#ff6c00",
            pointStrokeColor: "#ff6c00",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#ff6c00",
            data: [otros]
          }
        ]
      };

      //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChartIngreso").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = dataIngreso;
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

  $scope.graficaEgreso = function(act, otros){
      var dataEgreso = {
      labels: [""],
      datasets: [
          {
            label: "Actividad",
            fillColor: "#00eab5",
            strokeColor: "#00eab5",
            pointColor: "#00eab5",
            pointStrokeColor: "#00eab5",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#00eab5",
            data: [act]
          },
          {
            label: "Otros",
            fillColor: "#ff6c00",
            strokeColor: "#ff6c00",
            pointColor: "#ff6c00",
            pointStrokeColor: "#ff6c00",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#ff6c00",
            data: [otros]
          }
        ]
      };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChartEgreso").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = dataEgreso;
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
  $scope.colorRandom = function(){
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;

  }

  //Cambiar tab Ingresos
  $scope.tab = function(seleccionado){
    //alert(seleccionado);
    $scope.mostrarTab = seleccionado;    
  }

  //Cambiar tab Costos
  $scope.tab2 = function(seleccionado){
    //alert(seleccionado);
    $scope.mostrarTab2 = seleccionado;    
  }

  $scope.allPoblacion = function(){
    $http({
        url: path + 'poblacion/reporte',
        method: 'get',
        params: {
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.poblacion = response.poblacion;
      $scope.totalMujeres = response.mujeres;
      $scope.totalHombres = response.hombres;
      $scope.totalPoblacion = response.total;
      $scope.aforo = response.aforo;
      $scope.circulante = response.circulante;
      $scope.objetivo = response.objetivo;
      //console.log($scope.poblacion);
      //llena la grafica
      $scope.labels = ['0 a 18', '19 a 64', '>64', 'Indigena', 'Afrocolombiana', 'Razial', 'Rom' , 'Mestiza' , 'Palanquera' , 'Desplazados' , 'Discapacitados' , 'Victimas'];
      $scope.series = ['Hombres', 'Mujeres'];
      $scope.data = [[$scope.poblacion._0a18M, $scope.poblacion._19a64M, $scope.poblacion.mayor64M, $scope.poblacion.indigenaM, $scope.poblacion.afroColombianaM, $scope.poblacion.raizalM, $scope.poblacion.puebloRomM, $scope.poblacion.mestizaM, $scope.poblacion.palenqueraM, $scope.poblacion.despalzadosM, $scope.poblacion.discapacitadosM, $scope.poblacion.victimasM],[$scope.poblacion._0a18H, $scope.poblacion._19a64H, $scope.poblacion.mayor64M, $scope.poblacion.indigenaH, $scope.poblacion.afroColombianaH, $scope.poblacion.raizalH, $scope.poblacion.puebloRomH, $scope.poblacion.mestizaH, $scope.poblacion.palenqueraH, $scope.poblacion.despalzadosH, $scope.poblacion.discapacitadosH, $scope.poblacion.victimasH]];

    });
  }

  $scope.allJunta = function(){
    $http({
        url: path + 'junta/reporte',
        method: 'get',
        params: {
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.poblacionJunta = response.poblacion;
      console.log($scope.poblacionJunta);
      $scope.mujeresJunta = response.mujeres;
      $scope.hombresJunta = response.hombres;
      $scope.cargos = response.cargos;
      $scope.niveles = response.nivel;
      $scope.dataCargo = [];
      $scope.dataNivel =[];

      angular.forEach($scope.niveles, function (value, key){
        $scope.prueba = {
          value: value.cantidad,
          color: value.color,
          highlight: value.color,
          label: value.nombre,
          porcentaje: (value.cantidad*100)/$scope.poblacionJunta.cantidad
        }
        $scope.labels2.push(value.nombre);
        $scope.data2.push(value.cantidad);
        $scope.dataNivel.push($scope.prueba);
    
      });
      var index = 0;
      console.log($scope.poblacionJunta.cantidad);

      angular.forEach($scope.cargos, function (value, key){
        console.log(value);
        $scope.color = $scope.colores[index].color;
        index +=  1;
        if (index == 8 ) {
          index = 0;
        }
        value.color = $scope.color;
        if (value.cantidad) {
          $scope.prueba = {
            value: value.cantidad,
            color: $scope.color,
            highlight: $scope.color,
            label: value.nombre,
            porcentaje: (value.cantidad*100)/$scope.poblacionJunta.cantidad
          }
          $scope.labels3.push(value.nombre);
          $scope.data3.push(value.cantidad);
          $scope.dataCargo.push($scope.prueba);
          console.log($scope.prueba);  
        }
        

      });
      //console.log($scope.cargos, $scope.niveles);
   
    });
  }

  /* parte socioeconomico por horas y por minuto*/
  $scope.porTiempo = function(){
    //calcular cuantos minutos
    //console.log($scope.subIngreso);
    if ($scope.total.horas !=0) {
      $scope.minutos = $scope.total.horas *60;
      $scope.ingresoxhoras = $scope.subIngreso/$scope.total.horas;
      $scope.ingresoxminutos = $scope.subIngreso/$scope.minutos;
      $scope.costoxhoras = $scope.subCosto/$scope.total.horas;
      $scope.costoxminutos = $scope.subCosto/$scope.minutos;
      //redondear y colocarle los puntos
      $scope.ingresoxhoras = $scope.numberFormat(Math.round($scope.ingresoxhoras).toString());
      $scope.ingresoxminutos = $scope.numberFormat(Math.round($scope.ingresoxminutos).toString());
      $scope.costoxhoras = $scope.numberFormat(Math.round($scope.costoxhoras).toString());
      $scope.costoxminutos = $scope.numberFormat(Math.round($scope.costoxminutos).toString());  
    }else{
      $scope.ingresoxhoras = 0;
      $scope.ingresoxminutos = 0;
      $scope.costoxhoras = 0;
      $scope.costoxminutos = 0;
    }
    
    //console.log($scope.ingresoxhoras, $scope.ingresoxminutos, $scope.costosxhoras, $scope.costoxminutos);
    
  }

  $scope.allActividad = function(){
    $http({
        url: path + 'actividad/reporte',
        method: 'get',
        params: {
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.total = response.total;
      //console.log($scope.total);
      //calcular el valor del ingreso y costo por horas y minutos
      $scope.allImpuestoCosto();
      $scope.modalidad = response.modalidad;
      $scope.tipo = response.tipo;
      //console.log($scope.total);
      $scope.modalidadH = [];
      $scope.modalidadC = [];
      $scope.tipoH = [];
      $scope.tipoC = [];
      var index = 0;
      angular.forEach($scope.modalidad, function (value, key){
        $scope.color = $scope.colores[index].color;
          index +=  1;
          if (index == 8 ) {
            index = 0;
        } 
        value.color = $scope.color;
        if (value.cantidad) {
          $scope.c = {
            value: value.cantidad,
            color: value.color,
            highlight: value.color,
            label: value.nombre
          }
          $scope.h = {
            value: value.horas,
            color: value.color,
            highlight: value.color,
            label: value.nombre
          }
          $scope.labels4.push(value.nombre);
          $scope.data4.push(value.cantidad);
          $scope.labels5.push(value.nombre);
          $scope.data5.push(value.horas);
          $scope.modalidadH.push($scope.h);
          $scope.modalidadC.push($scope.c);
        }
        
      });

      var index = 0;
      angular.forEach($scope.tipo, function (value, key){
        $scope.color = $scope.colores[index].color;
          index +=  1;
          if (index == 8 ) {
            index = 0;
        } 
        value.color = $scope.color;
        $scope.c = {
          value: value.cantidad,
          color: value.color,
          highlight: value.color,
          label: value.nombre
        }
        $scope.h = {
          value: value.horas,
          color: value.color,
          highlight: value.color,
          label: value.nombre
        }
        $scope.labels6.push(value.nombre);
        $scope.data6.push(value.cantidad);
        $scope.labels7.push(value.nombre);
        $scope.data7.push(value.horas);
        $scope.tipoH.push($scope.h);
        $scope.tipoC.push($scope.c);
  
        
      });
      //console.log($scope.modalidadH, $scope.modalidadC);
    
    });
    
  }

  $scope.allSocio = function(){
    $http({
        url: path + 'socio/reporte',
        method: 'get',
        params: {
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.totalEmpleo = response.empleos;
      $scope.totalEmpresa = response.empresas;
      $scope.empleos = [];
      $scope.h = {
        value: $scope.totalEmpleo.hombres,
        color: '#3c8dbc',
        highlight: '#3c8dbc',
        label: 'Hombres',
        porcentaje: $scope.totalEmpleo.porcHombre
      }
      $scope.m = {
        value: $scope.totalEmpleo.mujeres,
        color: '#f33bd4',
        highlight: '#f33bd4',
        label: 'Mujeres',
        porcentaje: $scope.totalEmpleo.porcMujer
      }

      $scope.empleos.push($scope.h);
      $scope.empleos.push($scope.m);
  
      $scope.labels9 = ["Hombres", "Mujeres"];
      $scope.data8 = [$scope.h.value, $scope.m.value];
      
      $scope.dataEmpresa = [
        {
          value: $scope.totalEmpresa.provee,
          color: "#f56954",
          highlight: "#f56954",
          label: "Prestadora de Servicios"
        },
        {
          value: $scope.totalEmpresa.patrocinio,
          color: "#00a65a",
          highlight: "#00a65a",
          label: "Patrocinadoras"
        },
        {
          value: $scope.totalEmpresa.consumo,
          color: "#f39c12",
          highlight: "#f39c12",
          label: "Consumidoras"
        }
      ];
      $scope.labels10 = ["Prestadora de Servicios", "Patrocinadoras", "Consumidoras"];
      $scope.data9 = [$scope.totalEmpresa.provee, $scope.totalEmpresa.patrocinio , $scope.totalEmpresa.consumo ];
      
      //console.log($scope.data9);
      
    });
  }

  //trae todo el presupuesto del evento seleccionado
  $scope.allImpuestoCosto = function(){
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
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.costos = response.presupuestoCosto;
      $scope.ingresos = response.presupuestoIngreso;
      //console.log($scope.ingresos);
      $scope.ver = true;
      //sumo el total de costos e impuestos
      angular.forEach($scope.costos, function (value, key){
          $scope.subCosto += value.costo;
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
      });
       $scope.totalCostos = [//Gráfica de barras de costos
        [$scope.costoxact],
        [$scope.otrosCostos]
      ];
      $scope.costoxact2 = $scope.numberFormat($scope.costoxact.toString());
      $scope.otrosCostos2 = $scope.numberFormat($scope.otrosCostos.toString());
      $scope.subCosto2 = $scope.numberFormat($scope.subCosto.toString());
      //sumo el total de ingresos
      angular.forEach($scope.ingresos, function (value, key){
          $scope.subIngreso += value.costo;
          //si es actvidad
          if(value.tipo == 0){
            $scope.ingresoxact += value.costo;  
          }else{
            $scope.otrosIngresos += value.costo;
          }
      });
    
      $scope.totalIngresos = [//Gráfica de barras de ingresos
        [$scope.ingresoxact],
        [$scope.otrosIngresos]
      ];

      $scope.ingresoxact2 = $scope.numberFormat($scope.ingresoxact.toString());
      $scope.otrosIngresos2 = $scope.numberFormat($scope.otrosIngresos.toString());
      $scope.subIngreso2 = $scope.numberFormat($scope.subIngreso.toString());
      //calculo de los porcentajes 
      $scope.porcCostoxact = ($scope.costoxact * 100) / $scope.subCosto;
      $scope.porcCostoxact = Math.round($scope.porcCostoxact);
      $scope.porcCostoxact2 = $scope.numberFormat($scope.porcCostoxact.toString());
      $scope.porcOtrosCostos = ($scope.otrosCostos * 100) / $scope.subCosto;
      $scope.porcOtrosCostos = Math.round($scope.porcOtrosCostos);
      $scope.porcOtrosCostos2 = $scope.numberFormat($scope.porcOtrosCostos.toString());
      $scope.porcIngresoxact = ($scope.ingresoxact * 100) / $scope.subIngreso;
      $scope.porcIngresoxact = Math.round($scope.porcIngresoxact);
      $scope.porcIngresoxact2 = $scope.numberFormat($scope.porcIngresoxact.toString());
      $scope.porcOtrosIngresos = ($scope.otrosIngresos * 100) / $scope.subIngreso;
      $scope.porcOtrosIngresos = Math.round($scope.porcOtrosIngresos);
      $scope.porcOtrosIngresos2 = $scope.numberFormat($scope.porcOtrosIngresos.toString());
      //llamar lo de actividades
      $scope.porTiempo();
      $scope.dataIngreso = {
      labels: [""],
      datasets: [
      {
        label: "Ingresos por Actividad",
        fillColor: "#3c8dbc",
        strokeColor: "#3c8dbc",
        pointColor: "#3c8dbc",
        pointStrokeColor: "#3c8dbc",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "#3c8dbc",
        data: [$scope.ingresoxact]
      },
      {
        label: "Otros Ingreso",
        fillColor: "#00a65a",
        strokeColor: "#00a65a",
        pointColor: "#00a65a",
        pointStrokeColor: "#00a65a",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "#00a65a",
        data: [$scope.otrosIngresos]
      }]};
      $scope.dataCosto = {
      labels: [""],
      datasets: [
      {
          label: "Costo por Actividad",
          fillColor: "#3c8dbc",
          strokeColor: "#3c8dbc",
          pointColor: "#3c8dbc",
          pointStrokeColor: "#3c8dbc",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "#3c8dbc",
          data: [$scope.costoxact]
      },
      {
        label: "Otros Costos",
        fillColor: "#f56954",
        strokeColor: "#f56954",
        pointColor: "#f56954",
        pointStrokeColor: "#c1c7d1",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,220,220,1)",
        data: [$scope.otrosCostos]
      }]};

   
    });
  }

  //trae todo el connsumo del evento seleccionado
  $scope.allConsumo = function(){
    
    $http({
        url: path + 'consumo/reporte',
        method: 'get',
        params:{
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
        $scope.consumo = response.consumo;
         console.log($scope.consumo); 
        $scope.consumo.bebidasPalco = $scope.numberFormat($scope.consumo.bebidasPalco.toString());
        $scope.consumo.bebidascalle = $scope.numberFormat($scope.consumo.bebidascalle.toString());
        $scope.consumo.comidasPalco = $scope.numberFormat($scope.consumo.comidasPalco.toString());
        $scope.consumo.comidascalle = $scope.numberFormat($scope.consumo.comidascalle.toString());
        $scope.consumo.snacksPalco = $scope.numberFormat($scope.consumo.snacksPalco.toString());
        $scope.consumo.snackscalle = $scope.numberFormat($scope.consumo.snackscalle.toString());
        $scope.consumo.totalBebidas = $scope.numberFormat($scope.consumo.totalBebidas.toString());
        $scope.consumo.totalCalle = $scope.numberFormat($scope.consumo.totalCalle.toString());
        $scope.consumo.totalPalco = $scope.numberFormat($scope.consumo.totalPalco.toString());      
        $scope.consumo.totalSnacks = $scope.numberFormat($scope.consumo.totalSnacks.toString()); 
        $scope.consumo.totalComidas = $scope.numberFormat($scope.consumo.totalComidas.toString()); 
         
    });
  }


  //trae todo el presupuesto del evento seleccionado
  $scope.allCultural = function(){
    
    $http({
        url: path + 'cultural/reporte',
        method: 'get',
        params:{
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
        $scope.cultural = response.cultural;
        $scope.reporteGenero = response.genero;
        $scope.labelsGenero = [];
        $scope.dataGenero = [];

        angular.forEach($scope.reporteGenero, function (value, key){
          $scope.labelsGenero.push(value.nombre);
          $scope.dataGenero.push(value.cant);
        });
        //console.log($scope.cultural);
    });
  }

  //trae todo el presupuesto del evento seleccionado
  $scope.allPorcEmpresas = function(){
    
    $http({
        url: path + 'empresas/colaboradoras',
        method: 'get',
        params:{
          idEvento: $rootScope.evento.idEvento
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
        $scope.totalEmpresa = response.total;
        //console.log($scope.totalEmpresa);
    });
  }

  if ($rootScope.filtroReporte.poblacion == 1) {
    $scope.allPoblacion();
  }
  if ($rootScope.filtroReporte.organizadores == 1) {
    $scope.allJunta();
  }
  if ($rootScope.filtroReporte.actividades == 1) {
    $scope.allConsumo(); 
    $scope.allCultural();
    $scope.allSocio();
    $scope.allPorcEmpresas();
    $scope.allActividad();
    setTimeout(function(){$scope.graficaIngreso($scope.ingresoxact, $scope.otrosIngresos);}, 3000);
    setTimeout(function(){$scope.graficaEgreso($scope.costoxact, $scope.otrosCostos);}, 3000);
      
  }

  /*PARTE MEDIOAMBIENTAL*/
  $scope.medioambiental = function(){

    $http({
        url: path + 'consumo/all',
        method: 'get',
        params:{
          idEvento: $rootScope.evento.idEvento
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
      //console.log($scope.aluminio,$scope.vidrio,$scope.plastico,$scope.carton,$scope.organico); 
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
      
      
      
    });
  }
  /*FIN PARTE MEDIOAMBIENTAL*/
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

  $scope.medioambiental();

}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
