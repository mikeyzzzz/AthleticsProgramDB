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

// Handle form submission for creating a new goal
if (isset($_POST['createGoal'])) {
    $exerciseID = isset($_POST['exerciseID']) ? $_POST['exerciseID'] : null;
    $goalNotes = $_POST['goalNotes'];

    // Insert record into Goal table
    $insertGoalQuery = "INSERT INTO Goal (AthleteID, ExerciseID, GoalNotes) 
                        VALUES ('$athleteID', '$exerciseID', '$goalNotes')";
    $conn->query($insertGoalQuery);
}

// Handle goal deletion
if (isset($_POST['deleteGoalID'])) {
    $deleteGoalID = $_POST['deleteGoalID'];

    // Delete from Goal table
    $deleteGoalQuery = "DELETE FROM Goal WHERE GoalID = '$deleteGoalID'";
    $conn->query($deleteGoalQuery);
}

// Handle updating goal reached status
if (isset($_POST['updateGoalReached'])) {
    $goalID = $_POST['goalID'];
    $goalReached = isset($_POST['goalReached']) ? 1 : 0;

    // Update Goal table
    $updateGoalQuery = "UPDATE Goal SET GoalReached = '$goalReached' WHERE GoalID = '$goalID'";
    $conn->query($updateGoalQuery);
}

// Fetch athlete's goals
$goalsQuery = "SELECT * FROM Goal WHERE AthleteID = '$athleteID'";
$goalsResult = $conn->query($goalsQuery);

// Fetch exercises
$exercisesQuery = "SELECT * FROM Exercise";
$exercisesResult = $conn->query($exercisesQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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
    </style>
</head>

<body>
    <div class="container">
	<a href="athlete-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>Goal Management</h1>

        <!-- Create Goal Section -->
        <div class="form-section">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="exerciseID">Select Exercise:</label>
                <select name="exerciseID">
                    <option value="">-- Select an Exercise --</option>
                    <?php while ($exerciseRow = $exercisesResult->fetch_assoc()): ?>
                        <option value="<?php echo $exerciseRow['ExerciseID']; ?>"><?php echo $exerciseRow['Name']; ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="goalNotes">Goal Notes:</label>
                <input type="text" name="goalNotes" required>

                <button type="submit" name="createGoal">Create Goal</button>
            </form>
        </div>

        <!-- Goals Table Section -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Goal ID</th>
                        <th>Exercise ID</th>
                        <th>Goal Reached</th>
                        <th>Goal Notes</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($goalRow = $goalsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $goalRow['GoalID']; ?></td>
                            <td><?php echo $goalRow['ExerciseID']; ?></td>
                            <td>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="goalID" value="<?php echo $goalRow['GoalID']; ?>">
                                    <input type="checkbox" name="goalReached" <?php echo ($goalRow['GoalReached'] ? 'checked' : ''); ?>>
                                    <button type="submit" name="updateGoalReached">Update</button>
                                </form>
                            </td>
                            <td><?php echo $goalRow['GoalNotes']; ?></td>
                            <td>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="deleteGoalID" value="<?php echo $goalRow['GoalID']; ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
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
