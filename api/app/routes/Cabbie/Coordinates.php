<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");

$app->post("/getCabbieCoordinates/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $cabbie_id = $data['Cabbie_Id'];

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT * FROM Location_Cabbie WHERE Cabbie_Id = ':CAI'");
        $dbh->bindParam(':CAI', $cabbie_id);
        $dbh->execute();
        $cc = $dbh->fetchObject();

        if ($cc != false) {

            $connection = null;

            $userData = get_cabbie_data($user);

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


$app->post("/setCabbieCoordinates/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $cabbie_id = $data['Cabbie_Id'];
    $latitude = $data['Latitude'];
    $longitude = $data['Longitude'];

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("UPDATE Location_Cabbie SET Latitude = ':LA', Longitude = ':LO'
        WHERE Cabbie_Id = ':CAI'");
        $dbh->bindParam(':CAI', $cabbie_id);
        $dbh->bindParam(':LA', $latitude);
        $dbh->bindParam(':LO', $longitude);
        $dbh->execute();
 
        if ($dbh) {

            $connection = null;

            $userData = get_cabbie_data($user);

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