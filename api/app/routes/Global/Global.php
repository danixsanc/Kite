<?php
if (!defined('SPECIALCONSTANT')) die("Acceso Denegado");

$app->get("/actualizar_taxistas/", function() use($app){

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("UPDATE Cabbie SET  Cabbie_Status_Id = 1, Date_Selection = NULL 
        	WHERE (DATE_ADD(Date_Selection, INTERVAL 1 MINUTE ) < NOW( )) AND Cabbie_Status_Id == 3 ");
        $dbh->execute();

        if ($dbh) {

            $connection = null;

            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else {
            $connection = null;

            $response['Message'] = "Error al actualizar";
            $response['IsError'] = false;
            $response['Data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));  
        }

    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
});