<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Servo Home Page </title>
<link href="css/navbar.css" rel="stylesheet" type="text/css">
</head>

<body>
	<nav id="navbar">
		<ul>
		  <li><a href="homepage.html" title="Home Page Link">Home</a></li>
		  <li><a href="messages.html">Messages</a></li>
		  <li><a href="#">Notifications</a></li>
		  <li><a href="settings.html">Settings</a></li>
		  <li><a href="logout.php">Logout</a></li>    
		</ul>
	</nav>

	<div id="usertopicsbar">
		<ul>
			<?php 
			include 'connect.php';
			$uid = $_SESSION['userid'];
	//		$uid = 1;
			$usertopicsql = "SELECT ID, content FROM Topic WHERE userID = '$uid'";
			$usertopicsresult = mysqli_query($conn, $usertopicsql);
			$usertopicnames = array();
			$usertopicids = array();
			
			if(mysqli_num_rows($usertopicsresult) > 0){
				while($row = mysqli_fetch_array($usertopicsresult,MYSQLI_ASSOC)) {
					$usertopicids[] = $row["ID"];
					$usertopicnames[] = $row["content"];
					echo "<li>".$row["content"]."</li>";
				}
			}
			?>
		</ul>
	</div>

<div id="favtopicsbar">
		<ul>
			<?php
			
			$favoritetopicsql = "SELECT * FROM Topic_Combined_View WHERE ID in (SELECT Favorite.contentID FROM Favorite WHERE userID = '$uid' && isInstanceTopic = 1) ORDER BY date DESC";
			$favoritetopicsresult = mysqli_query($conn, $favoritetopicsql);
			$favoritetopicnames = array();
			$favoritetopicids = array();
			
			if(mysqli_num_rows($favoritetopicsresult) > 0){
				while($row = mysqli_fetch_array($favoritetopicsresult,MYSQLI_ASSOC)) {
					$favoritetopicnames[] = $row["ID"];
					$favoritetopicids[] = $row["content"];
					echo "<li>".$row["content"]."</li>";
				}
			}
			?>
		</ul>
	</div>
	
	<div id="friendsactivity">
		<ul>
			<?php
			$db = $conn;

			$lastfentrysql = "SELECT * FROM Entry_Combined_View WHERE ID in (SELECT Favorite.contentID FROM Favorite WHERE userID = '$uid' && isInstanceTopic = 1) ORDER BY date DESC ";

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
					echo "<li>Friend ".$row["username"]." Posted Entry ".$row["content"]." On Topic ".$row["topicName"]; 
				}
			}
			
			$lastftopicsql = "SELECT * FROM Topic_Combined_View WHERE userID IN (SELECT ID AS UName FROM User JOIN UserFollow ON (UserFollow.followedID = User.ID && followerID = '$uid')) ORDER BY date DESC";

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
					echo "<li>Friend ".$row["username"]." Posted Topic ".$row["content"]; 
				}
			}
			?>
		</ul>
	</div>
</body>
</html>
