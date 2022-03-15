<?php include("templates/page_header.php");?>
<?php

include("vendor/autoload.php");
$gAuth = new \Google\Authenticator\GoogleAuthenticator();
$secret = "5VSUXM4WH4Y6TUN7";

echo "<img src='" . $gAuth->getUrl($_SESSION['username'], "example.com", $secret) . "'>";

?>