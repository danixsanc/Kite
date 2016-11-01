<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");

$app->post("/statusCabbie/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $cabbie_id = $data['Cabbie_Id'];
    $status = $data['Status'];

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("UPDATE Cabbie SET CabbieActv_Id = :S WHERE Cabbie_Id = :CAI");
        $dbh->bindParam(':CAI', $cabbie_id);
        $dbh->bindParam(':S', $status);
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
            $response['IsError'] = true;
            $response['Data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));  
        }

    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
});

$app->post("/checkReference/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $reference = $data['Reference'];

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT * FROM Request WHERE Ref = ':R'");
        $dbh->bindParam(':R', $reference);
        $dbh->execute();
        $Ref = $dbh->fetchObject();

        if ($Ref != false) {

            $connection = null;

            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = $Ref;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else {
            $connection = null;

            $response['Message'] = "La referencia no existe";
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

$app->post("/verifyAll/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $cabbie_id = $data['Cabbie_Id'];
    $var = 2;

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT * FROM Request WHERE Cabbie_Id = ':CAI' AND Status != ':V'");
        $dbh->bindParam(':CAI', $cabbie_id);
        $dbh->bindParam(':V', $var);
        $dbh->execute();
        $req = $dbh->fetchObject();

        if ($Ref != false) {

            $connection = null;

            $userData = get_cabbie_data($user);

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

$app->post("/message/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $cabbie_id = $data['Cabbie_Id'];
    $subject = $data['Subject'];
    $message = $data['Message'];

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("INSERT INTO Message_Cabbie (Subject, Message, Cabbie_Id) VALUES(:S, :M, :CAI)");
        $dbh->bindParam(':CAI', $cabbie_id);
        $dbh->bindParam(':S', $subject);
        $dbh->bindParam(':M', $message);
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

            $response['Message'] = "Error al enviar mensaje";
            $response['IsError'] = true;
            $response['Data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));  
        }

    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
});


//historial



