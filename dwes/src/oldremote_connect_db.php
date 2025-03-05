<?php
$servername = "remotehost.es";
$username = "dwess1234";
$password = "test1234.";
$db_name = "dwesdatabase";



$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
} else {
}
