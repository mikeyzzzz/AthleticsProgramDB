<?php
    session_start();
    include("db_connection.php");

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header("Location: admin-login.php"); // Redirect to the login page if not logged in
        exit();
    }

    // Access session variables
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    // Check if delete button is clicked
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

    // Retrieve all athletes
    $allAthletesQuery = "SELECT * FROM Athlete";
    $allAthletesResult = $conn->query($allAthletesQuery);

    if ($allAthletesResult->num_rows > 0) {
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

        .profile-link {
            text-decoration: underline;
            color: blue;
            cursor: pointer;
        }

        .delete-btn {
            background-color: #ff3333;
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
        <a href="admin-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>All Athletes</h1>

        <?php
            // Display the table header
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

            // Display all athletes
            while ($row = $allAthletesResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['AthleteID'] . '</td>';
                echo '<td><a class="profile-link" href="admin-viewathlete.php?id=' . $row['AthleteID'] . '">' . $row['FirstName'] . ' ' . $row['LastName'] . '</a></td>';
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
            echo "No athletes found.";
        }
        ?>

    </div>
</body>

</html>

<?php
    // Close the connection
    $conn->close();
?>
