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

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Servo Home Page </title>
<link href="css/homepage.css" rel="stylesheet" type="text/css">
</head>

<body>

	<div id="navbar">
		<ul>
			<li><a href="homepage.html" title="Home Page Link">Home</a></li>
			<li><a href="messages.html">Messages</a></li>
			<li><a href="#">Notifications</a></li>
			<li><a href="settings.html">Settings</a></li>
			<li><a href="logout.php">Logout</a></li>    
		</ul>
	</div>
	<br>
	
	<div id="topicbrowser">
		<h2>Browse Existing Topics:</h2>
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

			for ($i = 0; $i < (sizeof($taglist)); $i++){
				echo $taglist[$i]."<br>";	// Categories
				for ($j = 0; $j < (sizeof($topiccontent)); $j++){
					if(strcmp($topictag[$j], $taglist[$i]) == 0){
						//tag matches					
						echo $topiccontent[$j]."<br>";	// Topics				
					}	
				}
			}
			?>	
	</div>

<div id = middlecolumn>
		<div id="postnewtopic">	
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

			    <h2>Create A New Topic:</h2>
                  <textarea name="comment" rows="2"  cols="70"><?php echo $comment;?></textarea>
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
		<h2>Your Friends' Activity Is As Following: </h2>
		<ul>
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
						echo "<li>Friend ".$row["username"]." Posted Entry ".$row["content"]." On Topic ".$row["topicName"]; 
					}
				}

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
						echo "<li>Friend ".$row["username"]." Posted Topic ".$row["content"]; 
					}
				}
				?>
		</ul>
		</div>
	</div>
	
<div id="usertopicsbar">
	<h2>Your Topics:</h2>
		<ul>
			<?php 

			$usertopicsql = "SELECT ID, content FROM Topic WHERE userID = '$userID'";
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
		<h2>Your Favorite Topics:</h2>
		<ul>	
			<?php

			$favoritetopicsql = "SELECT * FROM Topic_Combined_View WHERE ID in (SELECT Favorite.contentID FROM Favorite WHERE userID = '$userID' && isInstanceTopic = 1) ORDER BY date DESC";
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


</body>
</html>