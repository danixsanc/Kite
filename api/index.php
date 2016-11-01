<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

define("SPECIALCONSTANT", true);

//Connection Database Lib Require
require 'app/libs/connect.php';

//User Lib Require
require 'app/routes/User/Account.php';
require 'app/routes/User/FavoritePlace.php';
require 'app/routes/User/History.php';
require 'app/routes/User/Card.php';
require 'app/routes/User/FunctionsUser.php';
//Cabbie Lib Require
require 'app/routes/Cabbie/Account.php';
require 'app/routes/Cabbie/Coordinates.php';
require 'app/routes/Cabbie/FunctionsCabbie.php';
require 'app/routes/Cabbie/Request.php';

//Admin Lib Require
require 'app/routes/Admin/Request.php';
require 'app/routes/Admin/Cabbie.php';
require 'app/routes/Admin/Account.php';
require 'app/routes/Admin/Admin.php';
require 'app/routes/Admin/Car.php';
require 'app/routes/Admin/Reservation.php';
require 'app/routes/Admin/Message_client.php';

//Global Lib Require
require 'app/routes/Global/Functions.php';
require 'app/routes/Global/Global.php';

//Conekta Lib Require And Configuration Api Key
require_once ("app/libs/Conekta.php");
Conekta::setApiKey("key_tQCYUfka2gsxiisnXCXpbQ");


$app->run();