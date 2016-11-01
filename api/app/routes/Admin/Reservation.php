<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");



$app->get("/get_Reservations/", function() use($app){

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT CONCAT(CL.FirstName, ' ', CL.LastName) AS ClientName,CL.Phone,RQ.Inicio,
            RQ.Destino,RQ.Price,RQ.Date, CONCAT(CB.FirstName, ' ', CB.LastName) AS cabbie_name,RS.Description,
            RE.Reservation_Id FROM reservation RE
            INNER JOIN request RQ ON RE.Request_Id = RQ.Request_Id
            INNER JOIN client CL ON RQ.Client_Id = CL.Client_Id
            INNER JOIN cabbie CB ON RQ.Cabbie_Id = CB.Cabbie_Id
            INNER JOIN requeststatus RS ON RQ.RequestStatus_Id = RS.RequestStatus_Id");
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
