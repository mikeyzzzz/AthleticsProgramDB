<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: admin-login.php"); // Redirect to the login page if not logged in
    exit();
}

// Fetch events
$eventsQuery = "SELECT * FROM Event";
$eventsResult = $conn->query($eventsQuery);

// Handle form submission for selecting event and displaying leaderboard attempts in table
if (isset($_POST['selectEvent'])) {
    $selectedEventID = $_POST['eventID'];

    $selectAttemptsQuery = "
        SELECT Attempt.AttemptID, Athlete.AthleteID, CONCAT(Athlete.FirstName, ' ', Athlete.LastName) AS AthleteName, Sport.SportID, Attempt.RecordInput, Attempt.Verified
        FROM Attempt
        INNER JOIN Athlete ON Attempt.AthleteID = Athlete.AthleteID
        INNER JOIN Sport ON Athlete.SportID = Sport.SportID
        WHERE Attempt.EventID = '$selectedEventID'";

    $leaderboardResult = $conn->query($selectAttemptsQuery);
}

// Handle form submission for updating the "Verified" status
if (isset($_POST['updateVerification'])) {
    $attemptIDToUpdate = $_POST['attemptID'];
    $newVerificationStatus = isset($_POST['verificationCheckbox']) ? 1 : 0;

    $updateVerificationQuery = "UPDATE Attempt SET Verified = $newVerificationStatus WHERE AttemptID = $attemptIDToUpdate";

    if ($conn->query($updateVerificationQuery) === TRUE) {
        echo "Verification status updated successfully";
    } else {
        echo "Error updating verification status: " . $conn->error;
    }
}

// Handle form submission for deleting an attempt
if (isset($_POST['deleteAttempt'])) {
    $attemptIDToDelete = $_POST['attemptID'];

    $deleteAttemptQuery = "DELETE FROM Attempt WHERE AttemptID = $attemptIDToDelete";

    if ($conn->query($deleteAttemptQuery) === TRUE) {
        echo "Attempt deleted successfully";
    } else {
        echo "Error deleting attempt: " . $conn->error;
    }
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
            width: 80%;
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

        .form-section {
            margin-top: 20px;
            text-align: center;
        }

        .form-section label,
        .form-section select {
            display: inline-block;
            margin-bottom: 10px;
            width: 30%;
            box-sizing: border-box;
            text-align: left;
        }

        .form-section select {
            margin-left: 5px;
        }

        .form-section button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .table-section table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table-section,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-btn,
        .update-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .update-btn {
            background-color: #008CBA;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="admin-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>Cage Event Leaderboards</h1>

        <!-- Select Event Section -->
        <div class="form-section">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="eventID">Select Event:</label>
                <select name="eventID" required>
                    <?php while ($eventRow = $eventsResult->fetch_assoc()): ?>
                        <option value="<?php echo $eventRow['EventID']; ?>"><?php echo $eventRow['EventName']; ?></option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" name="selectEvent">Select Event</button>
            </form>
        </div>

        <!-- Leaderboard Table Section -->
        <div class="table-section">
            <?php if (isset($leaderboardResult) && $leaderboardResult->num_rows > 0): ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <table>
                        <thead>
                            <tr>
                                <th>Attempt ID</th>
                                <th>Athlete Name</th>
                                <th>Sport</th>
                                <th>Record Input</th>
                                <th>Verified</th>
                                <th>Action</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $leaderboardResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['AttemptID']; ?></td>
                                    <td><?php echo $row['AthleteName']; ?></td>
                                    <td><?php echo $row['SportID']; ?></td>
                                    <td><?php echo $row['RecordInput']; ?></td>
                                    <td>
                                        <input type="checkbox" name="verificationCheckbox"
                                            <?php echo ($row['Verified'] ? 'checked' : ''); ?>>
                                    </td>
                                    <td>
                                        <button type="submit" name="updateVerification" class="update-btn">Update</button>
                                        <input type="hidden" name="attemptID" value="<?php echo $row['AttemptID']; ?>">
                                    </td>
                                    <td>
                                        <button type="submit" name="deleteAttempt" class="delete-btn">Delete</button>
                                        <input type="hidden" name="attemptID" value="<?php echo $row['AttemptID']; ?>">
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </form>
            <?php else: ?>
                <p>No attempts found</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>

<?php
// Close the connection
$conn->close();
?>
