PHP Url Encrypter
===================


GreenScreens Web 5250 Terminal URL address uses custom encryption based on RSA algorithm generated at GreenScreens Terminal Service to protect URL parameters like auto sign-on data.  

Some clients require server side generation of terminal URL address inside their own software so here comes PHP URL Encrypter an integration supporting lib . 


### Example

Example usage to generate encrypted url address

```
require_once "funcs.php";

// Green Screens RSA service URL to get encryption public key
$RSA_SERVICE = "http://localhost:9080/services/auth";
$WEB_TERMINAL = "http://localhost:9080/lite";

// use only UUID and DEMO as a virtual host name
$json = encrypt($RSA_SERVICE, "0", "DEMO");

// generate http://localhost:9080/lite?d=[HEX ENRYPED]&k=[RSA encrypted AES]
$url = jsonToURL($WEB_TERMINAL, $json);

print $url;
print "\n";

```

#### Other login encryption options

To generate auto sign-on url address :

```
 $json = encrypt($RSA_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD");
```

To generate auto sign-on url address with program to start 

```
 $json = encrypt($RSA_SERVICE, "0", "DEMO", "QSECOFR", "MYPASWORD", "PROGRAM", "MENU", "LIB");
```

To generate url address with program to start on sign-on

```
 $json = encrypt($RSA_SERVICE, "0", "DEMO", null, null, "PROGRAM", "MENU", "LIB");
```

