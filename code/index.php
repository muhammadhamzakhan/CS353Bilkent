<?php
include 'connect.php';
$username = "";
$userpass = "";
$name = "";
$password = "";
$email = "";
// if(isset($_POST['username'])){
//     $user = $_POST['username'];
// }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	$name = test_input($_POST['username']);
  	$password = test_input($_POST['password']);
 	
 

  	$sql = "SELECT email from User WHERE email = '$name'";
	$result = $conn->query("sql");
	if($result){
		while ($row = $result->fetch_assoc()) {
			$email = $row['email'];
			
		}
	}

	$sql = "SELECT username from User WHERE username = '$name'";
	$result = $conn->query($sql);
	if($result){
		while ($row = $result->fetch_assoc()) {
			$username = $row['username'];
		}

	}

	$sql = "SELECT password from User WHERE password = '$password'";
	$result = $conn->query($sql);
	if($result){
		while($row = $result->fetch_assoc()){
			$userpass = $row['password'];

		}
	}

	if($name == "" && $password == ""){
		session_unset(); 
		session_destroy();
		header("Location:home.php");
		exit;
	}

	if($name == $username || $name = $email){
		if($password == $userpass){
			header("Location:home.php");
			exit;
		}
		else{
			echo "<script>alert('Wrong Password. Please Enter again')</script>";
		}
	}
	else{
		echo "<script>alert('Wrong Username or Password.')</script>";
	}
 	
}

	$_SESSION['username'] = $username;
	$_SESSION['email'] = $email;
	$_SESSION['password'] = $userpass;
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>Servo</title>
</head>
<body>
<div align="center">
	<h2><b> Welcome to Servo!</b></h2>
	Sign Into Your Account or <a href="register.php">Create a New One...</a>
	<form method = "post">
		User Name or Email: <input type="text" name="username" >
  		<br>
  		Password: <input type="text" name="password" > 
  		<br>
  		<input type="submit" value="Lets Go!">     
	</form>
	<form action="reset.php">
    <input type="submit" value="Reset Password?" />
	</form	

</div>

</body>
</html>