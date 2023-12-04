

<html>
<body>
<img src="/csc540/images/logged_in.svg" width="50px;"></img>
<br>
<br>
<?php

session_start();

echo "Welcome, ".$_SESSION["username"];
echo "<br><a href=\"login.php\">Log out</a>";

?>

</body>
</html>