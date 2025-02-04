<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
//remove to token from cookies
setcookie('access_token','',time()-3600,'/');
header('Location: ../user-login.php'); // Redirect to the login page
exit();
?>
