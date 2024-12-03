<?php
$servername = "bo7u6pimi9mondx2jxvm-mysql.services.clever-cloud.com";
$username = "ujcxv1mcmvh3szov";
$password = "HC2zESAuuPDUBO3WLngB";
$db_name = "bo7u6pimi9mondx2jxvm";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db_name);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>