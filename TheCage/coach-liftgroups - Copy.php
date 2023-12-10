<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: coach-login.php"); // Redirect to the login page if not logged in
    exit();
}

// Access session variables
$username = $_SESSION['username'];
$password = $_SESSION['password'];

// Get SportID for the current coach
$getSportIDQuery = "SELECT SportID FROM Coach WHERE Username = '$username'";
$sportIDResult = $conn->query($getSportIDQuery);

if ($sportIDResult->num_rows > 0) {
    $sportIDRow = $sportIDResult->fetch_assoc();
    $SportID = $sportIDRow['SportID'];
} else {
    // Handle the case where SportID is not found for the coach
    echo "SportID not found for the coach.";
    exit();
}

// Function to get a list of athletes for the datalist, including a null option
function getAthleteList($conn, $SportID)
{
    $athleteListQuery = "SELECT AthleteID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Athlete 
                         WHERE LiftGroupID IS NULL AND SportID = '$SportID'";
    $athleteListResult = $conn->query($athleteListQuery);

    $options = '<option value="" selected>Select Athlete</option>';
    while ($row = $athleteListResult->fetch_assoc()) {
        $options .= '<option value="' . $row['FullName'] . '">' . $row['FullName'] . '</option>';
    }

    // Add an empty spot with a placeholder value
    $options .= '<option value="null-placeholder">Empty Spot</option>';

    return $options;
}


// Handle creating a lift group
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['createLiftGroup'])) {
    $selectedAthletes = $_POST['selectedAthletes'];

    // Validate and process the selected athletes
    if (count($selectedAthletes) >= 3 && count($selectedAthletes) <= 5) {
        // Create a new lift group and insert into the database
        $insertLiftGroupQuery = "INSERT INTO LiftGroup (SportID) VALUES ('$SportID')";
        $conn->query($insertLiftGroupQuery);
        $liftGroupID = $conn->insert_id;

        // Insert athletes into the lift group
        foreach ($selectedAthletes as $athleteName) {
            // Check if the placeholder value was selected
            if ($athleteName != 'null-placeholder') {
                // Get the AthleteID based on the selected name
                $getAthleteIDQuery = "SELECT AthleteID FROM Athlete WHERE CONCAT(FirstName, ' ', LastName) = '$athleteName'";
                $athleteIDResult = $conn->query($getAthleteIDQuery);

                if ($athleteIDResult->num_rows > 0) {
                    $athleteIDRow = $athleteIDResult->fetch_assoc();
                    $athleteID = $athleteIDRow['AthleteID'];

                    // Update the Athlete's LiftGroupID
                    $updateAthleteQuery = "UPDATE Athlete SET LiftGroupID = $liftGroupID WHERE AthleteID = $athleteID";
                    $conn->query($updateAthleteQuery);
                } else {
                    echo "Error: AthleteID not found for $athleteName.";
                }
            }
        }
    } else {
        echo "Invalid number of selected athletes for a lift group.";
    }
}


// Handle deleting a lift group
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteLiftGroup'])) {
    $liftGroupIDToDelete = $_POST['deleteLiftGroup'];

    // Reset LiftGroupID for athletes in the deleted lift group
    $resetAthletesQuery = "UPDATE Athlete SET LiftGroupID = NULL WHERE LiftGroupID = '$liftGroupIDToDelete'";
    $conn->query($resetAthletesQuery);

    // Delete the lift group
    $deleteLiftGroupQuery = "DELETE FROM LiftGroup WHERE LiftGroupID = '$liftGroupIDToDelete'";
    $conn->query($deleteLiftGroupQuery);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: auto;
            text-align: center;
            border: 2px solid black;
            padding: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            background-color: #fff;
            margin-top: 50px;
        }

        .back-btn-to-dashboard {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        h1 {
            color: #333;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
        }

        label {
            flex: 0 0 48%;
            margin-bottom: 10px;
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
			autocomplete=off;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        td button {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="coach-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>Lift Groups</h1>

        <form method="POST" action="">
    <?php
    // Add 5 datalist boxes for selecting athletes
    for ($i = 1; $i <= 5; $i++) {
        echo '<label for="athleteSelect' . $i . '">Select Athlete ' . $i . ':</label>';
        echo '<input list="athletes' . $i . '" name="selectedAthletes[]" class="athlete-select" id="athleteSelect' . $i . '" required>';
        echo '<datalist id="athletes' . $i . '">';
        echo getAthleteList($conn, $SportID); // Pass $SportID as a parameter
        echo '</datalist>';
    }
    ?>

    <button type="submit" name="createLiftGroup">Create Lift Group</button>
</form>

        <?php
        // Display lift groups
        $liftGroupsQuery = "SELECT * FROM LiftGroup WHERE SportID = '$SportID'";
        $liftGroupsResult = $conn->query($liftGroupsQuery);

        if ($liftGroupsResult->num_rows > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Lift Group ID</th>';
            echo '<th>Person 1</th>';
            echo '<th>Person 2</th>';
            echo '<th>Person 3</th>';
            echo '<th>Person 4</th>';
            echo '<th>Person 5</th>';
            echo '<th>Action</th>';
            echo '</tr>';

            while ($liftGroup = $liftGroupsResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $liftGroup['LiftGroupID'] . '</td>';

                // Retrieve athletes in the lift group
                $liftGroupID = $liftGroup['LiftGroupID'];
                $athletesInGroupQuery = "SELECT CONCAT(FirstName, ' ', LastName) AS FullName FROM Athlete 
                                         WHERE LiftGroupID = '$liftGroupID'";
                $athletesInGroupResult = $conn->query($athletesInGroupQuery);

                $athleteNames = [];
                while ($athlete = $athletesInGroupResult->fetch_assoc()) {
                    $athleteNames[] = $athlete['FullName'];
                }

                // Fill columns with athlete names
                for ($i = 0; $i < 5; $i++) {
                    echo '<td>' . ($i < count($athleteNames) ? $athleteNames[$i] : '') . '</td>';
                }

                // Delete button
                echo '<td><form method="POST" action=""><button type="submit" name="deleteLiftGroup" value="' . $liftGroupID . '">Delete</button></form></td>';

                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "No lift groups found.";
        }
        ?>
    </div>
</body>

</html>

<?php
// Close the connection
$conn->close();
?>
