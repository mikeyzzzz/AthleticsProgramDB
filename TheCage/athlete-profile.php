<?php
    session_start();
    include("db_connection.php");

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header("Location: login.php"); // Redirect to the login page if not logged in
        exit();
    }

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    // Fetch athlete's information from the database (to display updated information)
    $fetchAthleteInfoSql = "SELECT * FROM Athlete WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($conn, $fetchAthleteInfoSql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Fetched data (same as before)
        $name = $row['FirstName'] . ' ' . $row['LastName'];
        $phone = $row['PhoneNumber'];
        $email = $row['Email'];
        $sportId = isset($row['SportID']) ? $row['SportID'] : '';
        $liftGroupId = isset($row['LiftGroupID']) ? $row['LiftGroupID'] : '';
        $classYear = $row['ClassYear'];
        $height = isset($row['Height']) ? $row['Height'] : '';
        $weight = isset($row['Weight']) ? $row['Weight'] : '';
        $major = isset($row['Major']) ? $row['Major'] : '';
        $eventsOrPosition = isset($row['EventsOrPosition']) ? $row['EventsOrPosition'] : '';
        $favoriteFood = isset($row['FavoriteFood']) ? $row['FavoriteFood'] : '';
        $favoriteMusicArtist = isset($row['FavoriteMusicArtist']) ? $row['FavoriteMusicArtist'] : '';
        $hobbies = isset($row['Hobbies']) ? $row['Hobbies'] : '';
    } else {
        // Handle the case where the athlete's data couldn't be retrieved
        header("Location: error.php");
        exit();
    }

    // Check if the form is submitted for updating the profile
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Fetch values from the form
        $height = $_POST['height'];
        $weight = $_POST['weight'];
        $major = $_POST['major'];
        $eventsOrPosition = $_POST['eventsOrPosition'];
        $favoriteFood = $_POST['favoriteFood'];
        $favoriteMusicArtist = $_POST['favoriteMusicArtist'];
        $hobbies = $_POST['hobbies'];

        // Update the athlete's profile in the database
        $updateProfileSql = "UPDATE Athlete SET Height = '$height', Weight = '$weight', Major = '$major', 
                             EventsOrPosition = '$eventsOrPosition', FavoriteFood = '$favoriteFood', 
                             FavoriteMusicArtist = '$favoriteMusicArtist', Hobbies = '$hobbies'
                             WHERE Username = '$username' AND Password = '$password'";
        $updateResult = mysqli_query($conn, $updateProfileSql);

        if ($updateResult) {
            // Profile update successful
            header("Location: athlete-profile.php?update=success");
            exit();
        } else {
            // Profile update failed
            header("Location: athlete-profile.php?update=failed");
            exit();
        }
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
	<a href="athlete-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <div class="profile-section">
            <h2>Athlete Information</h2>
            <div class="uneditable-field"><strong>Name:</strong> <?php echo $name; ?></div>
            <div class="uneditable-field"><strong>Phone:</strong> <?php echo $phone; ?></div>
            <div class="uneditable-field"><strong>Email:</strong> <?php echo $email; ?></div>
            <div class="uneditable-field"><strong>Sport:</strong> <?php echo $sportId; ?></div>
            <div class="uneditable-field"><strong>Lift Group ID:</strong> <?php echo $liftGroupId; ?></div>
            <div class="uneditable-field"><strong>Class Year:</strong> <?php echo $classYear; ?></div>
            <!-- Add other non-editable fields here -->
        </div>

        <div class="profile-section editable-section">
            <h2>Edit Profile</h2>
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<label for="height">Height (Feet'Inches''):</label>
				<input type="text" id="height" name="height" value="<?php echo $height; ?>">

				<label for="weight">Weight (lbs):</label>
				<input type="text" id="weight" name="weight" value="<?php echo $weight; ?>">

				<label for="major">Major:</label>
				<input type="text" id="major" name="major" value="<?php echo $major; ?>">

				<label for="eventsOrPosition">Events/Position:</label>
				<input type="text" id="eventsOrPosition" name="eventsOrPosition" value="<?php echo $eventsOrPosition; ?>">

				<label for="favoriteFood">Favorite Food:</label>
				<input type="text" id="favoriteFood" name="favoriteFood" value="<?php echo $favoriteFood; ?>">

				<label for="favoriteMusicArtist">Favorite Music Artist:</label>
				<input type="text" id="favoriteMusicArtist" name="favoriteMusicArtist" value="<?php echo $favoriteMusicArtist; ?>">

				<label for="hobbies">Hobbies:</label>
				<textarea id="hobbies" name="hobbies"><?php echo $hobbies; ?></textarea>

				<button class="save-btn" onclick="saveProfile()">Save</button>
			</form>
        </div>
    </div>

    <script>
        function saveProfile() {
            // Add JavaScript code to handle saving the profile data to the database
            alert("Profile saved!");
        }
    </script>
</body>
</html>
