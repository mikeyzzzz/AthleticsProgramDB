<?php
	include("db_connection.php");
?>

<?php
    if (isset($_GET['var']) && $_GET['var'] === 'failed') {
       
        echo '<script language="javascript">';
        echo 'alert("Admin Login Failed");';
        echo '</script>';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .form-container {
            width: 300px;
            margin: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 2px solid black;
            padding: 20px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <form id="form" action="admin-login-verify.php" onsubmit="isValid()" method="POST"> 
        <h1> Admin Login </h1>

		<div class="form-group">
			Username: <input type="text" name="username" id="username"><br>
		</div>

		<div class="form-group">
			Password: <input type="password" name="password" id="password"><br>
		</div>

        <div class="form-group">
            <input type="submit" value="Login" name="adminLoginSubmit">
        </div>

    </form>
</div>

<script>
	document.getElementById("form").onsubmit = function () {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        if (!username || !password) {
            alert("Username and/or password field is empty.");

            return false;
        }
		return true;
    }

</script>

</body>
</html>
