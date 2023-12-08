<?php
include '../connect/db_user_pass.php';

// Create connection
$conn = @new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password']);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error); 
}

// Create database
$db_name = "test_db";
$sql = "CREATE DATABASE $db_name";
if ($conn->query($sql) === TRUE) {
    echo "Database '$db_name' created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

$conn->close();

?>