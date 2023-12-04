<?php
include '../create_db/connect_to_db.php';

$db_name = 'test_db';

$conn = get_db_connection($db_name);

// sql to delete a record
$sql = "DELETE FROM MyGuests WHERE id=?";
$id = 23;

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Record deleted successfully";
} else {
    echo "No records deleted ";
}

$stmt->close();

/*
NOT using prepared statement

// sql to delete a record
$sql = "DELETE FROM MyGuests WHERE id=3";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

*/


$conn->close();
?>