<!-- Connection File -->
<?php	
	$servername = "localhost";
	$username = "mamed";
	$pass = "";
	$db = "servo";
	session_start();
	$conn = new mysqli($servername, $username, $pass, $db);
	date_default_timezone_set('Europe/Istanbul');
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
?>
