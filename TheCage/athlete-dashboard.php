<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header("Location: login.php"); // Redirect to the login page if not logged in
        exit();
    }

    // Access session variables
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        .container {
            width: 300px;
            margin: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            border: 2px solid black;
            padding: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 75px;
            height: 50px;
            border: 2px solid black;
            margin: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .box:hover {
            background-color: #e0e0e0; /* Change the background color on hover */
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>TheCage Dashboard </h1>
		<h4> <?php echo $username ?> </h4>

        <div class="box" onclick="selectBox('profile')">Profile</div>
        <div class="box" onclick="selectBox('goals')">Goals</div>
        <div class="box" onclick="selectBox('workout')">Workout</div>
        <div class="box" onclick="selectBox('cage')">Cage</div>
        <div class="box" onclick="selectBox('logout')">Logout</div>
        

        <script>
            function selectBox(box) 
			{
				if (box === "profile")
				{
					window.location.href = 'athlete-profile.php';
				}
				if (box === "goals")
				{
					window.location.href = 'athlete-goals.php';
				}
				if (box === "workout")
				{
					window.location.href = 'athlete-workouts.php';
				}
				if (box === "cage")
				{
					window.location.href = 'athlete-cage.php';
				}
				if (box === "logout")
				{
					window.location.href = 'logout.php';
				}
			}
        </script>
    </div>

</body>

</html>
