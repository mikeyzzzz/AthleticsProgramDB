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

    // Fetch athletes for the selected sport
    $athletesQuery = "SELECT * FROM Athlete WHERE SportID = '$selectedSportID'";
    $athletesResult = $conn->query($athletesQuery);
}

// Handle athlete deletion
if (isset($_POST['deleteAthleteID'])) {
    $athleteIDToDelete = $_POST['deleteAthleteID'];

    // Delete the athlete from the database
    $deleteAthleteQuery = "DELETE FROM Athlete WHERE AthleteID = '$athleteIDToDelete'";
    $deleteAthleteResult = $conn->query($deleteAthleteQuery);

    if ($deleteAthleteResult) {
        echo '<script>alert("Athlete deleted successfully.");</script>';
    } else {
        echo '<script>alert("Failed to delete athlete.");</script>';
    }
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
            width: 100%;
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
        <h1>Athletes By Team</h1>

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

        <!-- Athlete Table -->
        <?php
        if (isset($athletesResult) && $athletesResult->num_rows > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Athlete ID</th>';
            echo '<th>Name</th>';
            echo '<th>Class Year</th>';
            echo '<th>Sport ID</th>';
            echo '<th>Email</th>';
            echo '<th>Phone Number</th>';
            echo '<th>Delete</th>';
            echo '</tr>';

            while ($row = $athletesResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['AthleteID'] . '</td>';
                echo '<td><a class="profile-link" href="#">' . $row['FirstName'] . ' ' . $row['LastName'] . '</a></td>';
                echo '<td>' . $row['ClassYear'] . '</td>';
                echo '<td>' . $row['SportID'] . '</td>';
                echo '<td>' . $row['Email'] . '</td>';
                echo '<td>' . $row['PhoneNumber'] . '</td>';
                echo '<td>
                        <form method="post">
                            <input type="hidden" name="deleteAthleteID" value="' . $row['AthleteID'] . '">
                            <button class="delete-btn" type="submit" onclick="return confirm(\'Are you sure you want to delete this athlete?\')">Delete</button>
                        </form>
                      </td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "Please select a sport.";
        }
        ?>
    </div>
</body>

</html>

<?php
// Close the connection
$conn->close();
?>
