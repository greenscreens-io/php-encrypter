<?php
/**
 * Copyright (C) 2015, 2016  Green Screens Ltd.
 *
 * PHP lib to create Green Screens Web Terminal encrypted URL
 *
 * Encryption lib from http://phpseclib.sourceforge.net/
 *
 * cURL program used to call remote Green Screens Terminal Service
 * to retrieve RSA enryption key.
 *
 * cURL PHP support can be inalled with 
 * sudo apt-get install php5-curl
 *
 */

set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');

require_once "Crypt/RSA.php";
require_once "Crypt/AES.php";

/*
 * cURL program caller
 *
 * In case of errors try to instal it on machine with
 * sudo apt-get install php5-curl
 */
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

/*
 * Retrieve RSA from remote service with cURL
 * Parse to JSON object
 *
 * {"succss": true, "ts" : 34532452354325, "key" : "PKCS12 ecded public key"}
 *
 *  $obj->{'key'};
 *  $obj->{'ts'};
 */
function getRSA($url)
{
    $json = CallAPI("GET", $url, false);

    $obj = json_decode($json);

    if ($obj->{'success'} != true) {
      print $json;
    }

    return $obj;
}


/*
 * Encrypt data with RSA public key
 */
function rsa_encrypt($string, $public_key)
{
    //Create an instance of the RSA cypher and load the key into it
    $cipher = new Crypt_RSA();
    $cipher->loadKey($public_key);
    //Set the encryption mode
    $cipher->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
    //Return the encrypted version
    return base64_encode($cipher->encrypt($string));
}


/*
 * Make 128 bit random string for AES key and IV
 */
function makeid($len) {
    $ALPHANUM = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $text = "";
    $poslen = strlen($ALPHANUM);
    $i = $len;
    $pos = 0;
    while ($i-- > 0 ) {
        $pos = floor(rand(0, 62));
        $text = $text . substr($ALPHANUM, $pos, 1);
    }
    return $text;
}


/*
 * Convert parameters to JSON structure
*/
function getJson($uuid = "", $host = "", $user = "user", $password = "", $program = "", $menu = "", $lib = "", $exp = 0)
{

    $json_data = array('uuid' => $uuid,
        'host' => $host,
        'user' => $user,
        'password' => $password,
        'program' => $program,
        'menu' => $menu,
        'lib' => $lib,
        'exp' => $exp
        );

     return json_encode($json_data);
}

/*
 * Encrypt login data and convert to JSON url string for 5250 terminal
 */
function encrypt($service = "", $uuid = "", $host = "", $user = "user", $password = "", $program = "", $menu = "", $lib = "", $exp = 0;)
{

  // login params
  $params = getJson($uuid, $host, $user, $password, $program, $menu, $exp);
  return encryptJson($service, $params);

}

/**
 * Encrypt JSON object for GreenScreens 5250 Web Terminal
 */
function encryptJson($service = "", $jsonObj)
{

  // retrieve JSON object with RSA and ts values
  $rsaObj = getRSA($service . "/services/auth");
  $rsaKey = $rsaObj->{'key'};

  // prepare AES
  $aesKey = makeid(16);
  $aesIV = makeid(16);

  $cipher = new Crypt_AES(CRYPT_AES_MODE_OFB);
  $cipher->setKeyLength(128);
  $cipher->setKey($aesKey);
  $cipher->setIV($aesIV);


  // encrypt params and convert to hex data
  $encrypted = $cipher->encrypt($jsonObj);
  $hex = bin2hex($encrypted);

  // encrypt aes with rsa
  $aesRsa =  $aesIV . $aesKey;
  $aesRsaEncrypted = rsa_encrypt($aesRsa, $rsaKey);
  
  $json_data = array('d' => $hex,
        'k' => $aesRsaEncrypted,
        'v' => 0);
  return $json_data;
}

/**
 * Convert JSON object to url string
 */
function jsonToURLService($url = "", $json)
{
    $params = jsonToURL($json);
    return $url . "/lite?" . $params;
}

/*
 * Iterate over JSON object properties and create query string
 */
function jsonToURL($json)
{

 $parm = "";
 $obj = $json;

 foreach ($json as $key => $value) {
    $parm = $parm . $key . "=" . $value . "&";
 }

 return $parm;

}

/*
 * Get Java/Javascript timestap in future
 */
function getTimestamp($future)
{
  $date = new DateTime();

  // php timestamp to java/javascript format * future date
  $timestamp = $date->getTimestamp() * 1000 * $future;

 return $timestamp;
}


/*
 * Get Java/Javascript timestap in future in hours
 */
function futureHours($hours)
{
  // 24h, 60, 60s
  $future = $hours * 60 * 60;
  return getTimestamp($future);
}

/*
 * Get Java/Javascript timestap in future in hours
 */
function futureDays($days)
{
  // 5day, 24h, 60, 60s
  $future = $days * 24 * 60 * 60;
  return getTimestamp($future);
}

?>