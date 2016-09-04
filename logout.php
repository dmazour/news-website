<?php

// This file logs the user out by changing the session variable and returning the user to the log-in screen.

session_start();
$_SESSION["username"] = "";
header("Location: http://ec2-52-22-158-9.compute-1.amazonaws.com/fall2015-module3-greg-lubin-424128-dan-mazour-431275/mod3index.php");
exit;

?>

