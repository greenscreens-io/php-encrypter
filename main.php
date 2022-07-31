<?php
/**
 * Copyright (C) 2015 - 2022  Green Screens Ltd.
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


// OTP protected URL (create OTP at localhost:9080/otp)
// $code = getOTP("7OP4Y7NVCAJZP2KW");
// $json = encrypt($GREENSCREENS_SERVICE, "2", "DEMO", "QSECOFR", "MYPASSWORD", null, null, null, 0, null, $code);

// API KEY protected - access do not use opt or biometric adn password will not expire, access is validated by client ip and apikey regeistered ip 
// $api = "1a4e39c8-07d9-4a2b-b021-d1f4103d1a22";
// $json = encrypt($GREENSCREENS_SERVICE, "2", "DEMO", "QSECOFR", "MYPASSWORD", null, null, null, 0, null, 0, $api);

//$json = encrypt($GREENSCREENS_SERVICE, "0", "DEMO");

// generate http://localhost:9080/lite?d=[HEX encrypted AES]&k=[RSA encrypted AES]
$url = jsonToURLService($GREENSCREENS_SERVICE, $json);

print $url;
print "\n";

?>
