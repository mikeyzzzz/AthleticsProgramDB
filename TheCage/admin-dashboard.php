<?php
    session_start();

    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header("Location: admin-login.php"); // Redirect to the login page if not logged in
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
            width: 100px;
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
        <h1>Admin Dashboard </h1>
        
        <div class="box" onclick="selectBox('athletes')">Athletes</div>
		<div class="box" onclick="selectBox('coaches')">Coaches</div>
		<div class="box" onclick="selectBox('teams')">Teams</div>
        <div class="box" onclick="selectBox('liftgroups')">Lift Groups</div>
		<div class="box" onclick="selectBox('excercises')">Excercises</div>
        <div class="box" onclick="selectBox('workouts')">Workouts</div>
		<div class="box" onclick="selectBox('events')">Events</div>
        <div class="box" onclick="selectBox('cage')">Cage</div>
        <div class="box" onclick="selectBox('logout')">Logout</div>
        

        <script>
            function selectBox(box) 
			{
				if (box === "athletes")
				{
					window.location.href = 'admin-athletes.php';
				}
				if (box === "coaches")
				{
					window.location.href = 'admin-coaches.php';
				}
				if (box === "teams")
				{
					window.location.href = 'admin-teams.php';
				}
				if (box === "liftgroups")
				{
					window.location.href = 'admin-liftgroups.php';
				}
				if (box === "excercises")
				{
					window.location.href = 'admin-excercises.php';
				}
				if (box === "workouts")
				{
					window.location.href = 'admin-workouts.php';
				}
				if (box === "events")
				{
					window.location.href = 'admin-events.php';
				}
				if (box === "cage")
				{
					window.location.href = 'admin-cage.php';
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
