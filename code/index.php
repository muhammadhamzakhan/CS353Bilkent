<?php
	//connect to the database
	include 'connect.php';

	//initialize variables
	$name = "";
	$password = "";
	$userid = "";

	//function to strip and test the input data
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	//Upon POST
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//get the input from the user
	  	$name = test_input($_POST['username']);
	  	$password = test_input($_POST['password']);
	 	
	 	//if the name and password is blank, destroy session and log in to the home page with no user data
	 	if($name == "" && $password == ""){
			session_unset(); 
			session_destroy();
			header("Location:home.php");
			exit;
		}
		//Else if only one of the fields were left empty, warn the user!
		else if($name == "" || $password == ""){
			echo "<script>alert('Name or Password field can not be left blank!')</script>";
			header("Refresh:0");
			exit;
		}

		//Check the name input for the username or email values in database
		$sql = "SELECT * from User WHERE (username = '$name') or (email = '$name')";
		$result = $conn->query($sql);
		if($result){
			while ($row = $result->fetch_assoc()) {
				//check the password of that row
				if($password == $row['password']){
  					$userid = $row['ID'];
  					header("Location:home.php");
				}
			}
		}

		//if user id is still blank the login was faulty
		if($userid== ""){
			echo "<script>alert('Wrong Username or Password.')</script>";
			exit;
		}
	}

	//assign the session to userid
	$_SESSION['userid'] = $userid;	

?>
<!DOCTYPE html>
<html>
<head>
	<title>Servo</title>
</head>
<body>
<div align="center">
	<h2><b> Welcome to Servo!</b></h2>
	Sign Into Your Account or <a href="signup.php">Create a New One...</a>
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
