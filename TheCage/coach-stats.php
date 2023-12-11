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

    // Assuming SportID is associated with the coach in the Coach table
    $coachSportIDQuery = "SELECT SportID FROM Coach WHERE Username = '$username'";
    $coachSportIDResult = $conn->query($coachSportIDQuery);

    if ($coachSportIDResult->num_rows > 0) {
        $coachSportIDRow = $coachSportIDResult->fetch_assoc();
        $coachSportID = $coachSportIDRow['SportID'];

        // Retrieve athletes for the coach's team
        $coachTeamQuery = "SELECT * FROM Athlete WHERE SportID = '$coachSportID'";
        $coachTeamResult = $conn->query($coachTeamQuery);
    } else {
        echo "Coach not found.";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style>
        .container {
            width: 80%; /* Adjust the width as needed */
            margin: auto;
            text-align: center;
            border: 2px solid black;
            padding: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .back-btn-to-dashboard {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 80%; /* Adjust the width as needed */
            border-collapse: collapse;
            margin: 20px auto; /* Add margin for centering the table */
        }

        th, td {
            border: 1px solid black;
            padding: 8px; /* Adjust the padding as needed */
        }

        h1 {
            text-align: center;
        }

        .view-sessions-btn {
            background-color: #008CBA;
            color: white;
            padding: 5px 10px; /* Adjust the padding to make the button smaller */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none; /* Remove underline from the link */
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="coach-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>My Team</h1>

        <?php
        if ($coachTeamResult->num_rows > 0) {
            // Display the table header
            echo '<table>';
            echo '<tr>';
            echo '<th>Athlete ID</th>';
            echo '<th>Name</th>';
            echo '<th>Class Year</th>';
            echo '<th>Main Events</th>';
            echo '<th>Email</th>';
            echo '<th>Phone Number</th>';
            echo '<th>View Sessions</th>'; // New column
            echo '</tr>';

            // Display the roster
            while ($row = $coachTeamResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['AthleteID'] . '</td>';
                echo '<td>' . $row['FirstName'] . ' ' . $row['LastName'] . '</td>';
                echo '<td>' . $row['ClassYear'] . '</td>';
                echo '<td>' . $row['EventsOrPosition'] . '</td>';
                echo '<td>' . $row['Email'] . '</td>';
                echo '<td>' . $row['PhoneNumber'] . '</td>';
                echo '<td><a href="coach-viewathletesessions.php?athleteID=' . $row['AthleteID'] . '" class="view-sessions-btn">Sessions</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "No athletes found for this coach.";
        }
        ?>

    </div>
</body>

</html>

<?php
    // Close the connection
    $conn->close();
?>
