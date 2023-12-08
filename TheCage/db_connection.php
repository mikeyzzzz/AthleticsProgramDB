<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "thecage";
$conn = new mysqli($servername, $username, $password, $db_name, 8080);

if($conn->connect_error)
{
	die("Connection failed".$conn->connect_error);
	
}
?>