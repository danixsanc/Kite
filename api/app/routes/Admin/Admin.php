<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");



$app->get("/get_Admins/", function() use($app){

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT * FROM Admin");
        $dbh->execute();
        $cc = $dbh->fetchAll(PDO::FETCH_ASSOC);

        if ($cc != false) {

            $connection = null;

            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = $cc;

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