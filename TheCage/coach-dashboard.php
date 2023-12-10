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
        <div class="box" onclick="selectBox('myteam')">My Team</div>
        <div class="box" onclick="selectBox('liftgroups')">Lift Groups</div>
        <div class="box" onclick="selectBox('stats')">Stats</div>
        <div class="box" onclick="selectBox('cage')">Cage</div>
        <div class="box" onclick="selectBox('logout')">Logout</div>
        

        <script>
            function selectBox(box) 
			{
				if (box === "profile")
				{
					window.location.href = 'coach-profile.php';
				}
				if (box === "myteam")
				{
					window.location.href = 'coach-myteam.php';
				}
				if (box === "liftgroups")
				{
					window.location.href = 'coach-liftgroups.php';
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
