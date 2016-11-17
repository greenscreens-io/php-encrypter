PHP Url Encrypter
===================


GreenScreens Web 5250 Terminal URL address uses custom encryption based on RSA algorithm generated at GreenScreens Terminal Service to protect URL parameters like auto sign-on data.  

Some clients require server side generation of terminal URL address inside their own software so here comes PHP URL Encrypter an integration supporting lib . 


### Example

Example usage to generate encrypted url address

```
<?php
require_once "funcs.php";

// Green Screens RSA service URL to get encryption public key
$GREENSCRES_SERVICE = "http://localhost:9080";

// use only UUID and DEMO as a virtual host name
$json = encrypt($GREENSCRES_SERVICE, "0", "DEMO");

// generate http://localhost:9080/lite?d=[HEX encrypted AES]&k=[RSA encrypted AES]
$url = jsonToURLService($GREENSCRES_SERVICE, $json);

print $url;
print "\n";

?>
```

Result should be like this one :

http://localhost:9080/lite?d=fb23201e3177d13acba2008d683ccee4cd4b7ba5de14216b3875531bb3e5f94baffe4249715a311ef3e373aa5565520bfc449012ee393f11ed063dc532cf275d9815bee5032faeb24110c17a7e8dfeccf03b42271f18&k=I4IfEXH1SXgUNinuGzxBc0Su2bvvIE8BlDBx5x1+zm8f0dfpomYOo3/RGsa7bWHFIt5or3O7Ro6/ZoRieZxdnFRNs9Slpor8WZ9BMzVMZ87qPS2dDJMNCwWu5HVSqhPxU2m6vdY0FQYMhMDu8PjsiJMUDpn8wM5rQyxNgu7q5Tk=&v=0&


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

