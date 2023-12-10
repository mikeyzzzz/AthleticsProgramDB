<?php
	include("db_connection.php");
	
	if(isset($_POST['coachLoginSubmit']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$sql = "select * from Coach where Username = '$username' and Password = '$password'";
		
		$result = mysqli_query($conn, $sql);
		
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$count = mysqli_num_rows($result);
		
		if($count==1)
		{
			
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("Location: coach-dashboard.php");
			exit();
		}
		else
		{
			echo '<script language="javascript">';
			echo 'alert("Login failed");';
			echo '</script>';
			header("Location: coach-login.php?var=failed");
		}
		
		
	}
	
?>