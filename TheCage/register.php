<?php
    if (isset($_GET['var']) && $_GET['var'] === 'IDfail') 
	{
        echo '<script language="javascript">';
        echo 'alert("Registration failed. Either you already have an account, or someone else is using your ID");';
        echo '</script>';
    }
	if (isset($_GET['var']) && $_GET['var'] === 'Usernamefail') 
	{
        echo '<script language="javascript">';
        echo 'alert("Registration failed. Someone else already has that username. Please enter another");';
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
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            text-align: center; 
        }

        .form-group {
            margin-bottom: 15px;
            text-align: center; 
        }

        h1,
        h5 {
            text-align: center; 
        }
    </style>
</head>

<body>

    <div class="form-container">
        <form id="form" action="register-verify.php" method="POST" onsubmit="return isValid();">
            <h1> Register As Athlete </h1>
            <h5> Profile Information </h5>

            <div class="form-group">
                Student ID: <input type="text" name="student_id"><br>
            </div>

            <div class="form-group">
                First Name: <input type="text" name="first_name"><br>
            </div>

            <div class="form-group">
                Last Name: <input type="text" name="last_name"><br>
            </div>

            <div class="form-group">
                Phone Number: <input type="text" name="phone_number"><br>
            </div>

            <div class="form-group">
                Email: <input type="email" name="email"><br>
            </div>

            <div class="form-group">
				Class Year: 
				<select id="classyear" name="class_year_select">
					<option value="Freshman">Freshman</option>
					<option value="Sophomore">Sophomore</option>
					<option value="Junior">Junior</option>
					<option value="Senior">Senior</option>
					<option value="5+">5+</option>
				</select><br>
			</div>

			
			<div class="form-group">
				Sport:
				<select id="sport" name="sport_select">
					<option value="Baseball">Baseball</option>
					<option value="Basketball">Basketball</option>
					<option value="Cross Country">Cross Country</option>
					<option value="Football">Football</option>
					<option value="Soccer">Soccer</option>
					<option value="Swimming & Diving">Swimming & Diving</option>
					<option value="Track & Field">Track & Field</option>
					<option value="Field Hockey">Field Hockey</option>
					<option value="Gymnastics">Gymnastics</option>
					<option value="Lacrosse">Lacrosse</option>
					<option value="Softball">Softball</option>
					<option value="Volleyball">Volleyball</option>
				</select><br>
			</div>


            <h5> Login Information </h5>

            <div class="form-group">
                Username: <input type="text" name="username"><br>
            </div>

            <div class="form-group">
                Password: <input type="password" name="password"><br>
            </div>

            <div class="form-group">
                <input type="submit" value="Register" name="registerSubmit">
            </div>

            <a href="login.php">
                <h6>Already have an account? Click here to login</h6>
            </a>
        </form>
    </div>

    <script>
        function isValid() {
			var studentId = document.getElementsByName("student_id")[0].value;
			var firstName = document.getElementsByName("first_name")[0].value;
			var lastName = document.getElementsByName("last_name")[0].value;
			var phoneNumber = document.getElementsByName("phone_number")[0].value;
			var email = document.getElementsByName("email")[0].value;
			var classYear = document.getElementsByName("class_year_select")[0].value;
			var sport = document.getElementsByName("sport_select")[0].value; // Updated to get value from the sport dropdown
			var username = document.getElementsByName("username")[0].value;
			var password = document.getElementsByName("password")[0].value;

			if (!studentId || !firstName || !lastName || !phoneNumber || !email || !classYear || !sport || !username || !password) {
				alert("Please make sure to fill in all fields.");
				return false;
			}

			return true;
		}

    </script>

</body>

</html>
