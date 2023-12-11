<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: admin-login.php"); // Redirect to the login page if not logged in
    exit();
}

// Retrieve all sports
$sportsQuery = "SELECT DISTINCT SportID FROM Athlete";
$sportsResult = $conn->query($sportsQuery);

if ($sportsResult->num_rows > 0) {
    $sports = [];
    while ($row = $sportsResult->fetch_assoc()) {
        $sports[] = $row['SportID'];
    }
}

// Handle sport selection
if (isset($_POST['selectedSport'])) {
    $selectedSportID = $_POST['selectedSport'];

    // Fetch lift groups for the selected sport
    $liftGroupsQuery = "SELECT * FROM LiftGroup WHERE SportID = '$selectedSportID'";
    $liftGroupsResult = $conn->query($liftGroupsQuery);
}

// Handle lift group deletion
if (isset($_POST['deleteGroupID'])) {
    $deleteGroupID = $_POST['deleteGroupID'];

    // Delete the lift group and update athletes to set LiftGroupID to null
    $updateAthleteQuery = "UPDATE Athlete SET LiftGroupID = NULL WHERE LiftGroupID = $deleteGroupID";
    $conn->query($updateAthleteQuery);

    $deleteGroupQuery = "DELETE FROM LiftGroup WHERE LiftGroupID = $deleteGroupID";
    $conn->query($deleteGroupQuery);

    echo '<script>alert("Lift group deleted successfully.");</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            width: 80%;
            margin: auto;
            text-align: center;
            border: 2px solid black;
            padding: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .back-btn-to-dashboard {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #4caf50;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

       table {
    width: 80%; /* Adjust the width as needed */
    margin: auto; /* Center the table horizontally */
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid black;
    padding: 8px;
}

        h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        .sport-buttons {
            margin-top: 10px;
        }

        .sport-btn {
            padding: 5px 10px;
            margin-right: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="admin-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>Lift Groups By Team</h1>

        <!-- Sport Buttons -->
        <div class="sport-buttons">
            <?php
            foreach ($sports as $sport) {
                echo '<form method="post" style="display: inline-block;">';
                echo '<input type="hidden" name="selectedSport" value="' . $sport . '">';
                echo '<button class="sport-btn" type="submit">' . $sport . '</button>';
                echo '</form>';
            }
            ?>
        </div>

        <!-- Lift Group Table -->
        <?php
        if (isset($liftGroupsResult) && $liftGroupsResult->num_rows > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Lift Group ID</th>';
            echo '<th>Athletes</th>';
            echo '<th>Delete</th>';
            echo '</tr>';

            while ($row = $liftGroupsResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['LiftGroupID'] . '</td>';
                
                // Fetch and display athletes in the lift group
                $athletesQuery = "SELECT * FROM Athlete WHERE LiftGroupID = " . $row['LiftGroupID'];
                $athletesResult = $conn->query($athletesQuery);
                echo '<td>';
                while ($athlete = $athletesResult->fetch_assoc()) {
                    // Concatenate FirstName and LastName
                    echo $athlete['FirstName'] . ' ' . $athlete['LastName'] . '<br>';
                }
                echo '</td>';
                
                echo '<td>
                        <form method="post">
                            <input type="hidden" name="deleteGroupID" value="' . $row['LiftGroupID'] . '">
                            <button class="delete-btn" type="submit" onclick="return confirm(\'Are you sure you want to delete this lift group?\')">Delete</button>
                        </form>
                      </td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "No lift groups found for the selected sport.";
        }
        ?>
    </div>
</body>

</html>

<?php
// Close the connection
$conn->close();
?>