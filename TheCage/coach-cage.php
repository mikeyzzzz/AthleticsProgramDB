<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: coach-login.php"); // Redirect to the login page if not logged in
    exit();
}

// Fetch athlete ID based on the current session username
$username = $_SESSION['username'];
$getCoachIDQuery = "SELECT CoachID FROM Coach WHERE Username = '$username'";
$result = $conn->query($getCoachIDQuery);

if ($result->num_rows > 0) {
    $coachRow = $result->fetch_assoc();
    $coachID = $coachRow['CoachID'];
} else {
    // Handle the case where the athlete ID is not found
    // You might want to redirect to a login page or display an error message
    header("Location: coach-login.php");
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
            width: 60%;
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
            text-align: center; /* Center the form section */
        }

        .form-section label,
        .form-section input,
        .form-section textarea,
        .form-section select {
            display: block;
            margin: auto;
            margin-bottom: 10px;
            width: 30%;
            box-sizing: border-box;
        }

        .form-section textarea {
            height: 80px;
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
            width: 80%;
            margin: auto;
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
            padding: 10px;
            text-align: left;
        }

        .add-attempt-form {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="athlete-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
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
        <table>
            <thead>
                <tr>
                    <th>Attempt ID</th>
                    <th>Athlete Name</th>
                    <th>Sport</th>
                    <th>Record Input</th>
                    <th>Verified</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $leaderboardResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['AttemptID']; ?></td>
                        <td><?php echo $row['AthleteName']; ?></td>
                        <td><?php echo $row['SportID']; ?></td>
                        <td><?php echo $row['RecordInput']; ?></td>
                        <td><?php echo ($row['Verified'] ? 'Yes' : 'No'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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
