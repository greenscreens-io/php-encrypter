<?php
/**
 * Copyright (C) 2015, 2016  Green Screens Ltd.
 *
 * PHP lib demo to create Green Screens Web Terminal encrypted URL
 *
 */
 if  (!in_array  ('curl', get_loaded_extensions())) {
    echo "cURL is not installed on this server";
}

//echo json_encode(get_loaded_extensions());
//echo phpinfo();

require_once "funcs.php";

// Green Screens RSA service URL to get encryption public key
$GREENSCREENS_SERVICE = "http://localhost:9080";

// encrypt with username and password
//$json = encrypt($GREENSCREENS_SERVICE, "0", "DEMO", "QSECOFR", "MYPASSWORD");

// encrypt with username, password, program, menu, lib
//$json = encrypt($GREENSCREENS_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD", "PROGRAM", "MENU", "LIB");

// if time limited url link is needed
// $exp = futureDays(5) ; //or $exp = futureHours(2)
// $json = encrypt($GREENSCREENS_SERVICE, "2", "DEMO", "QSECOFR", "MYPASSWORD", null, null, null, $exp, " ");

//$json = encrypt($GREENSCREENS_SERVICE, "0", "DEMO");

// generate http://localhost:9080/lite?d=[HEX encrypted AES]&k=[RSA encrypted AES]
$url = jsonToURLService($GREENSCREENS_SERVICE, $json);

print $url;
print "\n";

?>
