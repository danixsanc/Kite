<?php if (!defined('SPECIALCONSTANT')) die("Acceso Denegado");

function getConnection(){
	try{
		//$db_username = "yozzizql_rivos";
		//$db_password = "rivos96994233";
		//$connection = new PDO("mysql:host=localhost;dbname=yozzizql_Rivos_Taxi_TEST", $db_username, $db_password);

		$db_username = "root";
		$db_password = "";
		$connection = new PDO("mysql:host=localhost;dbname=yozzizql_Rivos_Taxi_TEST", $db_username, $db_password);

		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	return $connection;
}