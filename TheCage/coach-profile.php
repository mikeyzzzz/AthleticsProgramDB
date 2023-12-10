<?php
    session_start();
    include("db_connection.php");

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header("Location: coach-login.php"); // Redirect to the login page if not logged in
        exit();
    }

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    // Fetch athlete's information from the database (to display updated information)
    $fetchCoachInfoSql = "SELECT * FROM Coach WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($conn, $fetchCoachInfoSql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Fetched data (same as before)
        $name = $row['FirstName'] . ' ' . $row['LastName'];
        $phone = $row['PhoneNumber'];
        $email = $row['Email'];
        $sportId = isset($row['SportID']) ? $row['SportID'] : '';
 
    } else {
        // Handle the case where the athlete's data couldn't be retrieved
        header("Location: error.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
        .container {
			max-width: 800px;
			margin: 20px auto;  /* Adjust the right margin here */
			padding: 20px;
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			text-align: center;
			border: 3px solid black; /* Thicker border for better visibility */
		}

        .profile-section {
            margin-bottom: 20px;
        }
        .editable-section input,
        .editable-section textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        .uneditable-field {
            background-color: #f5f5f5;
            padding: 8px;
            margin-bottom: 10px;
        }
        .save-btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
		
		.height-inputs {
        display: flex;
        justify-content: space-between;
        width: 100%;
		}

    .height-inputs input {
        width: 48%; /* Adjust as needed */
    }
    </style>
</head>
<body>
    <div class="container">
	<a href="coach-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <div class="profile-section">
            <h2>Coach Information</h2>
            <div class="uneditable-field"><strong>Name:</strong> <?php echo $name; ?></div>
            <div class="uneditable-field"><strong>Phone:</strong> <?php echo $phone; ?></div>
            <div class="uneditable-field"><strong>Email:</strong> <?php echo $email; ?></div>
            <div class="uneditable-field"><strong>Sport:</strong> <?php echo $sportId; ?></div>
            <!-- Add other non-editable fields here -->
        </div>

       
    </div>

</body>
</html>
