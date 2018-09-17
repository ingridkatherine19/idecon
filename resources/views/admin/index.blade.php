<!DOCTYPE html>

<!--[if gt IE 8]><!--> <html lang="en" ng-app="myApp" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Idecon</title>
  <meta name="description" content="">
    <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script src="bower_components/html5-boilerplate/dist/js/vendor/modernizr-2.8.3.min.js"></script>
  <!--DOCUMENTADO-->
  <!-- <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.2/angular.js"></script>
  <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.4.js"></script>-->

  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

  <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
 <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
 
 <!-- <script src="bower_components/ngmap/build/scripts/ng-map.js"></script>-->
  


    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Morris charts -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap VECTOR DEL MAPA PARA MARCAR -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!--STEP INGRID-->
    <link rel="stylesheet" href="dist/step/css/normalize.css">
    <link rel="stylesheet" href="dist/step/css/main.css">
    <link rel="stylesheet" href="dist/step/css/jquery.steps.css">


    <!--  FULL Calendario  -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.print.css" media="print">
   <!-- skill -->
   <!-- Bootstrap 3.3.7 -->
    <!--<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">-->
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">-->
    <!-- Ionicons -->
    <!--<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">-->
    <!-- Google Font -->
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->
    <!--<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">-->
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="node_modules/isteven-angular-multiselect/isteven-multi-select.css">
    <link rel="stylesheet" href="app.css">

  </head>
  <body class="hold-transition sidebar-mini wysihtml5-supported skin-yellow-light " >
    
    <div class="wrapper " style="background-color: black !important;">

      <header class="main-header" style="background-color: black !important">
        <!-- Logo -->
        <a class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>S</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">SITENA</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" style="background-color: #fff  !important">
          <!-- Sidebar toggle button-->
          <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">4</span>
                </a>-->
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- start message -->
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <!-- end message -->
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            AdminLTE Design Team
                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Developers
                            <small><i class="fa fa-clock-o"></i> Today</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Sales Department
                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Reviewers
                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
               <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>-->
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                          page and may cause design problems
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-red"></i> 5 new members joined
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-user text-red"></i> You changed your username
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="imagenes/logo-sitena.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs">{{$user->nombre}}</span>
                </a>
                <ul class="dropdown-menu" >
                  <!-- User image -->
                  <li class="user-header" style="background-color: #00a3ee ! important">
                    <img src="imagenes/logo-sitena.jpg" class="img-circle" alt="User Image">

                    <p>
                      {{$user->nombre}}
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <!--<div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>-->
                    <div class="pull-right">
                      <a href="{{ URL::route('account-sign-out')}}"  class="btn btn-default btn-flat">Cerrar Sesión</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar" style="background-color: #00A3EE !important">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          
          <!-- search form -->
          
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li>
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/dashboard">
                <i class="ion ion-pie-graph" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Tablero</span>
                
              </a>
            </li>
            <li ng-if="{{$user->tipo != 5}}">
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/evento">
                <i class="fa fa-star" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Eventos</span>
                
              </a>
            </li>
            <li ng-if="{{$user->tipo != 5}}">
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/empresa">
                <i class="fa fa-university" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Empresas</span>
                
              </a>
            </li>
            <li ng-if="{{$user->tipo != 5}}">
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/agrupacion">
                <i class="fa fa-music" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Grupos Artísticos</span>
                
              </a>
            </li>
            <li ng-if="{{$user->tipo != 5}}">
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/participante">
                <i class="fa fa-users" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Participantes</span>
                
              </a>
            </li>
            <li ng-if="{{$user->tipo != 5}}">
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/hotel">
                <i class="fa fa-hotel" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Hoteles</span>
                
              </a>
            </li>
            <li ng-if="{{$user->tipo != 5}}">
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/restaurante">
                <i class="ion ion-wineglass" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Restaurantes</span>
                
              </a>
            </li>
            <li ng-if="{{$user->tipo != 5}}">
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/lugar">
                <i class="fa fa-map-marker" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Lugares</span>
                
              </a>
            </li>
            <li ng-if="{{$user->tipo == 5}}">
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/mievento">
                <i class="fa fa-star" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Evento</span>
                
              </a>
            </li>
            <li ng-if="{{$user->tipo == 5}}">
              <a style="padding-top: 10%;padding-bottom: 10%" href="#/miactividad">
                <i class="fa fa-calendar" style="color: #fff  !important;padding-right: 15%"></i> <span style="color: #fff;font-weight: initial;">Actividades</span>
                
              </a>
            </li>

            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper ">
         <div ng-view></div>
      </div><!-- /.content-wrapper -->

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>

    </div><!-- ./wrapper -->

   <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!--STEP INGRID-->
    <script src="plugins/jQuery/jquery.steps.js"></script>

  <!--Angular zone-->
  <script src="bower_components/angular/angular.js"></script>
  <script src="bower_components/angular-route/angular-route.js"></script>
   <!--angular-chart-->

    <script src="../node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="../node_modules/angular-chart.js/dist/angular-chart.js"></script>


  <!--usuario-->
  <script >
    var user = {!! $user !!};
    
  </script>

  
  <!--Angular-->
  <script src="app.js"></script>
  <script src="view1/view1.js"></script>
  <script src="view2/view2.js"></script>
  <script src="js/ControladorEvento.js"></script>
  <script src="js/ControladorEmpresa.js"></script>
  <script src="js/ControladorActividad.js"></script>
  <script src="js/ControladorDashboard.js"></script>
  <script src="js/ControladorParticipante.js"></script>
  <script src="js/ControladorAgrupacion.js"></script>
  <script src="js/ControladorHotel.js"></script>
  <script src="js/ControladorPresupuesto.js"></script>
  <script src="js/ControladorInvitacion.js"></script>
  <script src="js/ControladorReal.js"></script>
  <script src="js/ControladorRestaurante.js"></script>
  <script src="js/ControladorReporte.js"></script>
  <script src="js/ControladorLugar.js"></script>
  <script src="js/ControladorEncuesta.js"></script>
  <script src="js/ControladorEventoUsuario.js"></script>
  <script src="js/ControladorActividadUsuario.js"></script>
  <script src="js/ControladorConsumo.js"></script>
  <!-- SCRIPT CON EL MAPA-->
    

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
   <!-- DataTables -->
   <!-- <script src="plugins/datatables/jquery.dataTables.min.js"></script>-->
    
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>

  

    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>

    <!-- fullCalendar 2.2.5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="plugins/fullcalendar/fullcalendar.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js"></script>
    <!--FLOT-->
    <script src="plugins/flot/jquery.flot.min.js"></script>
    <script src="plugins/flot/jquery.flot.resize.min.js"></script>
    <script src="plugins/flot/jquery.flot.pie.min.js"></script>
    <script src="plugins/flot/jquery.flot.categories.min.js"></script> 

    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropdown-toggle').dropdown();
        });
   </script>
      <!--<script src="node_modules/angular-datatables/dist/angular-datatables.min.js"></script>-->
   <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
   <!--DATATABLES PAGINACION-->
   <script src="https://rawgit.com/l-lin/angular-datatables/v0.4.3/dist/angular-datatables.min.js"></script>
   <!--ANGULAR MULTISELECT-->
   <script  src="node_modules/isteven-angular-multiselect/isteven-multi-select.js"></script>
   
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlamKAsxOvzaCf-9pd8OOPrmpDNGNK08s">
    </script>


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
   <!--SKILL-->
   <!-- jQuery 3 -->
    <!--<script src="bower_components/jquery/dist/jquery.min.js"></script>-->
    <!-- Bootstrap 3.3.7 -->
    <!--<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
    <!-- SlimScroll -->
    <!--<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>-->
    <!-- FastClick -->
    <!--<script src="bower_components/fastclick/lib/fastclick.js"></script>-->
    <!-- AdminLTE App -->
    <!--<script src="dist/js/adminlte.min.js"></script>-->
    <!-- jQuery Knob -->
    <!--<script src="bower_components/jquery-knob/js/jquery.knob.js"></script>-->
    <!-- Sparkline -->
    <!--<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>-->

  </body>
</html>
  