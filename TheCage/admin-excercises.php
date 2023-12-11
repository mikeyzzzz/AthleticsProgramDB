<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: admin-login.php"); // Redirect to the login page if not logged in
    exit();
}

// Handle form submission
if (isset($_POST['createExercise'])) {
    $workoutID = 1; // Change this value based on your requirements
    $name = $_POST['exerciseName'];
    $numberSets = $_POST['numberSets'];
    $numberReps = $_POST['numberReps'];
    $notesTempoPercentage = $_POST['notesTempoPercentage'];

    // Insert record into Exercise table
    $insertExerciseQuery = "INSERT INTO Exercise (WorkoutID, Name, NumberSets, NumberReps, NotesTempoPercentage) 
                            VALUES ('$workoutID', '$name', '$numberSets', '$numberReps', '$notesTempoPercentage')";
    $conn->query($insertExerciseQuery);
}

// Handle exercise deletion
if (isset($_POST['deleteExerciseID'])) {
    $deleteExerciseID = $_POST['deleteExerciseID'];

    // Delete the exercise
    $deleteExerciseQuery = "DELETE FROM Exercise WHERE ExerciseID = $deleteExerciseID";
    $conn->query($deleteExerciseQuery);
}

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
        }

        .form-section label,
        .form-section input,
        .form-section textarea {
            display: block;
            margin-bottom: 10px;
            width: 100%;
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
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table-section, th, td {
            border: 1px solid black;
        }

        th, td {
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
        <a href="admin-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>Exercise Management</h1>

        <!-- Create Exercise Section -->
        <div class="form-section">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="exerciseName">Exercise Name:</label>
                <input type="text" name="exerciseName" required>

                <label for="numberSets">Number of Sets:</label>
                <input type="number" name="numberSets" required>

                <label for="numberReps">Number of Reps:</label>
                <input type="number" name="numberReps" required>

                <label for="notesTempoPercentage">Notes/Tempo/Percentage:</label>
                <textarea name="notesTempoPercentage" rows="3"></textarea>

                <button type="submit" name="createExercise">Create Exercise</button>
            </form>
        </div>

        <!-- Exercises Table Section -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Exercise ID</th>
                        <th>Name</th>
                        <th>Number of Sets</th>
                        <th>Number of Reps</th>
                        <th>Notes/Tempo/Percentage</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($exerciseRow = $exercisesResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $exerciseRow['ExerciseID']; ?></td>
                            <td><?php echo $exerciseRow['Name']; ?></td>
                            <td><?php echo $exerciseRow['NumberSets']; ?></td>
                            <td><?php echo $exerciseRow['NumberReps']; ?></td>
                            <td><?php echo $exerciseRow['NotesTempoPercentage']; ?></td>
                            <td>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="deleteExerciseID" value="<?php echo $exerciseRow['ExerciseID']; ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
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
