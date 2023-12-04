<?php
include 'db_user_pass.php';

// Create connection
$conn = @new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
	else{
	echo "Connected successfully";
	echo "<br>";
	echo "Now closing connection";
	$conn->close();
}
?>