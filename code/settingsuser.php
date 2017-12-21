<?php
	include 'connect.php';
	$uid = $_SESSION['userid'];
	
	//function to strip and test the input data
	function test_input($data) 
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	if (isset($_POST['changePasswordButton'])) 
	{
    	//change password action
		$newPassword = test_input($_POST['changePassword']);
		$sql = "UPDATE User SET password = '$newPassword' WHERE User.ID = '$uid'";
		$result = mysqli_query($conn, $sql);
  		echo "<script>alert('Password Successfully Changed')</script>";
		header("Refresh:0");	
	} 
	else if (isset($_POST['blockUserButton'])) 
	{
    	//block user action
		$blocked_name = test_input($_POST['blockUser']);
		$sql = "SELECT ID FROM User WHERE username = '$blocked_name'";
		$result = mysqli_query($conn, $sql);
		if($result)
		{			
			if(mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			  	$blocked_id = $row['ID'];
			  	$sql = "INSERT INTO UserBlock VALUES ('$uid', '$blocked_id')";
			  	$result = mysqli_query($conn, $sql);
			  	if($result)
				{
					echo "<script>alert('User Successfully Blocked')</script>";
					header("Refresh:0");
				}
		  	}
		}
	} 
	else if(isset($_POST['banUserButton']))
	{
		$banned_name = test_input($_POST['banUser']);
		$sql = "SELECT ID FROM User WHERE username = '$banned_name'";
		$result = mysqli_query($conn, $sql);
		if($result)
		{
			if(mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			  	$banned_id = $row['ID'];
			  	$sql = "INSERT INTO AdminBan VALUES ('$uid', '$banned_id')";
			  	$result = mysqli_query($conn, $sql);
			  	if($result)
				{
					echo "<script>alert('User Successfully Banned')</script>";
					header("Refresh:0");
				}
		  	}
		}				
	}
	else if(isset($_POST['changeEmailButton']))
	{
		$newEmail = $_POST['changeEmail'];
		$sql = "UPDATE User SET email = '$newEmail' WHERE User.ID = '$uid'";
		$result = mysqli_query($conn, $sql);
		echo "<script>alert('Email Successfully Changed')</script>";
		header("Refresh:0");
	}
	else if(isset($_POST['addCategoryButton']))
	{
		$new_category_name = $_POST['addCategory'];
		$sql = "INSERT INTO Category VALUES ('$new_category_name')";
	  	$result = mysqli_query($conn, $sql);
	  	if($result)
		{
			echo "<script>alert('Category Successfully Added')</script>";
			header("Refresh:0");
	  	}
	}
	else if(isset($_POST['unblockUserButton']))
	{
		$unblocked_name = $_POST['unblockUser'];
		$sql = "SELECT ID FROM User WHERE username = '$unblocked_name'";
  		$result = mysqli_query($conn, $sql);
  		if($result)
		{
    		if(mysqli_num_rows($result) > 0)
			{
			  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			  $unblocked_id = $row['ID'];
			  $sql = "DELETE FROM UserBlock WHERE blockerID = '$uid' AND blockedID = '$unblocked_id')";
			  $result = mysqli_query($conn, $sql);
			  if($result)
			  {
				echo "<script>alert('User Successfully Unblocked')</script>";
				header("Refresh:0");
			  }
			}			
  		}
	}
	else
	{
		
    //no button pressed

	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings Admin</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body style="padding-top: 70px">
<div class="container-fluid">
	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topFixedNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
          <a class="navbar-brand" href="home.php">Servo</a></div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="topFixedNavbar1">
          <ul class="nav navbar-nav">
            <li class="active"></li>
            <li></li>
            <li class="dropdown">
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="home.php" title="Home Page Link">Home</a></li>
            <li><a href="#">Messages</a></li>
            <li><a href="#">Notifications</a></li>
            <li><a href="settingsadmin.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li class="dropdown">
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
    </nav>
	
	<div class="row">
	  <div class="col-xs-6">
	  	<form class="form-inline" method="post">
  			<input type="password" class="form-control mb-2 mr-sm-2 mb-sm-0" id="password" placeholder="New Password" name="changePassword">
			<button type="submit" class="btn btn-primary" name="changePasswordButton" >Change Password</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
	  	<form class="form-inline" method="post">
  			<input type="email" class="form-control mb-2 mr-sm-2 mb-sm-0" id="email" placeholder="New Email" name="changeEmail">
			<button type="submit" class="btn btn-primary" name="changeEmailButton">Change Email</button>
		</form>
      </div>
		
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<form class="form-inline" method="post">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="blockuser" placeholder="Username" name="blockUser">
			<button type="submit" class="btn btn-primary" name="blockUserButton">Block User</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">     	
	  	<form class="form-inline" method="post">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="unblockUser" placeholder="Username" name="unblockUser">
			<button type="submit" class="btn btn-primary" name="unblockUserButton">Unblock User</button>
		</form>
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">     	
	  	<form class="form-inline" method="post">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="unfollow" placeholder="Username" name="unfollow">
			<button type="submit" class="btn btn-primary" name="unfollowButton">Unfollow User</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
		  
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
     	
	  	<div id="blocklist">
			<h3>Your Block List:</h3>
			<ul class="list-group">
			<?php 
				$blockedNames = array();
				$sql = "SELECT username FROM UserBlock JOIN User ON (User.ID = UserBlock.blockedID) WHERE UserBlock.blockerID = '$uid'";
				$result = mysqli_query($conn, $sql);
				if($result){
				  if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
						$blockedNames[] = $row['username'];
						echo "<a href='#' class='list-group-item list-group-item-action'>".$row['username']."</a>";
					}
				  }
					else
						echo "<li class='list-group-item'> You Don't Have Any Blocked Users";
				}
			?>
			</ul>
		</div>	
      </div>
	  
	  <div class="col-xs-6">
     	<div id="following">
			<h3>Following:</h3>
			<ul class="list-group">
			<?php 
				$followedNames = array();
				$sql = "SELECT username FROM AdminBan JOIN User ON (User.ID = AdminBan.bannedID) WHERE AdminBan.adminID = '$uid'";
				$result = mysqli_query($conn, $sql);
				if($result){
				  if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($searchuserresult,MYSQLI_ASSOC)) {
					  	$bannedNames[] = row['username'];
						echo "<a href='#' class='list-group-item list-group-item-action'>".$row['username']."</a>";
					}
				  }
					else
						echo "<li class='list-group-item'> You Are Not Following Anyone";
				}
			?>
			</ul>
		</div>
      </div>
  	</div>	
</div>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>