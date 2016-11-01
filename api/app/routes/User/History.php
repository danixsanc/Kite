<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");

$app->post("/getHistory/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
    $client_Id = $data['Client_Id'];

    try{


        $connection = getConnection();
        $dbh = $connection->prepare("SELECT R.Request_Id, R.Date, CONCAT(C.FirstName, ' ', C.LastName) as Cabbie_Name,
            R.Inicio, R.Destino, R.Ref, C.Cabbie_Id, R.Price FROM Request R
                INNER JOIN Cabbie C ON R.Cabbie_Id = C.Cabbie_Id
                WHERE Client_Id = :CID AND R.RequestStatus_Id = 3");
        $dbh->bindParam(':CID', $client_Id);
        $dbh->execute();
        $requests = $dbh->fetchAll(PDO::FETCH_ASSOC);
        
        if ($requests != false) {

            $connection = null;
            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = $requests;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else{

            $connection = null;

            $response['Message'] = "No hay historial registrado";
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

$app->post("/getPending/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
    $client_Id = $data['Client_Id'];

    try{


        $connection = getConnection();
        $dbh = $connection->prepare("SELECT R.Request_Id, R.Date, CONCAT(C.FirstName, ' ', C.LastName) as Cabbie_Name,
            R.Inicio, R.Destino, R.Ref, C.Cabbie_Id, R.Price FROM Request R
                INNER JOIN Cabbie C ON R.Cabbie_Id = C.Cabbie_Id
                WHERE Client_Id = :CID AND (R.RequestStatus_Id = 2 OR R.RequestStatus_Id = 1)");
        $dbh->bindParam(':CID', $client_Id);
        $dbh->execute();
        $requests = $dbh->fetchAll(PDO::FETCH_ASSOC);
        
        if ($requests != false) {

            $connection = null;
            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = $requests;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else{

            $connection = null;

            $response['Message'] = "No hay historial registrado";
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


$app->post("/deleteHistory/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $client_Id = $data['Client_Id'];
    $request_Id = $data['Request_Id'];

    try{


        $connection = getConnection();
        $dbh = $connection->prepare("UPDATE Request SET RequestStatus_Id = 4 WHERE Request_Id = :RI AND Client_Id = :CID");
        $dbh->bindParam(':RI', $request_Id);
        $dbh->bindParam(':CID', $client_Id);
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
        else{

            $connection = null;

            $response['Message'] = "Error al eliminar del historial";
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