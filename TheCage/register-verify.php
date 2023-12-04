<?php
    include("db_connection.php");

    if(isset($_POST['registerSubmit']))
    {
		$athleteid = $_POST['student_id'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phoneNumber = $_POST['phone_number'];
        $email = $_POST['email'];
        $classYear = $_POST['class_year'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $checkSqlID = "SELECT * FROM Athlete WHERE AthleteID = '$athleteid'";
        $checkResultID = mysqli_query($conn, $checkSqlID);
        $checkCountID = mysqli_num_rows($checkResultID);
		
		$checkSqlUsername = "SELECT * FROM Athlete WHERE Username = '$username'";
        $checkResultUsername = mysqli_query($conn, $checkSqlUsername);
        $checkCountUsername = mysqli_num_rows($checkResultUsername);

        if($checkCountID > 0)
        {
            header("Location: register.php?var=IDfail");
            exit();
        }
		if($checkCountUsername > 0)
        {
            header("Location: register.php?var=Usernamefail");
            exit();
        }

        // If the username is not taken, proceed with registration
        $insertSql = "INSERT INTO Athlete (AthleteID, SportID, LiftgroupID, FirstName, LastName, PhoneNumber, Email, ClassYear, Username, Password) 
                      VALUES ('$athleteid', NULL, NULL, '$firstName', '$lastName', '$phoneNumber', '$email', '$classYear', '$username', '$password')";
        $insertResult = mysqli_query($conn, $insertSql);

        if($insertResult)
        {
            // Registration successful
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header("Location: athlete-dashboard.php");
            exit();
        }
        else
        {
            // Registration failed
            header("Location: register.php?var=failed");
            exit();
        }
    }
?>
