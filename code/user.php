<?php
	include 'connect.php';
	$uid = $_SESSION['userid'];
	$friendID = $_GET["varname"];
	
	//function to strip and test the input data
	function test_input($data) 
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	if (isset($_POST['blockUserButton'])) 
	{
    	//block user action
		$blocked_id = $_GET["varname"];
		$sql = "INSERT INTO UserBlock VALUES ('$uid', '$blocked_id')";
		$result = mysqli_query($conn, $sql);
		if($result)
		{
			echo "<script>alert('User Successfully Blocked')</script>";
			header("Refresh:0");
		}		  	
	}
	else if(isset($_POST['unfollowUserButton']))
	{
		  $unfollowed_id = $_GET["varname"];
		  $sql = "DELETE FROM UserFollow WHERE followerID = '$uid' AND followedID = '$unfollowed_id'";
		  $result = mysqli_query($conn, $sql);
		  if($result)
		  {
			echo "<script>alert('User Successfully Unfollowed')</script>";
			header("Refresh:0");
		  }	  		
	}	
	else if(isset($_POST['followUserButton']))
	{
		  $followed_id = $_GET["varname"];
		  $sql = "INSERT INTO UserFollow VALUES('$uid','$followed_id'";
		  $result = mysqli_query($conn, $sql);
		  if($result)
		  {
			echo "<script>alert('User Successfully Followed')</script>";
			header("Refresh:0");
		  }	  		
		
	}
	else
	{
		
    //no button pressed

	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Untitled Document</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	  
  </head>
  <body style="padding-top: 70px">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
	<script src="js/jquery-1.11.3.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="js/bootstrap.js"></script>
	
  <div class="container-fluid">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topFixedNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
          <a class="navbar-brand" href="home.php">Servo</a></div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="topFixedNavbar1">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="home.php" title="Home Page Link">Home</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
    </nav>
		
	  	<div class="col-sm-5" id = "middlecolumn">
	  	
	  		<div class="row" style="margin-top:20px;">
				<?php
				// Print Username
				
				?>
			</div>
  		
	  		<div class="row" style="margin-top:20px;">
				<form class="form-inline col-md-5 col-md-offset-4" method="post">
					<button type="submit" class="btn btn-primary" name="blockUserButton">Block User</button>
				</form>
			</div>
			
			<div class="row" style="margin-top:20px;">
				<form class="form-inline col-md-7 col-md-offset-4" method="post">
					<button type="submit" class="btn btn-primary" name="followUserButton">Follow User</button>
				</form>
			</div>
			
			<div class="row" style="margin-top:20px;">
				<form class="form-inline col-md-5 col-md-offset-4" method="post">
					<button type="submit" class="btn btn-primary" name="unfollowUserButton">Unfollow User</button>
				</form>
			</div>
			
		</div>
     	
      	<div class="col-sm-5" id="rightcolumn">
			<h3>Users's Topics:</h3>
			<ul class="list-group">
				<?php 
				
				$userID = $friendID; 
				$usertopicsql = "SELECT ID, content FROM Topic WHERE userID = '$userID'";
				$usertopicsresult = mysqli_query($conn, $usertopicsql);

				if(mysqli_num_rows($usertopicsresult) > 0)
				{
					while($row = mysqli_fetch_array($usertopicsresult,MYSQLI_ASSOC)) 
					{
						$topicid = $row["ID"];
						echo "<a href='topic.php?varname=$topicid' class='list-group-item list-group-item-action'>".$row["content"]."</a>";				
					}
				}
				else
					echo "<li class='list-group-item'> Your Friend Have Not Posted Any Topics";

				?>
			</ul>
		</div>		
  </body>
</html>
