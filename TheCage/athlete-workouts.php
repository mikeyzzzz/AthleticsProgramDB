<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['username'])) {
    header("Location: athlete-login.php"); // Redirect to the login page if not logged in
    exit();
}

// Fetch athlete ID based on the current session username
$username = $_SESSION['username'];
$getAthleteIDQuery = "SELECT AthleteID FROM Athlete WHERE Username = '$username'";
$result = $conn->query($getAthleteIDQuery);

if ($result->num_rows > 0) {
    $athleteRow = $result->fetch_assoc();
    $athleteID = $athleteRow['AthleteID'];
} else {
    // Handle the case where the athlete ID is not found
    // You might want to redirect to a login page or display an error message
    header("Location: athlete-login.php");
    exit();
}

// Handle form submission for completing a workout session
if (isset($_POST['completeSession'])) {
    $workoutID = $_POST['workoutID'];
    
    // Fetch workout exercises based on the selected workout
    $workoutExerciseQuery = "SELECT * FROM WorkoutExercise WHERE WorkoutID = '$workoutID'";
    $workoutExerciseResult = $conn->query($workoutExerciseQuery);
	
	$completion = $_POST['completion'];
    $earlyClass = $_POST['earlyClass'];
    $soreness = $_POST['soreness'];
    $difficulty = $_POST['difficulty'];
    $sessionNotes = $_POST['sessionNotes'];

    // Insert workout session data into the database
    $insertSessionQuery = "INSERT INTO WorkoutSession (AthleteID, WorkoutID, Completion, EarlyClass, Soreness, Difficulty, SessionNotes)
                           VALUES ('$athleteID', '$workoutID', '$completion', '$earlyClass', '$soreness', '$difficulty', '$sessionNotes')";
    $conn->query($insertSessionQuery);

    }


// Fetch available workouts for the athlete's sport
$sportIDQuery = "SELECT SportID FROM Athlete WHERE AthleteID = '$athleteID'";
$sportIDResult = $conn->query($sportIDQuery);
$sportIDRow = $sportIDResult->fetch_assoc();
$sportID = $sportIDRow['SportID'];

$workoutsQuery = "SELECT * FROM Workout WHERE SportID = '$sportID'";
$workoutsResult = $conn->query($workoutsQuery);
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

        .delete-btn {
            background-color: #f44336;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
 
</head>

<body>
    <div class="container">
        <a href="athlete-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>Workout Session</h1>

        <!-- Select Workout Section -->
        <div class="form-section">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="workoutID">Select Workout:</label>
                <select name="workoutID" required>
                    <?php while ($workoutRow = $workoutsResult->fetch_assoc()): ?>
                        <option value="<?php echo $workoutRow['WorkoutID']; ?>"><?php echo $workoutRow['Name']; ?></option>
                    <?php endwhile; ?>
                </select>

                <!-- New Fields for WorkoutSession -->
                <label for="completion">Completion:</label>
                <select name="completion" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>

                <label for="earlyClass">Early Class:</label>
                <select name="earlyClass" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>

                <label for="soreness">Soreness (1-10):</label>
                <input type="number" name="soreness" min="1" max="10" required>

                <label for="difficulty">Difficulty (1-10):</label>
                <input type="number" name="difficulty" min="1" max="10" required>

                <label for="sessionNotes">Session Notes:</label>
                <textarea name="sessionNotes"></textarea>

                <button type="submit" name="completeSession">Complete Session</button>
            </form>
        </div>

        <!-- Workout Session Table Section -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Session ID</th>
                        <th>Workout ID</th>
                        <th>Completion</th>
                        <th>Early Class</th>
                        <th>Soreness</th>
                        <th>Difficulty</th>
                        <th>Session Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch and display workout session data here -->
                    <?php
                    $sessionQuery = "SELECT * FROM WorkoutSession WHERE AthleteID = '$athleteID'";
                    $sessionResult = $conn->query($sessionQuery);
                    while ($sessionRow = $sessionResult->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $sessionRow['SessionID']; ?></td>
                            <td><?php echo $sessionRow['WorkoutID']; ?></td>
                            <td><?php echo $sessionRow['Completion']; ?></td>
                            <td><?php echo $sessionRow['EarlyClass']; ?></td>
                            <td><?php echo $sessionRow['Soreness']; ?></td>
                            <td><?php echo $sessionRow['Difficulty']; ?></td>
                            <td><?php echo $sessionRow['SessionNotes']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
// Close the connection
$conn->close();
?>
