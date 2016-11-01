<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");

$app->post("/acceptRequest/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $cabbie_id = $data['Cabbie_Id'];
    $client_id = $data['Client_Id'];
    $request_id = $data['Request_Id'];

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("UPDATE Request SET Status = '1' WHERE Cabbie_Id = ':CAI' AND Client_Id = ':CI' AND
            Request_Id = ':RI'");
        $dbh->bindParam(':CAI', $cabbie_id);
        $dbh->bindParam(':CI', $client_id);
        $dbh->bindParam(':RI', $request_id);
        $dbh->execute();

        if ($dbh) {

            $connection = null;

        
            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['UserData'] = null;

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

$app->post("/getRequests/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $cabbie_id = $data['Cabbie_Id'];
    $process = $data['OnProcess'];
    try{

        $connection = getConnection();

        $dbh = $connection->prepare("SELECT R.Request_Id, R.Date, R.Latitude_In, R.Longitude_In, R.Latitude_Fn, R.Longitude_Fn, R.Cabbie_Id, R.Client_Id, C.Gcm_Id FROM Request R 
            INNER JOIN Client C ON  R.Client_Id = C.Client_Id
        WHERE Cabbie_Id = :CAI AND R.RequestStatus_Id = :V");


        $dbh->bindParam(':CAI', $cabbie_id);
        $dbh->bindParam(':V', $process);
        $dbh->execute();
        $req = $dbh->fetchAll(PDO::FETCH_ASSOC);

        if ($req != false) {

            $connection = null;

            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = $req;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else {
            $connection = null;

            $response['Message'] = "Error al obtener datos";
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

$app->post("/getRequestById/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $request_id = $data['Request_Id'];
    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT * FROM Request INNER JOIN Client ON  Request.Client_Id = Client.Client_Id
        WHERE Request.Request_Id = ':RI'");
        $dbh->bindParam(':RI', $request_id);
        $dbh->execute();
        $req = $dbh->fetchObject();

        if ($req != false) {

            $connection = null;

            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = $req;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else {
            $connection = null;

            $response['Message'] = "La solicitud no existe";
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


$app->post("/finalizeRequest/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $cabbie_id = $data['Cabbie_Id'];
    $var = 2;
    $var2 = 1;
    $var3 = 0;

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("UPDATE Request SET Status = ':V' WHERE Cabbie_Id= ':CAI' AND Status = ':V2'");
        $dbh->bindParam(':CAI', $cabbie_id);
        $dbh->bindParam(':V', $var);
        $dbh->bindParam(':V2', $var2);
        $dbh->execute();

        if ($dbh) {

            $dbh2 = $connection->prepare("UPDATE Cabbie SET Status = ':V3' WHERE Cabbie_Id= ':CAI'");
            $dbh2->bindParam(':CAI', $cabbie_id);
            $dbh2->bindParam(':V3', $var3);
            $dbh2->execute();

            if ($dbh2) {
                $connection = null;

                $response['Message'] = "OK";
                $response['IsError'] = false;
                $response['UserData'] = null;

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