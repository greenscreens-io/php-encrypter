<?php
/**
 * Copyright (C) 2015, 2016  Green Screens Ltd.
 *
 * Simple example of reading and parsing CSV file to 
 * automatically generate user web terminal links
 * 
 * Read more on
 * http://blog.greenscreens.io/automatic-remote-configuration/
 */

require_once "funcs.php";

// Green Screens RSA service URL to get encryption public key
$GREENSCREENS_SERVICE = "http://localhost:8080";
$CSV = "./sample.csv";

/*
* Read CSV file and process line by line
*/
function doCSV($fileName)  
{
  $csvFile = file($fileName);
  $data = [];
  foreach ($csvFile as $line) {
    $data[] = str_getcsv($line);

    $pieces = explode(";", $data[0][3]);
    foreach ($pieces as $piece) {
      $url = encryptCSVLine($data[0][0], $data[0][1], $data[0][2], $piece);
      // get email from $data[0][4] and send it to the user
      print $url;
      print "\n";
    }
  }
}

/*
 * Encrypt CSV line into URL
 */
function encryptCSVLine($uuid, $host, $user, $displayName)
{
   global $GREENSCREENS_SERVICE;

   $json_data = array('uuid' => $uuid,
            'host' => $host,
            'user' => $user,
            'displayName' => $displayName
            );

    $data = json_encode($json_data);
    $json = encryptJson($GREENSCREENS_SERVICE, $data);

    // generate http://localhost:9080/lite?d=[HEX encrypted AES]&k=[RSA encrypted AES]
    $url = jsonToURLService($GREENSCREENS_SERVICE, $json);

    return $url;
}

// start procesing csv file
doCSV($CSV)

?>