<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

define("SPECIALCONSTANT", true);

//Connection Database Lib Require
require 'app/libs/connect.php';

//Admin Lib Require
require 'app/routes/Admin/Account.php';

//Client Lib Require
require 'app/routes/Admin/Client.php';


$app->run();