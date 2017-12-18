<?php
include 'connect.php';
$userID = $_SESSION['userid'];
$category = "";
$connected = FALSE;
if($username != "" or $email != ""){
	$connected = TRUE;
}
$comment = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["comment"])) {
		$comment = "";
	} else {
		$comment = test_input($_POST["comment"]);
	}
	$category = test_input($_POST["Category"]);
	$sql = "INSERT INTO Topic (content,userID, categoryName) VALUES('$comment', '$userID', '$category')";
	$conn->query($sql);
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
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
          <a class="navbar-brand" href="#">Servo</a></div>
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
            <li><a href="#">Settings</a></li>
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
  <div class="col-sm-3" id="topicbrowser">		  
    <h3>Browse Existing Topics:</h3>
	    <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
			
			<?php		
		
			$db = $conn;

			$topiclistsql = "SELECT * FROM Topic_Combined_View ORDER BY categoryName DESC, date ASC";
			$tagsql = "SELECT * FROM Category";

			$topiclistsqlresult = mysqli_query($db, $topiclistsql);
			$tagsqlresult = mysqli_query($db, $tagsql);

			$topiccontent = array();
			$topictag = array();
			$taglist = array();
			$topicidlist = array();

			if(mysqli_num_rows($topiclistsqlresult) > 0){
				while($row = mysqli_fetch_array($topiclistsqlresult,MYSQLI_ASSOC)) {
					$topiccontent[] = $row["content"];
					$topictag[] = $row["categoryName"];
					$topicidlist[] = $row["ID"];
				}
			}

			if(mysqli_num_rows($tagsqlresult) > 0){
				while($row = mysqli_fetch_array($tagsqlresult,MYSQLI_ASSOC)) {
					$taglist[] = $row["name"];	
				}
			}			
	
			for ($i = 0; $i < (sizeof($taglist)); $i++)
			{
				// Categories
				echo "<div class='panel panel-default'>";
		      	echo "<div class='panel-heading' role='tab'>";
//		        echo "<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion1'";
		//		echo "<h4 class='panel-title'><a data-parent='#accordion1'";
		//		echo "href='#collapseOne1'>".$taglist[$i]."</a></h4>";
				echo "<h4 class='panel-title'>".$taglist[$i]."</a></h4>";
	          	echo "</div>";	
				for ($j = 0; $j < (sizeof($topiccontent)); $j++)
				{
					if(strcmp($topictag[$j], $taglist[$i]) == 0)
					{
						//tag matches
						// Topics
						echo "<div id='collapseOne1' class='panel-collapse collapse in'>";
		        		echo "<div class='panel-body'>".$topiccontent[$j]."</div>";
	          			echo "</div>";					
					}	
				}				
	      		echo "</div>";
			}
			?>
		</div>
	</div>		
		
	  <div class="col-sm-5" id = "middlecolumn">
  <div id="postnewtopic">	
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

			    <h3>Create A New Topic:</h3>
                  <textarea name="comment" rows="3" style="width:100%;"><?php echo $comment;?></textarea>
				<br><br>
				<?php 
				$sql = "SELECT name from Category where 1";
				$result = $conn->query($sql);
				if($result)
				{
					echo "<select name='Category'>";
					echo '<option value = "" disabled selected>Category</option>';
					while ($row = $result->fetch_assoc()) 
					{
						echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
					}
					echo '</select>';// Close your drop down box		
				}
				?>
				<input type="submit" name="submit" value="Create">				
			</form>
		</div>
		
	<div id="friendsactivity">
		<h3>Your Friends' Activity Is As Following: </h3>
		<ul class="list-group">
				<?php
				$db = $conn;
				$lastfentrysql = "SELECT * FROM Entry_Combined_View WHERE ID in (SELECT Favorite.contentID FROM Favorite WHERE userID = '$userID' && isInstanceTopic = 1) ORDER BY date DESC ";
				$lastfentryresult = mysqli_query($db, $lastfentrysql);
				$lentryUsername = array();
				$lentryUID = array();
				$lentryContent = array();
				$lentryID = array();
				$lentryTopicID = array();
				$lentryTopicName = array();
				$ltopicContent = array();
				$lentryIndex = array();
				if(mysqli_num_rows($lastfentryresult) > 0){
					while($row = mysqli_fetch_array($lastfentryresult,MYSQLI_ASSOC)) {
						$lentryUsername[] = $row["username"];
						$lentryUID[] = $row["userID"];
						$lentryContent[] = $row["content"];
						$lentryID[] = $row["ID"];
						$lentryTopicID[] = $row["topicsID"];
						$lentryTopicName[] = $row["topicName"];
						echo "<li class='list-group-item'>Friend ".$row["username"]." Posted Entry ".$row["content"]." On Topic ".$row["topicName"]; 
					}
				}
				else
					echo "<li class='list-group-item'> Your Friends Have Not Made Any New Entries";

				$lastftopicsql = "SELECT * FROM Topic_Combined_View WHERE userID IN (SELECT ID AS UName FROM User JOIN UserFollow ON (UserFollow.followedID = User.ID && followerID = '$userID')) ORDER BY date DESC";
				$lastftopicresult = mysqli_query($db, $lastfentrysql);
				$ltopicUsername = array();
				$ltopicUID = array();
				$ltopicID = array();
				$ltopicTopicName = array();
				$ltopicDate = array();
				if(mysqli_num_rows($lastftopicresult) > 0){
					while($row = mysqli_fetch_array($lastftopicresult,MYSQLI_ASSOC)) {
						$ltopicUsername[] = $row["username"];
						$ltopicUID[] = $row["userID"];
						$ltopicID[] = $row["ID"];
						$ltopicTopicName[] = $row["content"];
						$ltopicDate[] = $row["date"];
						echo "<li class='list-group-item'>Friend ".$row["username"]." Posted Topic ".$row["content"]; 
					}
				}
				else
					echo "<li class='list-group-item'> Your Friends Have Not Posted Any New Topics";
				?>
		</ul>
		</div>
		</div>
      <div class="col-sm-4" id="rightbar">
		<div id="usertopicsbar">
	<h3>Your Topics:</h3>
		<ul class="list-group">
			<?php 

			$usertopicsql = "SELECT ID, content FROM Topic WHERE userID = '$userID'";
			$usertopicsresult = mysqli_query($conn, $usertopicsql);
			$usertopicnames = array();
			$usertopicids = array();

			if(mysqli_num_rows($usertopicsresult) > 0){
				while($row = mysqli_fetch_array($usertopicsresult,MYSQLI_ASSOC)) {
					$usertopicids[] = $row["ID"];
					$usertopicnames[] = $row["content"];
					echo "<li class='list-group-item'>".$row["content"]."</li>";
				}
			}
			else
				echo "<li class='list-group-item'> You Have Not Posted Any Topics";

			?>
	</ul>
	</div>	
	
	<div id="favtopicsbar">
		<h3>Your Favorite Topics:</h3>
		<ul class="list-group">	
			<?php

			$favoritetopicsql = "SELECT * FROM Topic_Combined_View WHERE ID in (SELECT Favorite.contentID FROM Favorite WHERE userID = '$userID' && isInstanceTopic = 1) ORDER BY date DESC";
			$favoritetopicsresult = mysqli_query($conn, $favoritetopicsql);
			$favoritetopicnames = array();
			$favoritetopicids = array();

			if(mysqli_num_rows($favoritetopicsresult) > 0){
				while($row = mysqli_fetch_array($favoritetopicsresult,MYSQLI_ASSOC)) {
					$favoritetopicnames[] = $row["ID"];
					$favoritetopicids[] = $row["content"];
					echo "<li class='list-group-item'>".$row["content"]."</li>";
				}
			}
			else
				echo "<li class='list-group-item'> You Don't Have Any Favorite Topics";
			?>
		</ul>
	</div>
  </div>
  </body>
</html>