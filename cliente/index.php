<!DOCTYPE html>
<html lang="en" ng-app="myApp" ng-controller="loginCtrl">


  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Rivos Services</title>

    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="./bower_components/bootstrap/dist/css/bootstrap.css">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">
<meta name="keywords" content="ng-map,AngularJS,center">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

  </head>

  <body ng-cloak="">




<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top nav-color-n" role="navigation" 
         >
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#dashboard">Rivos Services</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope icono-nav-bar"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell icono-nav-bar"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user icono-nav-bar"></i> {{name}} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Perfil</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Configuracion</a>
                        </li>
                        <li class="divider"></li>
                        <li> 
                            <a href="#/" ng-click="logout()"><i class="fa fa-fw fa-power-off"></i> Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="#/dashboard"><i class="fa fa-fw fa-dashboard icono-nav-bar"></i> Principal</a>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#requests">
                        <i class="fa fa-fw fa-check icono-nav-bar"></i> Solicitudes <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="requests" class="collapse">
                            <li>
                                <a href="#/ver-solicitudes">Ver Todos</a>
                            </li>
                            <li>
                                <a href="#/add-solicitudes">Agregar</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#carmovil">
                        <i class="fa fa-fw fa-car icono-nav-bar"></i> Automoviles <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="carmovil" class="collapse">
                            <li>
                                <a href="#/automoviles">Ver Todos</a>
                            </li>
                            <li>
                                <a href="#/add-automovil">Agregar</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#realtime">
                        <i class="fa fa-fw fa-clock-o icono-nav-bar"></i> Real Time <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="realtime" class="collapse">
                            <li>
                                <a href="#/realTime">Real Time</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#cabbie">
                        <i class="fa fa-fw fa-taxi icono-nav-bar"></i> Taxistas <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="cabbie" class="collapse">
                            <li>
                                <a href="#/cabbie">Ver Todos</a>
                            </li>
                            <li>
                                <a href="#/add-cabbie">Agregar</a>
                            </li>
                        </ul>
                    </li>
                                        
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#usuarios">
                        <i class="fa fa-fw fa-user icono-nav-bar"></i> Administradores <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="usuarios" class="collapse">
                            <li>
                                <a href="#/usuarios">Ver Todos</a>
                            </li>
                            <li>
                                <a href="#/registro-usuarios">Agregar</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#reservaciones">
                        <i class="fa fa-fw fa-calendar icono-nav-bar"></i> Reservaciones <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="reservaciones" class="collapse">
                            <li>
                                <a href="#/reservaciones">Ver Todos</a>
                            </li>
                            <li>
                                <a href="#/add-reservacion">Agregar</a>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a href="#/mensajes"><i class="fa fa-fw fa-envelope-o icono-nav-bar"></i> Mensajes</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>


        <div id="page-wrapper">
            <div class="container-flueid" data-ng-view="" id="ng-view">
                <!--CONTENEDOR PRINCIPAL-->
            </div>
        </div>

    </div>



  </body>


  <toaster-container toaster-options="{'time-out': 1000}"></toaster-container>
  <script src="./bower_components/angular/angular.js"></script>
  <script src="./bower_components/angular-route/angular-route.js"></script>
  <script src="./bower_components/angular-resource/angular-resource.js" ></script>
  <script src="./bower_components/angular-animate/angular-animate.js" ></script>
  <script src="./bower_components/AngularJs-Toaster/toaster.js" ></script>

  <script src="app/app.js"></script>
  <script src="app/data.js"></script>
  <script src="app/directives.js"></script>
  
  <!--Controllers-->
  <script src="app/loginCtrl.js"></script>
  <script src="app/dashboardCtrl.js"></script>
  <script src="app/cabbieCtrl.js"></script>
  <script src="app/realTimeCtrl.js"></script>
  <script src="app/socketCtrl.js"></script>
  <script src="app/adminCtrl.js"></script>
  <script src="app/carCtrl.js"></script>
  <script src="app/reservationCtrl.js"></script>
  <script src="app/requestCtrl.js"></script>
  <script src="app/messageCtrl.js"></script>
  <!--Controllers-->

  <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>


    <script src='./bower_components/lodash/dist/lodash.min.js'></script>
    <script src='./bower_components/angular-simple-logger/dist/angular-simple-logger.min.js'></script>
    <script src='./bower_components/angular-google-maps/dist/angular-google-maps.min.js'></script>
    <!--script src='//maps.googleapis.com/maps/api/js?sensor=false'></script-->
    <script src='//maps.googleapis.com/maps/api/js?key=AIzaSyCSGDg5Si6gvM8VKApwIiM8K9AUjzD9P_E'></script>

  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

</html>



