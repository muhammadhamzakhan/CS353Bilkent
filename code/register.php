<?php
include 'connect.php';
$name = "";
$password = "";
$email = "";
$usermail = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	$name = test_input($_POST["username"]);
  	$password = test_input($_POST["password"]);
 	$email = test_input($_POST["email"]);

 	$sql = "SELECT username FROM User WHERE username = '$name'";
 	$result = $conn->query($sql);
 	if($result){
 		while ($row = $result->fetch_assoc()) {
 			$username = $row['username'];
 		}
 	}

 	$sql = "SELECT email FROM User WHERE email = '$email'";
 	$result = $conn->query($sql);
 	if($result){
 		while ($row = $result->fetch_assoc()) {
 			$usermail = $row['email'];
 		}
 	}

 	if($username != $name){
 		if($usermail != $email){
 			$sql = "INSERT INTO User(username, email, password) VALUES('$name', '$email', '$password')";
 			$conn->query($sql);
 			header("Location:home.php");
 			exit;
 		}
 		else{
 			echo "<script>alert('This email is already in usage.')</script>";
 			echo "Try logging in if you remember your credentials or reset your password if you don't remember it!";
 		}
 	}
 	else{
 		echo "<script>alert('This username is already in usage.')</script>";
 		echo "Try logging in if you remember your credentials or reset your password if you don't remember it!";
 	}


 	
  	
 
}
if(isset($_POST['username'])){
    $user = $_POST['username'];
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SERVO | Create Account</title>
</head>
<body>
	<center><h2><b>We Are Glad That You Decided To Join Our Community</b></h2></center>
	<div align="center">
		<form method="POST">
			User Name: <input type="text" name="username"><br>
			Email:     <input type="text" name="email"><br>
			Password:  <input type="text" name="password"><br>
					   <input type="submit" value="Lets Go!">
		</form>
	</div>
</body>
</html>