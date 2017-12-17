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
			header("Refresh:0");
			exit;
		}
	}

	//assign the session to userid
	$_SESSION['userid'] = $userid;	
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Servo</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="container-fluid" align="center">
	<h1>Welcome to Servo!</h1>
	<h3>Sign Into Your Account or <a href="signup.php">Create a New One...</a></h3>
	<br>
	
	<form method = "post">
		<div class="row">
			<div class="form-group">	   
				<div class="col-sm-3 col-sm-offset-1">
					<label for="exampleInputEmail1">User Name or Email:</label>
				</div>
				<div class="col-sm-4 col-sm-offset-0">
					<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username or email" name="username">
					<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
				</div>
			</div>
      	</div>
	  	<br>
		
		<div class="row">
      		<div class="form-group">
				<div class="col-sm-offset-1 col-sm-3">
        			<label for="exampleInputPassword1">Password:</label>
				</div>	
				<div class="col-sm-4">
        			<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
				</div>
      		</div>
	    </div>
		<br>
		
		<div class="row">
			<div class="col-sm-4 col-sm-offset-0">
				<label>Or Explore Servo Without An Account:</label>
			</div>
			<div class="col-sm-4">
      			<button type="submit" class="btn btn-primary">Lets Go!</button>
			</div>
		</div>
  </form>
</div>	  

</body>
</html>
