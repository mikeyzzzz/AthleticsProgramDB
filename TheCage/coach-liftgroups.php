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

// Fetch SportID of the coach
$coachSportQuery = "SELECT SportID FROM Coach WHERE Username = '$username' AND Password = '$password'";
$coachSportResult = $conn->query($coachSportQuery);
$coachSportRow = $coachSportResult->fetch_assoc();
$coachSportID = $coachSportRow['SportID'];

// Fetch athletes with the same SportID as the coach
$athletesQuery = "SELECT AthleteID, FirstName, LastName FROM Athlete WHERE SportID = '$coachSportID'";
$athletesResult = $conn->query($athletesQuery);

// Handle form submission
if (isset($_POST['createGroup'])) {
    // Insert record into LiftGroup table
    $insertGroupQuery = "INSERT INTO LiftGroup (SportID) VALUES ('$coachSportID')";
    $conn->query($insertGroupQuery);
    $liftGroupID = $conn->insert_id; // Get the auto-incremented LiftGroupID

    // Update each athlete in the lift group
    for ($i = 1; $i <= 5; $i++) {
        $athleteID = $_POST["athlete$i"];
        if (!empty($athleteID)) {
            $updateAthleteQuery = "UPDATE Athlete SET LiftGroupID = $liftGroupID WHERE AthleteID = $athleteID";
            $conn->query($updateAthleteQuery);
        }
    }
}

// Handle lift group deletion
if (isset($_POST['deleteGroup'])) {
    $deleteGroupID = $_POST['deleteGroupID'];

    // Update athletes in the lift group to set LiftGroupID to null
    $updateAthleteQuery = "UPDATE Athlete SET LiftGroupID = NULL WHERE LiftGroupID = $deleteGroupID";
    $conn->query($updateAthleteQuery);

    // Delete the lift group
    $deleteGroupQuery = "DELETE FROM LiftGroup WHERE LiftGroupID = $deleteGroupID";
    $conn->query($deleteGroupQuery);
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
            width: 30%;
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
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Center the form section */
            margin-top: 20px;
        }

        .form-section label,
        .form-section select {
            flex: 0 0 48%;
            margin-bottom: 10px;
            text-align: left; /* Align the text to the left */
        }

        .table-section {
            width: 100%;
            margin-top: 20px;
            text-align: center; /* Center the table */
			border: none;
        }

        .table-section table {
            width: 70%; /* Adjust the width as needed */
            border-collapse: collapse;
            margin: auto; /* Center the table */
        }

        .table-section, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        .create-group-btn {
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="coach-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <h1>Lift Groups</h1>

        <!-- Select Athletes Section -->
        <div class="form-section">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <label for="athlete<?php echo $i; ?>">Athlete <?php echo $i; ?>:</label>
                    <select name="athlete<?php echo $i; ?>" required>
                        <option value="" disabled selected>Select Athlete</option>
                        <?php
                        $athletesResult->data_seek(0);
                        while ($athleteRow = $athletesResult->fetch_assoc()):
                            $fullName = $athleteRow['FirstName'] . ' ' . $athleteRow['LastName'];
                        ?>
                            <option value="<?php echo $athleteRow['AthleteID']; ?>"><?php echo $fullName; ?></option>
                        <?php endwhile; ?>
                    </select><br> <!-- Add a line break here -->
                <?php endfor; ?>
                <button class="create-group-btn" type="submit" name="createGroup">Create Lift Group</button>
            </form>
        </div>

        <!-- Lift Groups Table Section -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Lift Group ID</th>
                        <th>Athletes in Group</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $liftGroupsQuery = "SELECT LiftGroupID FROM LiftGroup WHERE SportID = '$coachSportID'";
                    $liftGroupsResult = $conn->query($liftGroupsQuery);

                    while ($liftGroupRow = $liftGroupsResult->fetch_assoc()):
                        $liftGroupID = $liftGroupRow['LiftGroupID'];

                        $athletesInGroupQuery = "SELECT Athlete.AthleteID, Athlete.FirstName, Athlete.LastName 
                                                 FROM Athlete 
                                                 WHERE Athlete.LiftGroupID = $liftGroupID";
                        $athletesInGroupResult = $conn->query($athletesInGroupQuery);
                    ?>
                        <tr>
                            <td><?php echo $liftGroupID; ?></td>
                            <td>
                                <?php while ($athleteInGroupRow = $athletesInGroupResult->fetch_assoc()): ?>
                                    <?php echo $athleteInGroupRow['FirstName'] . ' ' . $athleteInGroupRow['LastName'] . "<br>"; ?>
                                <?php endwhile; ?>
                            </td>
                            <td>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="deleteGroupID" value="<?php echo $liftGroupID; ?>">
                                    <button type="submit" name="deleteGroup">Delete</button>
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