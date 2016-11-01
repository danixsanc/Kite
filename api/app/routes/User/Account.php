<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");

$app->post("/userLogin/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);
 
    $email = $data['Email'];
    $password = $data['Password'];
    $gcm_id = $data['Gcm_Id'];
    $user_type = $data['User_Type'];
    $login_fb = $data['Login_Fb'];

    try{

        $connection = getConnection();
        $dbh = $connection->prepare("SELECT Cl.Client_Id, Cl.Conekta_Id, Cl.FirstName, Cl.LastName, Cl.Email, Cl.Phone, Cl.Password, Cl.Salt, Ca.Conekta_Card
            FROM Client Cl
            LEFT JOIN Card Ca ON Cl.Client_Id = Ca.Client_Id WHERE Email = :E");
        $dbh->bindParam(':E', $email);
        $dbh->execute();
        $user = $dbh->fetchObject();
        
        if ($user != false) {

            if ($login_fb) {
                $connection = null;

                $userData = get_user_data($user);

                $response['Message'] = "OK";
                $response['IsError'] = false;
                $response['Data'] = $userData;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));
            }
            else{
                $chk = verify_encrypt_Password($password, $user->Password, $user->Salt);
                if ($chk) {

                    $connection = null;

                    $userData = get_user_data($user);

                    $response['Message'] = "OK";
                    $response['IsError'] = false;
                    $response['Data'] = $userData;

                    $app->response->headers->set("Content-type", "application/json");
                    $app->response->status(200);
                    $app->response->body(json_encode($response));

                } else {
                    $connection = null;

                    $response['Message'] = "Contraseña Incorrecta";
                    $response['IsError'] = false;
                    $response['Data'] = null;

                    $app->response->headers->set("Content-type", "application/json");
                    $app->response->status(200);
                    $app->response->body(json_encode($response));
                }
            }
            
        }
        else
        {
            if ($login_fb) {
                $connection = null;

                $response['Message'] = "fb";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response)); 
            }
            else{
                $connection = null;

                $response['Message'] = "El correo no existe";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response)); 
            }
            
        }

    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
});

$app->post("/userRegister/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $firstname = $data['FirstName'];
    $lastname = $data['LastName'];
    $phone = $data['Phone'];
    $email = $data['Email'];
    $password = $data['Password'];
    $gcm_id = $data['Gcm_Id'];
    $user_type = $data['User_Type'];
    $client_actv = '1';

    $response = array();

    try{

        $connection = getConnection();
        
        $dbh = $connection->prepare("SELECT Email, Phone FROM Client WHERE Email = :E OR Phone = :P");
        $dbh->bindParam(':E', $email);
        $dbh->bindParam(':P', $phone);
        $dbh->execute();
        $user = $dbh->fetchObject();

        if ($user) {
            if ($user->Email == $email) {

            $connection = null;
            $response['Message'] = "El correo ya se encuentra registrado";
            $response['IsError'] = false;
            $response['Data'] = null;

            $app->response->headers->set("Content-type", "application/json");
            $app->response->status(200);
            $app->response->body(json_encode($response));
            }
            else if ($user->Phone == $phone) {

                $connection = null;
                $response['Message'] = "El telefono ya se encuentra registrado";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));
            }
        }
        
        else{
            
            $customer = Conekta_Customer::create(
              array(
                'name'  => $firstname . ' ' . $lastname,
                'email' => $email,
                'phone' => $phone
              )
            );

            $hash = encrypt_password($password);
            $Encrypted_Password = $hash["encrypted"];
            $Salt = $hash["salt"];


            $dbh = $connection->prepare("INSERT INTO Client (Conekta_Id, FirstName, LastName, Phone, Email, Password, Salt, Gcm_Id, Created_At, User_Type_Id, ClientActv_Id) 
                VALUES( :CI, :FN, :LN, :P, :E, :EP, :S, :GI, NOW(), :CT, :CA)");
            $dbh->bindParam(':CI', $customer->id);
            $dbh->bindParam(':FN', $firstname);
            $dbh->bindParam(':LN', $lastname);
            $dbh->bindParam(':P', $phone);
            $dbh->bindParam(':E', $email);
            $dbh->bindParam(':EP', $Encrypted_Password);
            $dbh->bindParam(':S', $Salt);
            $dbh->bindParam(':GI', $gcm_id);
            $dbh->bindParam(':CT', $user_type);
            $dbh->bindParam(':CA', $client_actv);
            $dbh->execute();

            if ($dbh) {

                $id = $connection->lastInsertId();
                $dbh = $connection->prepare("SELECT Client_Id, FirstName, LastName, Email, Phone FROM Client WHERE Client_Id = :ID");
                $dbh->bindParam(':ID', $id);
                $dbh->execute();
                $user = $dbh->fetchObject();

                $userData = get_user_data($user);

                if ($user != false) {


                    $connection = null;
                    $response['Message'] = "OK";
                    $response['IsError'] = false;
                    $response['Data'] = $userData;

                    $app->response->headers->set("Content-type", "application/json");
                    $app->response->status(200);
                    $app->response->body(json_encode($response));
                }
            }
        }

    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
});

$app->post("/userUpdate/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $client_id = $data['Client_Id'];
    $password = $data['Password'];
    $newPassword = $data['NewPassword'];
    $image = $data['Image'];
    $changePassword = $data['ChangePassword'];
    $response = array();

    try{

        if ($changePassword) {
            $connection = getConnection();
            $dbh = $connection->prepare("SELECT Password, Salt FROM Client WHERE Client_Id = :CID");
            $dbh->bindParam(':CID', $client_id);
            $dbh->execute();
            $result = $dbh->fetchObject();

            $chk = verify_encrypt_Password($password, $result->Password, $result->Salt);
            if ($chk) {
                $hash = encrypt_password($newPassword);
                $Encrypted_Password = $hash["encrypted"];
                $Salt = $hash["salt"];

                $dbh = $connection->prepare("UPDATE Client SET Password = :P, Salt = :S WHERE Client_Id = :CID");
                $dbh->bindParam(':P', $Encrypted_Password);
                $dbh->bindParam(':S', $Salt);
                $dbh->bindParam(':CID', $client_id);
                $dbh->execute();

                if ($dbh) {
                    $connection = null;
                    $response['Message'] = "Contraseña actualizada correctamente";
                    $response['IsError'] = false;
                    $response['Data'] = null;

                    $app->response->headers->set("Content-type", "application/json");
                    $app->response->status(200);
                    $app->response->body(json_encode($response));
                }
                else{
                    $connection = null;
                    $response['Message'] = "No se pudo actualizar la contraseña";
                    $response['IsError'] = false;
                    $response['Data'] = null;

                    $app->response->headers->set("Content-type", "application/json");
                    $app->response->status(200);
                    $app->response->body(json_encode($response));
                }
            }
        }
        else {
            $connection = getConnection();
            $dbh = $connection->prepare("UPDATE FROM Client SET Image = :I WHERE Client_Id = :CID");
            $dbh->bindParam(':I', $image);
            $dbh->bindParam(':CID', $client_id);
            $dbh->execute();

            if ($dbh) {
                $connection = null;
                $response['Message'] = "Imagen actualizada correctamente";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));
            }
            else{
                $connection = null;
                $response['Message'] = "No se pudo actualizar la imagen";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_encode($response));
            }
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


