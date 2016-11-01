var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'uiGmapgoogle-maps']);

app.config([
    '$routeProvider', 
    function ($routeProvider) {
        $routeProvider
            .when('/login', {
                title: 'Login',
                templateUrl: 'partials/login.html',
                controller: 'loginCtrl'
            })
            .when('/', {
                title: 'Login',
                templateUrl: 'partials/login.html',
                controller: 'loginCtrl',
                role: '0'
            })
            .when('/logout', {
                title: 'Logout',
                templateUrl: 'partials/login.html',
                controller: 'loginCtrl'
            })
            //Partials
            .when('/dashboard', {
                title: 'Dashboard',
                templateUrl: 'partials/dashboard.html',
                controller: 'dashboardCtrl'
            })

            .when('/cabbie', {
                title: 'Cabbie',
                templateUrl: 'partials/cabbie.html',
                controller: 'cabbieCtrl'
            })
            .when('/realTime', {
                title: 'Real Time',
                templateUrl: 'partials/realTime.html',
                controller: 'realTimeCtrl'
            })
            .when('/add-cabbie', {
                title: 'Real Time',
                templateUrl: 'partials/add-cabbie.html',
                controller: 'realTimeCtrl'
            })
            .when('/ver-solicitudes', {
                title: 'Solicitudes',
                templateUrl: 'partials/ver-solicitudes.html',
                controller: 'requestCtrl'
            })



            .when('/add-reservacion', {
                title: 'Real Time',
                templateUrl: 'partials/add-reservacion.html',
                controller: 'realTimeCtrl'
            })
            .when('/registro-usuarios', {
                title: 'Real Time',
                templateUrl: 'partials/registro-usuarios.html',
                controller: 'realTimeCtrl'
            })
            .when('/reservaciones', {
                title: 'Reservaciones',
                templateUrl: 'partials/reservaciones.html',
                controller: 'reservationCtrl'
            })
            .when('/usuarios', {
                title: 'Admin',
                templateUrl: 'partials/usuarios.html',
                controller: 'adminCtrl'
            })
            .when('/mensajes', {
                title: 'Mensaje Cliente',
                templateUrl: 'partials/mensajes.html',
                controller: 'messageCtrl'
            })
            .when('/socket', {
                title: 'Socket',
                templateUrl: 'partials/socket.html',
                controller: 'socketCtrl'
            })
            .when('/view-cabbie', {
                title: 'Real Time',
                templateUrl: 'partials/view-cabbie.html',
                controller: 'realTimeCtrl'
            })
            .when('/view-usuarios', {
                title: 'Real Time',
                templateUrl: 'partials/view-usuarios.html',
                controller: 'realTimeCtrl'
            })
            .when('/view-reservaciones', {
                title: 'Real Time',
                templateUrl: 'partials/view-reservaciones.html',
                controller: 'realTimeCtrl'
            })
            .when('/add-solicitudes', {
                title: 'Real Time',
                templateUrl: 'partials/add-solicitudes.html',
                controller: 'realTimeCtrl'
            })
            .when('/view-solicitudes', {
                title: 'Real Time',
                templateUrl: 'partials/view-solicitudes.html',
                controller: 'realTimeCtrl'
            })

            .when('/automoviles', {
                title: 'Real Time',
                templateUrl: 'partials/automoviles.html',
                controller: 'carCtrl'
            })
            .when('/view-automoviles', {
                title: 'Real Time',
                templateUrl: 'partials/view-automoviles.html',
                controller: 'realTimeCtrl'
            })
            .when('/add-automovil', {
                title: 'Real Time',
                templateUrl: 'partials/add-automovil.html',
                controller: 'realTimeCtrl'
            })
            .when('/view-mensajes', {
                title: 'Real Time',
                templateUrl: 'partials/view-mensajes.html',
                controller: 'realTimeCtrl'
            })


            .otherwise({
                redirectTo: '/login'
            });
  }])



.config(function(uiGmapGoogleMapApiProvider) {
    uiGmapGoogleMapApiProvider.configure({
        key: 'AIzaSyCSGDg5Si6gvM8VKApwIiM8K9AUjzD9P_E',
        v: '3.20', //defaults to latest 3.X anyhow
        libraries: 'weather,geometry,visualization'
    });
});



  /*  .run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            Data.get('session').then(function (results) {
                if (results.uid) {
                    $rootScope.authenticated = true;
                    $rootScope.uid = results.uid;
                    $rootScope.name = results.name;
                    $rootScope.email = results.email;
                } else {
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login') {

                    } else {
                        $location.path("/login");
                    }
                }
            });
        });
    });

*/
    