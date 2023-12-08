<?php

session_start();

?>

<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$_SESSION["username"] = $_POST['username'];
	$_SESSION["pass"] = $_POST['password'];
	
	$pass=crypt($_SESSION["pass"],'$1$somethin$');

	//now compare this md5 hash with the stored hashed password for this user (if this user exists)

	// forward the user to home page if login was successful.
	header("Location: home.php");
	
	
}else{

//remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 


?>

<div style="position:relative;left:800px;top:400px;border:solid;width:300px;">
<form action="login.php" method="POST" style="position:relative;left:20px;">
	<p>Please Log in:
	<br />
	<span>Username <input type="Text" name="username"/> </span> 
	<br>
	<br />
	<span>Password <input type="password" name="password"/> </span>
	</p>
	<input type="Submit" value = "Log in"/>
</form>
</div>

<?php 
}

?>