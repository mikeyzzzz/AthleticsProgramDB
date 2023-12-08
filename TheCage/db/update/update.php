<?php
include '../create_db/connect_to_db.php';

$db_name = 'test_db';

$conn = get_db_connection($db_name);

$sql = "UPDATE MyGuests SET lastname=? WHERE id=?";

$last_name = 'Myers';
$id = 21; 

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $last_name, $id);

$stmt->execute();


if ($stmt->affected_rows > 0) {
    echo "Record updated successfully";
} else {
    echo "No record was updated ";
}

$stmt->close();

/*
NOT using prepared statement

// sql to delete a record
$sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

*/


$conn->close();
?>