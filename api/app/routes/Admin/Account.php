<?php
if (!defined('SPECIALCONSTANT')) die("Acceso Denegado");


//log in and log out
$app->post("/loginSystem/", function() use($app){

	$json = $app->request->getBody();
    $data = json_decode($json, true);

    $dataf = $data['data'];
	$email = $dataf['Email'];
	$password = $dataf['Password'];
	$response = array();

	try{

		$connection = getConnection();
		$dbh = $connection->prepare("SELECT Admin_Id, Company, Email, Encrypted_Password, Salt FROM Admin WHERE Email = :E");
		$dbh->bindParam(':E', $email);
		$dbh->execute();

		$admin_user = $dbh->fetchObject();
		
		if ($admin_user != false) {
			
			$salt = $admin_user->Salt;
	        $encrypted_password = $admin_user->Encrypted_Password;

	        $hash = base64_encode(sha1($password . $salt, true) . $salt);

	        if ($encrypted_password == $hash) {
		        if (!isset($_SESSION)) {
		            session_start();
		        }
		        $_SESSION['uid'] = $admin_user->Admin_Id;
		        $_SESSION['email'] = $email;
		        $_SESSION['name'] =  $admin_user->Company;
				$connection = null;

				$response['message'] = "OK";
				$response['IsError'] = false;
				$response['data'] = $admin_user;


				$app->response->headers->set("Content-type", "application/json");
				$app->response->status(200);
				$app->response->body(json_encode($response));

	     	} else {
	            $connection = null;
				$app->response->headers->set("Content-type", "application/json");
				$app->response->status(400);
				$app->response->body(json_encode("Contraseña Incorrecta"));
	    	}
		}

		else {
            $connection = null;
			$app->response->headers->set("Content-type", "application/json");
			$app->response->status(400);
			$app->response->body(json_encode("Correo no existe"));
        }

	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
});

$app->get("/session/", function() use($app){

	if (!isset($_SESSION)) {
            session_start();
        }
        $sess = array();
        if(isset($_SESSION['uid']))
        {
            $sess["uid"] = $_SESSION['uid'];
            $sess["name"] = $_SESSION['name'];
            $sess["email"] = $_SESSION['email'];
        }
        else
        {
            $sess["uid"] = '';
            $sess["name"] = 'Guest';
            $sess["email"] = '';
        }
        $app->response->body(json_encode($sess));
});

$app->get("/logout/", function() use($app){
	if (!isset($_SESSION)) {
	    session_start();
	    }
	    if(isSet($_SESSION['uid']))
	    {
	        unset($_SESSION['uid']);
	        unset($_SESSION['name']);
	        unset($_SESSION['email']);
	        $info='info';
	        if(isSet($_COOKIE[$info]))
	        {
	            setcookie ($info, '', time() - $cookie_time);
	        }
	        $msg="Logged Out Successfully...";
	    }
	    else
	    {
	        $msg = "Not logged in...";
	    }
	    $app->response->body(json_encode($msg));
});