<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");

$app->post("/getFavoritePlace/", function() use($app){


    $json = $app->request->getBody();
    $data = json_decode($json, true);
    $client_Id = $data['Client_Id'];

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT Place_Favorite_Id, Name, Description, Latitude, Longitude FROM Place_Favorite WHERE Client_Id = :CID");
        $dbh->bindParam(':CID', $client_Id);
        $dbh->execute();

        $favoriteplace = $dbh->fetchAll(PDO::FETCH_ASSOC);
        
        if ($favoriteplace != false) {

            $connection = null;
            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = $favoriteplace;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else {
            $connection = null;

            $response['Message'] = "No hay favoritos";
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

$app->post("/setFavoritePlace/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);


        $Latitude = $data['Latitude'];
        $Longitude = $data['Longitude'];
        $Name = $data['Name'];
        $Description = $data['Description'];
        $Client_Id = $data['Client_Id'];


    $response = array();

    try{

        $connection = getConnection();
        
        $dbh = $connection->prepare("SELECT Name FROM Place_Favorite WHERE Name = :N AND Client_Id = :CID");
        $dbh->bindParam(':N', $Name);
        $dbh->bindParam(':CID', $Client_Id);
        $dbh->execute();

        $fav_place = $dbh->fetchObject();

        if ($fav_place) {
            

            $connection = null;
            $response['Message'] = "El lugar ya se encuentra registrado";
            $response['IsError'] = true;
            $response['Data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }

        
        
        else{
                        
            $dbh = $connection->prepare("INSERT INTO Place_Favorite (Latitude, Longitude, Name, Description, Client_Id) 
                VALUES( :LN, :LG, :N, :D, :CID)");
            $dbh->bindParam(':LN', $Latitude);
            $dbh->bindParam(':LG', $Longitude);
            $dbh->bindParam(':N', $Name);
            $dbh->bindParam(':D', $Description);
            $dbh->bindParam(':CID', $Client_Id);
            $dbh->execute();

            if ($dbh) {
            
                $lastIdArray = array();
                $lastId = $connection->lastInsertId();


                $connection = null;
                $response['Message'] = "Registrado Correctamente";
                $response['IsError'] = false;
                $response['Data'] = $lastId;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));
            }
        }

    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
});


$app->get("/getFavoritePlace/:id", function($id) use($app){

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT Name, Description, Latitude, Longitude FROM Place_Favorite WHERE Client_Id = :CID");
        $dbh->bindParam(':CID', $id);
        $dbh->execute();

        $favoriteplace = $dbh->fetchObject();
        
        if ($favoriteplace != false) {

            $connection = null;
            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['Data'] = $favoriteplace;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else {
            $connection = null;

            $response['Message'] = "No hay favoritos..";
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




$app->post("/deleteFavoritePlace/", function() use($app){


    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $client_Id = $data['Client_Id'];
    $place_Id = $data['Place_Id'];
    $response = array();

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("DELETE FROM Place_Favorite WHERE (Client_Id = :CID) AND (Place_Favorite_Id = :PFID)");
        $dbh->bindParam(':CID', $client_Id);
        $dbh->bindParam(':PFID', $place_Id);
        $dbh->execute();

        if ($dbh == true) {
            $connection = null;
            $response['Message'] = "OK";
            $response['IsError'] = false;
            $response['data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
        }
        else {
            $connection = null;
            $response['Message'] = "No se pudo eliminar el lugar";
            $response['IsError'] = false;
            $response['data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
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



$app->post("/updateFavoritePlace/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $F_Id = $data['Place_Favorite_Id'];
    $Name = $data['Name'];

    $response = array();

    try{


            $connection = getConnection();
            $dbh = $connection->prepare("UPDATE Place_Favorite SET Name = :N WHERE Place_Favorite_Id = :FID");
            $dbh->bindParam(':N', $Name);
            $dbh->bindParam(':FID', $F_Id);
            $dbh->execute();

            if ($dbh) {
                $connection = null;
                $response['Message'] = "Nombre actualizado correctamente";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));
            }
            else{
                $connection = null;
                $response['Message'] = "No se pudo actualizar el nombre";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));
            }
        

    }catch(PDOException $e){
        $response['Message'] = $e->getMessage();
        $response['IsError'] = true;
        $response['Data'] = null;

        $app->response->headers->set("Content-type", "application/json");
        $app->response->status(200);
        $app->response->body(json_encode($response));
    }
});

