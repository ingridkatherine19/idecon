'use strict';
 
angular.module('myApp.Presupuesto', ['ngRoute'])
 
// Declared route 
.config(['$routeProvider', function($routeProvider) {
$routeProvider.when('/presupuesto', {
        templateUrl: 'pages/Presupuesto/presupuesto.html',
        controller: 'PresupuestoCtrl'
    });
}])

.controller('PresupuestoCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope) {
  localStorage.setItem("user", JSON.stringify(user));
  $rootScope.user = JSON.parse(localStorage.getItem('user')); 
  if (!$rootScope.evento) {
    window.location.href = '#/evento';
  }
  $scope.ver = false;
  $scope.colores = [{'color': '#00EAB5'}, {'color' : '#FF6C00'}, {'color' : '#00ABF8'}, {'color' : '#F24B45'}, {'color' : '#D03B43'}, {'color' : '#AB313E'}, {'color' : '#503140'}, {'color' : '#322E3F'}];
  console.log($rootScope.evento);
  //declaracion de variables
  $scope.costos ={};
  $scope.ingresos = {};
  $scope.costoa ={};
  $scope.costoxact = 0;
  $scope.porcCostoxact = 0;
  $scope.otrosCostos = 0;
  $scope.porcOtrosCostos = 0;
  $scope.ingresoxact = 0;
  $scope.porcIngresoxact = 0;
  $scope.otrosIngresos = 0;
  $scope.porcOtrosIngresos = 0;
  $scope.subCosto = 0;
  $scope.subIngreso = 0;
  $scope.porcCosto = 0;
  $scope.porcIngreso = 0;
  $scope.subImpuesto = 0;
  $scope.sinImpuesto = 0;
  $scope.neto = 0;
  $scope.tipoCosto = [];
  $scope.tipoIngreso = [];
  $scope.tipoNuevo = false;
  $scope.botonTipo = 'Nuevo Tipo';
  $scope.labels = ["Costos de las Actividades", "Otros Costos"];
  $scope.labels2 = ["Ingresos de las Actividades", "Otros Ingresos"];
  $scope.l = [''];
  $scope.labels3 = ['Egresos', 'Ingresos'];
  $scope.appCosto = 0;
  $scope.costosActividad = [];

  
  
  //trae todo el presupuesto del evento seleccionado
  $scope.all = function(){
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
    $scope.app =false;
    $scope.costo = {};
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
      console.log($scope.costos.length, $scope.ingresos.length);
      //sumo el total de costos e impuestos
      angular.forEach($scope.costos, function (value, key){
          $scope.subCosto += value.costo;
          value.costo2 = $scope.numberFormat(value.costo.toString());
          value.cantidad2 = $scope.numberFormat(value.cantidad.toString());
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
          value.cantidad2 = $scope.numberFormat(value.cantidad.toString());
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
          
      $scope.ver = true;
          
    });
     
  }

  setTimeout(function(){ $scope.cargarBarChart(); }, 3000);

  $scope.cargarBarChart = function(){
    //alert('2');
    console.log($scope.subCosto , $scope.subIngreso);
    var areaChartData = {
      labels: ['Totales'],
      datasets: [
        {
          label: "Egresos",
          fillColor: "rgba(0, 234, 181, 1)",
          strokeColor: "rgba(0, 234, 181, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [$scope.subCosto]
        },
        {
          label: "Ingresos",
          fillColor: "rgba(255, 108, 0, 1)",
          strokeColor: "rgba(255, 108, 0, 1)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [$scope.subIngreso]
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

  //$scope.cargarBarChart();

  /*--------------------FIN DE CHART----------------------*/  



  //selecciona la actvidad que se le va a agregarel costo
  $scope.selectActividad = function(actividad){
    $scope.idactividadSeleccionada = actividad.idActividad;
    $scope.allCostoActividad();
    //console.log(actividad);
  }

  //mostrar o no en la app
  $scope.chequea = function(){
    if ($scope.appCosto == 1) {
      $scope.appCosto = 0;      
    }else{
      $scope.appCosto = 1;
    }
  }

  //crear nuevo costo para la actividad
  $scope.createCostoActividad = function(){
    $scope.costoa.app = $scope.appCosto;
    $scope.costoa.idActividad = $scope.idactividadSeleccionada;    
    console.log($scope.costoa);
    $http({
        url: path + 'costoa/create',
        method: 'get',
        params: $scope.costoa,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
     $scope.costoa = {};
     //buscar todos los costos de la app
     $scope.allCostoActividad();
     $scope.all();           
    });  
  }

  //buscar todos los costos de la actividad seleccionada
  $scope.allCostoActividad = function(){
   $http({
        url: path + 'costoa/all',
        method: 'get',
        params: {
          idActividad: $scope.idactividadSeleccionada
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.costosActividad = response.costos;           
    }); 
  }

  //eliminar el costo de la actividad 
  $scope.deleteCostoActividad = function(costo){
   $http({
        url: path + 'costoa/delete',
        method: 'get',
        params: {
          idCosto: costo.idCosto,
          idActividad: $scope.idactividadSeleccionada
        },
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      //buscar todos los costos de la app
      $scope.allCostoActividad();
      $scope.all();           
    }); 
  }

  $scope.mostrarApp = function(){
    //alert('fg');
    if($scope.app){
      $scope.app =false;
    }else{
      $scope.app =true;
    }
  }

  //traer los tipos que pueden ser costos e ingresos
  $scope.allTipo = function(){
    $scope.tipoCosto = [];
    $scope.tipoIngreso = [];
    $http({
        url: path + 'presupuesto/tipoall',
        method: 'get',
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $scope.tipo = response.tipo; 
      //separar los tipo ingresos y los tipo costo
      angular.forEach($scope.tipo, function (value, key){
            if (value.idSeccion == 0) {//es costo
              $scope.tipoCosto.push(value);
            }else{//es ingreso
              $scope.tipoIngreso.push(value);
            }
      });
      console.log($scope.tipoCosto, $scope.tipoIngreso);          
    });  
  }

  $scope.actCosto = function(costo){
    console.log(costo);
    $scope.costo = costo;
  }

  $scope.actualizarCosto = function(){
    
    if($scope.app){//mostrar en la app
      $scope.costo.app = 1; 
    }else{//no mostrar en la app
      $scope.costo.app = 0;
    }
    console.log($scope.costo);
    $http({
        url: path + 'costo/update',
        method: 'get',
        params:$scope.costo,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      //llamar para recargar la vista 
      $scope.all();    


    });
  }
  //modifica el swich si quiere agregar un tipo nuevo
  $scope.agregarTipo = function(){
    if($scope.tipoNuevo){
      $scope.tipoNuevo = false;
      $scope.botonTipo = 'Nuevo Tipo';
    }else{
      $scope.tipoNuevo = true;
      $scope.botonTipo = 'Seleccionar Tipo';
    }
  }

  //guardar un nuevo costo
  $scope.guardarCosto = function(){
    
    $scope.costo.idEvento = $rootScope.evento.idEvento;
    $scope.costo.costo = $scope.costo.costo.replace(/\./g,'');
    $scope.costo.costo = parseInt($scope.costo.costo); 
    $scope.costo.cantidad = $scope.costo.cantidad.replace(/\./g,'');
    $scope.costo.cantidad = parseInt($scope.costo.cantidad); 
    if($scope.app){//mostrar en la app
      $scope.costo.app = 1; 
    }else{//no mostrar en la app
      $scope.costo.app = 0;
    }

    if ($scope.tipoNuevo) {
      $http({
          url: path + 'presupuesto/tipocreate',
          method: 'get',
          params:{
            nombre: $scope.costo.tipoNombre,
            idSeccion: 0
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        $scope.tipo = response.tipo;
        $scope.costo.tipo = $scope.tipo.idTipo;
        $scope.creaCosto();
      });  
    }else{
      $scope.creaCosto();
    }
    
    
  }

  //crea el costo aparte ppara esperar para crear el tipo
  $scope.creaCosto = function(){
    $scope.costo.costo = parseInt($scope.costo.costo); 
    $scope.costo.cantidad = parseInt($scope.costo.cantidad);
    console.log($scope.costo);
    $http({
        url: path + 'costo/create',
        method: 'get',
        params:$scope.costo,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      console.log(response.costo);
      //inicializar variables
      $scope.costo = {};
      $scope.tipoNuevo = false;
      $scope.app = false;
      $scope.checkApp = false;
      $scope.botonTipo = 'Nuevo Tipo';
      $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      //llamar para recargar la vista 
      $scope.all();    
      $scope.allTipo();


    });
  }

  //guardar un nuevo ingreso
  $scope.guardarIngreso = function(){
    $scope.ingreso.idEvento = $rootScope.evento.idEvento;
    $scope.ingreso.costo = $scope.ingreso.costo.replace(/\./g,'');
    $scope.ingreso.costo = parseInt($scope.ingreso.costo); 
    $scope.ingreso.cantidad = $scope.ingreso.cantidad.replace(/\./g,'');
    $scope.ingreso.cantidad = parseInt($scope.ingreso.cantidad); 
    console.log($scope.ingreso, $scope.tipoNuevo);
    if ($scope.tipoNuevo) {
      $http({
          url: path + 'presupuesto/tipocreate',
          method: 'get',
          params:{
            nombre: $scope.ingreso.tipoNombre,
            idSeccion: 1
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {

        $scope.tipo = response.tipo;
        $scope.ingreso.tipo = $scope.tipo.idTipo;
        $scope.creaIngreso();
      });  
    }else{
      $scope.creaIngreso();
    }
    
    
  }

  //crea el costo aparte ppara esperar para crear el tipo
  $scope.creaIngreso = function(){
    $scope.ingreso.costo = parseInt($scope.ingreso.costo); 
    $scope.ingreso.cantidad = parseInt($scope.ingreso.cantidad);
    $http({
        url: path + 'ingreso/create',
        method: 'get',
        params:$scope.ingreso,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      console.log(response.ingreso);
      //inicializar variables
      $scope.ingreso = {};
      $scope.tipoNuevo = false;
      $scope.botonTipo = 'Nuevo Tipo';
      $('#myModal5').modal('show'); // abrir
      setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      //llamar para recargar la vista 
      $scope.all(); 
      $scope.allTipo();   

    });
  }

  $scope.actIngreso = function(ingreso){
    console.log(ingreso);
    $scope.ingreso = ingreso;
  }

  $scope.actualizarIngreso = function(){
    console.log($scope.ingreso);
    $http({
        url: path + 'ingreso/update',
        method: 'get',
        params: $scope.ingreso,
        headers: {
            "Content-Type": "application/json"
        }
    }).success(function (response) {
      $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
        $('#myModal5').modal('hide');
      },2000);
      //llamar para recargar la vista 
      $scope.all();    


    });
  }

  //Seleccion de si se borrara costo o ingreso
  $scope.seleccionar = function(id , valor){
    $scope.idSeleccionado = id;
    $scope.tipoSeleccionado = valor;
  }

  //eliminar un costo del evento
  $scope.eliminarCoI = function(id){
    var ruta;
    if ($scope.tipoSeleccionado == 1) {
      ruta = 'costo/delete';
    }else{
      ruta = 'ingreso/delete';
    }
    console.log(ruta , $scope.idSeleccionado);
      $http({
          url: path + ruta,
          method: 'get',
          params:{
            id : $scope.idSeleccionado
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
         $('#myModal5').modal('show'); // abrir
        setTimeout(function(){
          $('#myModal5').modal('hide');
        },2000);
        //llamar para recargar la vista 
        $scope.all();    

      });  
    
    
  }

  //eliminar un ingresos del evento
  $scope.eliminarIngreso = function(id){
    $scope.respuesta = confirm('¿Seguro que desea eliminar este ingreso?');
    if ($scope.respuesta) {
      $http({
          url: path + 'ingreso/delete',
          method: 'get',
          params:{
            idIngreso : id
          },
          headers: {
              "Content-Type": "application/json"
          }
      }).success(function (response) {
        alert('Se elimino Correctamente');
        //llamar para recargar la vista 
        $scope.all();    

      });  
    }
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

    /*PUNTOS EN LOS INPUT*/

     $("#costodecosto").on({
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
    $("#cantidadcosto").on({
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

    $("#costodeingreso").on({
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
    $("#cantidadingreso").on({
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

  $scope.allTipo();

  
}]).filter('startFromGrid', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  }
});
