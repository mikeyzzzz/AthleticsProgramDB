<?php
include '../create_db/connect_to_db.php';

$db_name = 'test_db';

$conn = get_db_connection($db_name);

/* NOT using prepared statement:
$sql = "SELECT id, firstname, lastname FROM MyGuests";

$result = $conn->query($sql);
*/


//using prepared statement:
$stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests");

$stmt->execute();
$result = $stmt->get_result();

//var_dump($result);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>