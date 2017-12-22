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
          <form class="navbar-form navbar-left" role="search" method="post">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search" name="searchInput">
            </div>
            <button type="submit" class="btn btn-default" name="searchButton">Submit</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="home.php" title="Home Page Link">Home</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="settingsadmin.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
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
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="banUser" placeholder="Username" name="banUser">
			<button type="submit" class="btn btn-primary" name="banUserButton">Ban User</button>
		</form>
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<form class="form-inline" method="post">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="unblockUser" placeholder="Username" name="unblockUser">
			<button type="submit" class="btn btn-primary" name="unblockUserButton">Unblock User</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
	  	<form class="form-inline" method="post">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="unbanuser" placeholder="Username" name="unbanUser">
			<button type="submit" class="btn btn-primary" name="banUserButton">Unban User</button>
		</form>
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<form class="form-inline" method="post">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="addcategory" placeholder="Category Name" name="addCategory">
			<button type="submit" class="btn btn-primary" name="addCategoryButton">Add Category</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
	  	<form class="form-inline" method="post">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="removeCategory" placeholder="Category Name" name="removeCategory">
			<button type="submit" class="btn btn-primary" name="removeCategoryButton">Remove Category</button>
		</form>
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<form class="form-inline" method="post">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="removeReport" placeholder="Report ID" name="removeReport">
			<button type="submit" class="btn btn-primary" name="removeReportButton">Remove Report</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
	  	<form class="form-inline" method="post">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="unfollow" placeholder="Username" name="unfollow">
			<button type="submit" class="btn btn-primary" name="unfollowButton">Unfollow</button>
		</form>
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
	  	<div id="banlist">
			<h3>System Ban List:</h3>
			<ul class="list-group">
			<?php 
				$bannedNames = array();
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
						echo "<li class='list-group-item'> No Users Have Been Banned From The Site";
				}	
			?>
			</ul>
		</div>
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<div id="reports">
			<h3>Reports:</h3>
			<ul class="list-group">
			<?php 
				$reportDates = array();
				$reportMessages = array();
				$reporterID = array();
				$reporterNames = array();
				$reportMessages = array();
				$reportTypes = array();

				$sql = "SELECT * FROM Report JOIN User ON (User.ID = Report.userID)";
				$result = mysqli_query($conn, $sql);
				if($result){
				  if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($searchuserresult,MYSQLI_ASSOC)) {
					  $reportDates[] = row['date']; 
					  $reportMessages[] = row['message']; 
					  $reporterID[] = row['userID']; 
					  $reporterNames[] = row['username']; 
					  $reportMessages[] = row['message']; 
					  $reportTypes[] = row['reportType'];   
					}
				  }
				}

				for($i = 0; $i < sizeof($reporterID); $i){
				  //a user got reported
				  if(reportTypes[$i] == 0){
				  //print
					  echo "<li class='list-group-item'>User <a href='user.php?varname=$topicid'>".$row["username"]."</a> Got Reported By User <a href='user.php?varname=$topicid'>".$row["username"]."</a>"; 
				  }
				  //a topic got reported
				  else if(reportTypes[$i] == 1){
				  //print
					  echo "<li class='list-group-item'>Friend <a href='user.php?varname=$topicid'>".$row["username"]."</a> Reported Topic <a href='topic.php?varname=$topicid'>".$row["content"]."</a>"; 
				  }
				  //an entry got reported
				  else{
				  //print
					  echo "<li class='list-group-item'>Friend <a href='user.php'>".$row["username"]."</a> Reported Entry ".$row["content"]." On Topic <a href='topic.php?$topicid'>".$row["topicName"]."</a>";
				  }
					// no reports logic?
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
  	
  	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<h3>User Stats:</h3>
	  	<table class="table table-bordered">
		  <thead>
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Username</th>
			  <th scope="col">No Of Topics</th>
			  <th scope="col">No Of Entries</th>
			</tr>
		  </thead>
		  <tbody>
		  	<?php
			  $sql = "SELECT username, COUNT(ID) as EntryNum FROM Entry_Combined_View GROUP BY username ORDER BY EntryNum DESC";
				$result = mysqli_query($conn, $sql);

				$sql1 = "SELECT username, COUNT(ID) as TopicNum FROM Topic_Combined_View GROUP BY username ORDER BY TopicNum DESC";
				$result1 = mysqli_query($conn, $sql1);
				$usernameArr = array();
				$entryCountArr = array();
				$topicCountArr = array();

				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
				  $usernameArr[] = $row["username"];
				  $entryCountArr[] = $row["EntryNum"];
				}

				while($row = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
				  $key = array_search($row["username"], $usernameArr);
					if($row["TopicNum"] != "")	
				  		$topicCountArr[$key] = $row["TopicNum"];
					else
						$topicCountArr[$key] = 0;
				}

				for($i = 0; $i < sizeof($usernameArr); $i++)
				{					
					echo "<tr>";
					echo "<th scope='row'>".($i+1)."</th>";
				  //username is $usernameArr[$i]
					echo "<td>".$usernameArr[$i]."</td>";					
				  //topic count is $topicCount[$i]
					if($topicCountArr[$i])
						echo "<td>".$topicCountArr[$i]."</td>";
					else
						echo "<td>0</td>";
					 //entry count is $entryCount[$i]
					echo "<td>".$entryCountArr[$i]."</td>";
					echo "</tr>";
				}
			?>	
		  </tbody>
		</table>			
      </div>
	  
	  <div class="col-xs-6">
	  	<h3>Topic Stats:</h3>
	  	<table class="table table-bordered">
		  <thead>
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Topic Name</th>
			  <th scope="col">No Of Entries</th>
			</tr>
		  </thead>
		  <tbody>
		  	<?php
			  
			?>
			<tr>
			  <th scope="row">1</th>
			  <td>Cars</td>
			  <td>5</td>
			</tr>			
		  </tbody>
		</table>		
      </div>
  	</div>		
	
</div>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>