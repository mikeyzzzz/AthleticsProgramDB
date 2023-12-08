<?php


include '../connect/connect_to_db.php';

$conn = get_db_connection();

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