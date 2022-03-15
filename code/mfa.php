<?php
include("lib/includes.php");
include("vendor/autoload.php");
$gAuth = new \Google\Authenticator\GoogleAuthenticator();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if ($_POST['code'] == NULL) {
    $code = "";
  } else {
    $code = $_POST['code'];
  }
  logger($code, "DEBUG");
  $secret = "5VSUXM4WH4Y6TUN7";
  //logger($secret, "INFO");
  if ($gAuth->checkCode($secret, $code)) {
      $_SESSION['authenticated'] = True;
      // UPDATE: LOG SUCCESSFUL LOGIN ATTEMPTS
      logger('SUCCESS - ' . $log, 'INFO');
      //Redirect to admin area
      if ($_SESSION['username'] == 'admin') {
        header("Location: /admin.php");
        die();
      } else {
        header("Location: /index.php");
        die();
      } //UPDATE: Redirect non admins to the index.php page
  } else {
    echo "no";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form class='form-signin' action='' method='POST'>
<label for='inputUsername' class='sr-only'>CODE</label>
<input type='text' id='code' class='form-control' placeholder='code' required autofocus name='code'>
<button class='btn btn-lg btn-primary btn-block' type='submit'>Submit</button>
</form>
</body>
</html>