<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");

$app->get("/get_Requests/", function() use($app){

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT RQ.Request_Id,RQ.Inicio,RQ.Destino,RQ.Date,RQ.Price,
            RQ.PaymentType_Id,PT.Description,CONCAT(CB.FirstName, ' ', CB.LastName) AS cabbie_name FROM request RQ
            INNER JOIN paymenttype PT ON RQ.PaymentType_Id = PT.PaymentType_Id
            INNER JOIN cabbie CB ON RQ.Cabbie_Id = CB.Cabbie_Id");
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
