<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");



$app->post("/setCard/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $conekta_token = $data['Conekta_Token'];
    $client_id = $data['Client_Id'];

    $response = array();

    try{

        $connection = getConnection();

        $dbh = $connection->prepare("SELECT Conekta_Id FROM Client WHERE Client_Id = :CID");
        $dbh->bindParam(':CID', $client_id);
        $dbh->execute();
        $result = $dbh->fetchObject();

        $customer = Conekta_Customer::find($result->Conekta_Id);
        $card = $customer->createCard(array('token' => $conekta_token));

        
        $dbh = $connection->prepare("INSERT INTO Card (Conekta_Card, Client_Id) VALUES(:CC, :CID)");
        $dbh->bindParam(':CC', $card->id);
        $dbh->bindParam(':CID', $client_id);
        $dbh->execute();

        if ($dbh) {

            $cardIdArray = array();
            $cardId = $connection->lastInsertId();

            $connection = null;
            $response['Message'] = "Tarjeta registrada correctamente";
            $response['IsError'] = false;
            $response['Data'] = $cardId;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else{

            $connection = null;
            $response['Message'] = "No se pudo registrar la tarjeta";
            $response['IsError'] = false;
            $response['Data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }

    }catch(PDOException $e){
        $response['Message'] = $e->getMessage();
        $response['IsError'] = false;
        $response['Data'] = null;

        $app->response->headers->set("Content-type", "application/json");
        $app->response->status(200);
        $app->response->body(json_encode($response));
    }
});




$app->post("/getCard/", function() use($app){
    
    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $client_id = $data['Client_Id'];


    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT Conekta_Id FROM Client WHERE Client_Id = :CID");
        $dbh->bindParam(':CID', $client_id);
        $dbh->execute();
        $result = $dbh->fetchObject();
        
        if ($result != false) {


            $customer = Conekta_Customer::find($result->Conekta_Id);

            $resultado = count($customer->cards);
            $dataArray = array();
            $dataFinal = array();

            for ($i=0; $i < $resultado; $i++) { 
                $dataArray['Card_Id'] = $customer->cards[$i]->id;
                $dataArray['Name'] = $customer->cards[$i]->name;
                $dataArray['Last4'] = $customer->cards[$i]->last4;
                $dataArray['Exp_Month'] = $customer->cards[$i]->exp_month;
                $dataArray['Exp_Year'] = $customer->cards[$i]->exp_year;
                $dataArray['Brand'] = $customer->cards[$i]->brand;

                $dataFinal['card'+$i] = $dataArray;
                $dataArray = null;
            }

            $connection = null;
            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = $dataFinal;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else {
            $connection = null;

            $response['Message'] = " ";
            $response['IsError'] = false;
            $response['Data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }

    }catch(PDOException $e){
        //echo "Error: " . $e->getMessage();

            $response['Message'] = $e->getMessage();
            $response['IsError'] = false;
            $response['Data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(400);
            $app->response->body(json_encode($response));

    }
});


$app->post("/deleteCard/", function() use($app){


    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $card_Id = $data['Card_Id'];
    $client_Id = $data['Client_Id'];
    $response = array();

    try{

        $connection = getConnection();
        
        $dbh = $connection->prepare("SELECT Conekta_Id FROM Client WHERE Client_Id = :CID");
        $dbh->bindParam(':CID', $client_Id);
        $dbh->execute();
        $result = $dbh->fetchObject();



        if ($result != false) {



            $customer = Conekta_Customer::find($result->Conekta_Id);
            $resultado = count($customer->cards);

            for ($i=0; $i < $resultado; $i++) { 
                if ($card_Id == $customer->cards[$i]->id) {
                   $card = $customer->cards[$i]->delete();
                }
            }

            $dbh = $connection->prepare("DELETE FROM Card WHERE Client_Id = :CID AND Conekta_Card = :CC");
            $dbh->bindParam(':CID', $client_Id);
            $dbh->bindParam(':CC', $card_Id);
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
                $response['Message'] = "No se pudo eliminar la tarjeta";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));
            }

        }


    }catch(PDOException $e){
        $connection = null;
        $response['message'] = "OK";
        $response['IsError'] = false;
        $response['data'] = "Error: " . $e->getMessage();

        $app->response->headers->set("Content-type", "application/json");
        $app->response->status(400);
        $app->response->body(json_encode($response));
    }
});

