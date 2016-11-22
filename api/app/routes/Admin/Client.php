<?php 
   $app->post("/create_logo/", function() use($app){

    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $dataf = $data['data'];
    $idCompany = $dataf['idCompany'];
    $companyLogo = $dataf['Logo'];
    $response = array();

    try{
        $connection = getConnection();
        $dbh = $connection->prepare("INSERT INTO Campaign (idCompany, Logo) VALUES(:iC, :CL)");
        $dbh->bindParam(':iC', $idCompany);
        $dbh->bindParam(':CL', $companyLogo);
        $dbh->execute();

            if ($dbh) 
            {
                $connection = null;
                $response['Message'] = "OK";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_decode($response));
            }else
            {
                $connection = null;
                $response['Message'] = "Error al guardar datos";
                $response['IsError'] = true;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->body(json_decode($response));
            }

    }catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

});

   $app->post("/get_Logo_ById/", function() use($app){
    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $dataf = $data['data'];
    $idCampaign = $dataf['idCampaign'];
    $response = array();

    try {
         $connection = getConnection();
         $dbh = $connection->prepare("SELECT Logo FROM Campaign WHERE idCampaign = ':IC'");
         $dbh->bindParam(':IC', $idCampaign);
         $dbh->execute();
         $logo = $dbh->fetchAll(PDO::FETCH_ASSOC);


            if ($dbh) 
            {
                $connection = null;
                $response['Message'] = "OK";
                $response['IsError'] = false;
                $response['Data'] = $logo;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_decode($response));
            }else
            {
                $connection = null;
                $response['Message'] = "Error al guardar datos";
                $response['IsError'] = true;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->body(json_decode($response));
            }

     } catch (PDOException $e) {
         echo "Error: " . $e->getMessage();
     } 
   });
    
      $app->post("/update_Logo_ById/", function() use($app){
    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $dataf = $data['data'];
    $idCampaign = $dataf['idCampaign'];
    $companyLogo = $dataf['Logo'];
    $response = array();

    try {
         $connection = getConnection();
         $dbh = $connection->prepare("UPDATE Campaign SET Logo = :CL WHERE idCampaign = :IC");
         $dbh->bindParam(':IC', $idCampaign);
         $dbh->bindParam(':CL', $companyLogo);
         $dbh->execute();


            if ($dbh) 
            {
                $connection = null;
                $response['Message'] = "OK";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_decode($response));
            }else
            {
                $connection = null;
                $response['Message'] = "Error al actualizar logo";
                $response['IsError'] = true;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->body(json_decode($response));
            }

     } catch (PDOException $e) {
         echo "Error: " . $e->getMessage();
     } 
   });


      $app->post("/delete_Logo_ById/", function() use($app){
    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $dataf = $data['data'];
    $idCampaign = $dataf['idCampaign'];
    $response = array();

    try {
         $connection = getConnection();
         $dbh = $connection->prepare("DELETE Logo FROM Campaign WHERE idCampaign = :IC");
         $dbh->bindParam(':IC', $idCampaign);
         $dbh->execute();


            if ($dbh) 
            {
                $connection = null;
                $response['Message'] = "OK";
                $response['IsError'] = false;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->status(200);
                $app->response->body(json_decode($response));
            }else
            {
                $connection = null;
                $response['Message'] = "Error al Eliminar Logo";
                $response['IsError'] = true;
                $response['Data'] = null;

                $app->response->headers->set("Content-type", "application/json");
                $app->response->body(json_decode($response));
            }

     } catch (PDOException $e) {
         echo "Error: " . $e->getMessage();
     } 
   });
    



 ?>