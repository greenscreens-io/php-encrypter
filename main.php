<?php
/**
 * Copyright (C) 2015, 2016  Green Screens Ltd.
 *
 * PHP lib demo to create Green Screens Web Terminal encrypted URL
 *
 */

require_once "funcs.php";

// Green Screens RSA service URL to get encryption public key
$RSA_SERVICE = "http://localhost:9080/services/auth";
$WEB_TERMINAL = "http://localhost:9080/lite";

//$json = encrypt($RSA_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD");
//$json = encrypt($RSA_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD", "PROGRAM", "MENU", "LIB");

$json = encrypt($RSA_SERVICE, "0", "DEMO");

// generate http://localhost:9080/lite?d=[HEX ENRYPED]&k=[RSA encrypted AES]
$url = jsonToURL($WEB_TERMINAL, $json);

print $url;
print "\n";

?>
