<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: admin-login.php"); // Redirect to the login page if not logged in
    exit();
}

// Handle form submission
if (isset($_POST['createWorkout'])) {
    $sportID = $_POST['sportID']; // Use the selected sportID
    $name = $_POST['workoutName'];
    $numberOfWeeks = $_POST['numberOfWeeks'];

    // Insert record into Workout table
    $insertWorkoutQuery = "INSERT INTO Workout (SportID, Name, NumberOfWeeks) 
                           VALUES ('$sportID', '$name', '$numberOfWeeks')";
    $conn->query($insertWorkoutQuery);

    $workoutID = $conn->insert_id; // Get the auto-incremented WorkoutID

    // Insert selected exercises into WorkoutExercise table
    if (isset($_POST['selectedExercises'])) {
        foreach ($_POST['selectedExercises'] as $exerciseID) {
            $insertWorkoutExerciseQuery = "INSERT INTO WorkoutExercise (WorkoutID, ExerciseID) 
                                           VALUES ('$workoutID', '$exerciseID')";
            $conn->query($insertWorkoutExerciseQuery);
        }
    }
}

// Handle workout deletion
if (isset($_POST['deleteWorkoutID'])) {
    $deleteWorkoutID = $_POST['deleteWorkoutID'];

    // Delete from WorkoutExercise table
    $deleteWorkoutExerciseQuery = "DELETE FROM WorkoutExercise WHERE WorkoutID = '$deleteWorkoutID'";
    $conn->query($deleteWorkoutExerciseQuery);

    // Delete from Workout table
    $deleteWorkoutQuery = "DELETE FROM Workout WHERE WorkoutID = '$deleteWorkoutID'";
    $conn->query($deleteWorkoutQuery);
}

// Fetch workouts
$workoutsQuery = "SELECT * FROM Workout";
$workoutsResult = $conn->query($workoutsQuery);

// Fetch exercises
$exercisesQuery = "SELECT * FROM Exercise";
$exercisesResult = $conn->query($exercisesQuery);

// Fetch sports
$sportsQuery = "SELECT * FROM Sport";
$sportsResult = $conn->query($sportsQuery);
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
        <a href="admin-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>Workout Management</h1>

        <!-- Create Workout Section -->
        <div class="form-section">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="sportID">Select Sport:</label>
        <select name="sportID" required>
            <?php while ($sportRow = $sportsResult->fetch_assoc()): ?>
                <option value="<?php echo $sportRow['SportID']; ?>"><?php echo $sportRow['SportID']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="workoutName">Workout Name:</label>
        <input type="text" name="workoutName" required>

        <label for="numberOfWeeks">Number of Weeks:</label>
        <input type="number" name="numberOfWeeks" required>

        <label>Select Exercises:</label>
        <div class="exercise-checkboxes">
            <?php while ($exerciseRow = $exercisesResult->fetch_assoc()): ?>
                <label>
                    <input type="checkbox" name="selectedExercises[]" value="<?php echo $exerciseRow['ExerciseID']; ?>">
                    <span>
                        <?php echo $exerciseRow['Name']; ?> -
                        <?php echo $exerciseRow['NumberSets']; ?> X <?php echo $exerciseRow['NumberReps']; ?> -
                        <?php echo $exerciseRow['NotesTempoPercentage']; ?>
                    </span>
                </label><br>
            <?php endwhile; ?>
        </div>

        <button type="submit" name="createWorkout">Create Workout</button>
    </form>
</div>

        <!-- Workouts Table Section -->
        <div class="table-section">
            <!-- Workouts Table Section -->
<div class="table-section">
    <table>
        <thead>
            <tr>
                <th>Workout ID</th>
                <th>Name</th>
                <th>Sport ID</th>
                <th>Number of Weeks</th>
                <th>Exercises</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($workoutRow = $workoutsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $workoutRow['WorkoutID']; ?></td>
                    <td><?php echo $workoutRow['Name']; ?></td>
                    <td><?php echo $workoutRow['SportID']; ?></td>
                    <td><?php echo $workoutRow['NumberOfWeeks']; ?></td>
                    <td>
                        <?php
                        $workoutID = $workoutRow['WorkoutID'];
                        $exercisesInWorkoutQuery = "SELECT Exercise.Name
                                                    FROM Exercise
                                                    INNER JOIN WorkoutExercise ON Exercise.ExerciseID = WorkoutExercise.ExerciseID
                                                    WHERE WorkoutExercise.WorkoutID = '$workoutID'";
                        $exercisesInWorkoutResult = $conn->query($exercisesInWorkoutQuery);
                        while ($exerciseInWorkoutRow = $exercisesInWorkoutResult->fetch_assoc()):
                        ?>
                            <?php echo $exerciseInWorkoutRow['Name'] . "<br>"; ?>
                        <?php endwhile; ?>
                    </td>
                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="deleteWorkoutID" value="<?php echo $workoutRow['WorkoutID']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
        </div>
    </div>
</body>

</html>

<?php
// Close the connection
$conn->close();
?>