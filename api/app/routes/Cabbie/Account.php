<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");

$app->post("/cabbieLogin/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $email = $data['Email'];
    $password = $data['Password'];
    $gcm_id = $data['Gcm_Id'];
    $user_type = $data['User_Type'];

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT C.Cabbie_Id, C.FirstName, C.LastName, C.Email, C.Phone, C.Password, C.Salt,
            CD.Image
            FROM Cabbie C
            INNER JOIN CabbieDetail CD ON C.Cabbie_Id = CD.Cabbie_Id
            WHERE Email = :E");
        $dbh->bindParam(':E', $email);
        $dbh->execute();
        $cabbie = $dbh->fetchObject();
        
        if ($cabbie != false) {

            $chk = verify_encrypt_Password($password, $cabbie->Password, $cabbie->Salt);
            if ($chk) {

                $connection = null;

                $cabbieData = get_cabbie_data($cabbie);

                $response['Message'] = "OK";
                $response['IsError'] = false;
                $response['Data'] = $cabbieData;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));

            } else {
                $connection = null;

                $response['Message'] = "Contraseña Incorrecta";
                $response['IsError'] = true;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));
            }
        }
        else {
            $connection = null;

            $response['Message'] = "El correo no existe";
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


