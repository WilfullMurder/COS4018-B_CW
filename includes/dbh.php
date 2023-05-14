<?php


$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "phplogin";

$con = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

if(!$con)
{
	die("Connection failed: " .mysqli_connect_error());
}
?>