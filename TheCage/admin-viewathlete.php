
<?php

/*
I had a lot of issues and trouble with this page in trying to update athlete information so 
I had to use some code from internet to help solve the issue. It used JavaScript
for some functionality compared to php. 

*/


session_start();
include("db_connection.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: admin-login.php"); // Redirect to the login page if not logged in
    exit();
}

$athleteID = $_GET['id'];

// Fetch athlete's information from the database using the provided ID
$fetchAthleteInfoSql = "SELECT * FROM Athlete WHERE AthleteID = '$athleteID'";
$result = mysqli_query($conn, $fetchAthleteInfoSql);

if (!$result) {
    // Handle the case where there's an issue with the query
    echo "Error: " . mysqli_error($conn);
    exit();
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    // Handle the case where there's no data for the provided AthleteID
    $errorMessage = "Athlete data not found for ID: $athleteID";
} else {
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
}

// Check if the form is submitted for updating the profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch values from the form, including AthleteID
    $athleteID = isset($_POST['athleteID']) ? $_POST['athleteID'] : '';

    // Ensure AthleteID is not empty
    if (empty($athleteID)) {
        echo '<script>alert("AthleteID not provided.");</script>';
        exit();
    }

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
                         WHERE AthleteID = '$athleteID'";
    $updateResult = mysqli_query($conn, $updateProfileSql);

    if ($updateResult) {
        // Profile update successful
        echo '<script>alert("Profile saved!");</script>';
        header("Location: admin-viewathlete.php?id=$athleteID&update=success");
        exit();
    } else {
        // Profile update failed
        echo '<script>alert("Profile update failed.");</script>';
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

        .uneditable-field {
            background-color: #f5f5f5;
            padding: 8px;
            margin-bottom: 10px;
        }

        .editable-section input,
        .editable-section textarea {
            width: 100%;
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
        <a href="admin-dashboard.php" class="back-btn-to-dashboard">Dashboard</a>
        <div class="profile-section">
            <h2>Athlete Information</h2>
            <div class="uneditable-field"><strong>Name:</strong> <?php echo $name; ?></div>
            <div class="uneditable-field"><strong>Phone:</strong> <?php echo $phone; ?></div>
            <div class="uneditable-field"><strong>Email:</strong> <?php echo $email; ?></div>
            <div class="uneditable-field"><strong>Sport:</strong> <?php echo $sportId; ?></div>
            <div class="uneditable-field"><strong>Lift Group ID:</strong> <?php echo $liftGroupId; ?></div>
            <div class="uneditable-field"><strong>Class Year:</strong> <?php echo $classYear; ?></div>
        </div>

        <div class="profile-section editable-section">
            <h2>Edit Profile</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="profileForm">
                <!-- Add a hidden input field for AthleteID -->
                <input type="hidden" id="athleteID" name="athleteID" value="<?php echo $athleteID; ?>">

                <label for="height">Height (x Feet x Inches - Don't use ' or "):</label>
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

                <button class="save-btn" type="button" onclick="saveProfile()">Save</button>
            </form>
        </div>
    </div>

    <script>
        function saveProfile() {
            // Store AthleteID in session storage
            var athleteID = document.getElementById('athleteID').value;
            sessionStorage.setItem('athleteID', athleteID);

            // Submit the form using JavaScript
            document.getElementById("profileForm").submit();
        }
    </script>
</body>
</html>
