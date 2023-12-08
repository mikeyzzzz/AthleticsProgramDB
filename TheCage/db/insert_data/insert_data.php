<?php

include '../create_db/connect_to_db.php';

$db_name = 'test_db';

$conn = get_db_connection($db_name);

// sql to create table
$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com')";

if ($conn->query($sql) === TRUE) {
	// if one of the fields is auto increment, you can retrieve the id of the last insertion
	$last_id = $conn->insert_id;
    echo "Data inserted into MyGuests successfully";
	echo "<br>";
	echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
    echo "Error inserting data" . $conn->error;
}

$conn->close();

?>