<?php

$host = "192.168.2.7";    /* Host name */
$user = "administrator";         /* User */
$password = "Pruebas123$";         /* Password */
$dbname = "xtamdb";   /* Database name */

// Create connection
$con = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
