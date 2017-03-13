<?php
/**
 * Copyright (C) 2015, 2016  Green Screens Ltd.
 *
 * PHP lib demo to create Green Screens Web Terminal encrypted URL
 *
 */

require_once "funcs.php";

// Green Screens RSA service URL to get encryption public key
$GREENSCRES_SERVICE = "http://localhost:9080";

// encrypt with username and password
//$json = encrypt($RSA_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD");

// encrypt with username, password, program, menu, lib
//$json = encrypt($RSA_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD", "PROGRAM", "MENU", "LIB");

// if time limited url link is needed
// $exp = futureDays(5) or $exp = futureHours(2)
// $json = encrypt($RSA_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD", "", "", "", $exp);

$json = encrypt($GREENSCRES_SERVICE, "0", "DEMO");

// generate http://localhost:9080/lite?d=[HEX encrypted AES]&k=[RSA encrypted AES]
$url = jsonToURLService($GREENSCRES_SERVICE, $json);

print $url;
print "\n";

?>
