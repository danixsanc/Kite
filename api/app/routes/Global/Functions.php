<?php
if (!defined('SPECIALCONSTANT')) die ("Acceso Denegado");

function get_cabbie_data($cabbie){
    $dataResp = array();
    $dataResp['Cabbie_Id'] = $cabbie->Cabbie_Id;
    $dataResp['Name'] = $cabbie->FirstName . ' ' . $cabbie->LastName;
    $dataResp['Email'] = $cabbie->Email;
    $dataResp['Phone'] = $cabbie->Phone;
    $dataResp['Image'] = base64_encode($cabbie->Image);
    return $dataResp;
}

function verify_encrypt_Password ($Password, $Encrypted_Password, $Salt){

    $hash = base64_encode(sha1($Password . $Salt, true) . $Salt);
    if ($Encrypted_Password == $hash)
        return true;
    return false;
    
};

function encrypt_password ($Password){

    $salt = sha1(rand());
    $salt = substr($salt, 0, 10);
    $encrypted = base64_encode(sha1($Password . $salt, true) . $salt);
    $hash = array("salt" => $salt, "encrypted" => $encrypted);
    return $hash;
    
};

function get_user_data($user){
    $dataResp = array();
    $dataResp['Client_Id'] = $user->Client_Id;
    $dataResp['Name'] = $user->FirstName . ' ' . $user->LastName;
    $dataResp['Email'] = $user->Email;
    $dataResp['Phone'] = $user->Phone;
    return $dataResp;
};

function distance($lat1, $lon1, $lat2, $lon2) {

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return ($miles * 1.609344);
};


function timer($time){
    $total = "";
    for ($segundos = 1; $segundos <= $time; $segundos++)
    {
        sleep($segundos);
        $total = $segundos;
    }
    return true;
};





