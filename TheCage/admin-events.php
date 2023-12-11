<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: admin-login.php"); // Redirect to the login page if not logged in
    exit();
}

// Handle form submission
if (isset($_POST['createEvent'])) {
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];

    // Insert record into Event table using prepared statement
    $insertEventQuery = $conn->prepare("INSERT INTO Event (EventName, Date) VALUES (?, ?)");
    $insertEventQuery->bind_param("ss", $eventName, $eventDate);
    $insertEventQuery->execute();

    // Get the last inserted EventID
    $eventID = $insertEventQuery->insert_id;

    // Close the prepared statement
    $insertEventQuery->close();

    // Insert a leaderboard entry for the new event
    $insertLeaderboardQuery = $conn->prepare("INSERT INTO Leaderboard (EventID) VALUES (?)");
    $insertLeaderboardQuery->bind_param("i", $eventID);
    $insertLeaderboardQuery->execute();

    // Close the prepared statement
    $insertLeaderboardQuery->close();
}

// Handle event deletion
if (isset($_POST['deleteEventID'])) {
    $deleteEventID = $_POST['deleteEventID'];

    // Delete from Event table
    $deleteEventQuery = $conn->prepare("DELETE FROM Event WHERE EventID = ?");
    $deleteEventQuery->bind_param("i", $deleteEventID);
    $deleteEventQuery->execute();

    // Close the prepared statement
    $deleteEventQuery->close();
}

// Fetch events
$eventsQuery = "SELECT * FROM Event";
$eventsResult = $conn->query($eventsQuery);
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
        <h1>Event Management</h1>

        <!-- Create Event Section -->
        <div class="form-section">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="eventName">Event Name:</label>
                <input type="text" name="eventName" required>

                <label for="eventDate">Event Last Date:</label>
                <input type="date" name="eventDate" required>

                <button type="submit" name="createEvent">Create Event</button>
            </form>
        </div>

        <!-- Events Table Section -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Name</th>
                        <th>Last Date</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($eventRow = $eventsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $eventRow['EventID']; ?></td>
                            <td><?php echo $eventRow['EventName']; ?></td>
                            <td><?php echo $eventRow['Date']; ?></td>
                            <td>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="deleteEventID" value="<?php echo $eventRow['EventID']; ?>">
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
