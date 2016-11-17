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

//$json = encrypt($RSA_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD");
//$json = encrypt($RSA_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD", "PROGRAM", "MENU", "LIB");

$json = encrypt($GREENSCRES_SERVICE, "0", "DEMO");

// generate http://localhost:9080/lite?d=[HEX encrypted AES]&k=[RSA encrypted AES]
$url = jsonToURLService($GREENSCRES_SERVICE, $json);

print $url;
print "\n";

?>
