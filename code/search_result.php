<?php
	
	$searchBarInput = "";

	//check if the q in the url is set and is not empty
	if(isset($_GET['q']) && !empty($_GET['q'])){
		$searchBarInput = ($_GET['q']);
	}
	else{
		//User should not encounter such a scenario, go home user!
		header("Location:home.php");
		exit;
	}

	// echo "<script>alert('".$searchBarInput."')</script>";

	// $usernames = array();
	// $userids = array();
	// $entryids = array();
	// $entrycontents = array();
	// $entryownernames = array();
	// $topicids = array();
	// $topiccontents = array();
	// $topicownernames = array();

	//need to fix this query, it is not returning any result
	//when search inpu is mehmet it is not returning anything
	$searchusersql = "SELECT​ ​ ID,​ ​ username​ ​ FROM​ ​ User​ ​ WHERE​ ​ username​ ​ LIKE​ ​ (“%'$searchBarInput'%”)";
	$searchtopicsql = "SELECT​ ​ ID,​ ​ content,​ ​ username​ ​ FROM​ ​ Topic ​ WHERE​ ​ username​ ​ LIKE​ ​ (“%'$searchBarInput'%”) ORDER​ ​ BY​ ​ date";
	$searchentrysql = "SELECT​ ​ ID,​ ​ content,​ ​ username​ ​ FROM​ ​ Entry ​ WHERE​ ​ username​ ​ LIKE​ ​ (“%'$searchBarInput'%”) ORDER​ ​ BY​ ​ date";

	//run queries and test whether they are returning anything
	//delete these following if cases after fixing the issue
	$searchuserresult = mysqli_query($db, $searchusersql);
	if(!$searchuserresult){		
		echo "<script>alert('Query for searchusersql does not run! $searchBarInput is: ".$searchBarInput."')</script>";
	}
	$searchtopicresult = mysqli_query($db, $searchtopicsql);
	if(!$searchtopicresult){		
		echo "<script>alert('Query for searchtopicresult does not run! $searchBarInput is: ".$searchBarInput."')</script>";
	}
	$searchentryresult = mysqli_query($db, $searchentrysql);
	if(!$searchentryresult){		
		echo "<script>alert('Query for searchentryresult does not run! $searchBarInput is: ".$searchBarInput."')</script>";
	}

	// echo "<script>alert('".mysqli_num_rows($searchuserresult)."')</script>";

?>

<!-- HTML File -->
<!DOCTYPE html>
<html>
<head>
	<title>Search Result</title>
</head>
<body>
	<!-- Show the List of Users -->
	<div>
		<ul>
			<?php
				if(mysqli_num_rows($searchuserresult) > 0){
					echo "<p>List Of Users For Your Search Result:</p>";
					while($row = mysqli_fetch_array($searchuserresult,MYSQLI_ASSOC)) {
						// $usernames[] = $row["username"];
						// $userids[] = $row["ID"];

						//generate a list of username and upon click go to user's profile
						echo "<li class='list-group-item' onclick=\"window.location.href='#'\" >".$row["username"]."</li>";
					}
				}
				else{
					echo "<li>No User Was Found For Your Search Result</li>";
					// echo "<li class='list-group-item' onclick=\"window.location.href='messages.php?recipient=$rec_name'\" >".$rec_name."</li>";
				}
			?>
		</ul>
	</div>

	<!-- Show the List of Topics -->
	<div>
		<ul>
			<?php
				if(mysqli_num_rows($searchtopicresult) > 0){
					echo "<p>List Of Topics For Your Search Result:</p>";
					while($row = mysqli_fetch_array($searchtopicresult,MYSQLI_ASSOC)) {
						// $topicids[] = $row["ID"];
						// $topiccontents[] = $row["content"];
						// $topicownernames[] = $row["username"];
						echo "<li class='list-group-item' onclick=\"window.location.href='#'\" >".$row["content"]."</li>";
					}
				}
				else{
					echo "<li>No Topic Was Found For Your Search Result</li>";
					// echo "<li class='list-group-item' onclick=\"window.location.href='messages.php?recipient=$rec_name'\" >".$rec_name."</li>";
				}
			?>
		</ul>
	</div>

	<div>
		<ul>
			<?php
				if(mysqli_num_rows($searchentryresult) > 0){
					echo "<p>List Of Entries For Your Search Result:</p>";
					while($row = mysqli_fetch_array($searchentryresult,MYSQLI_ASSOC)) {
						// $entryids[] = $row["ID"];
						// $entrycontents[] = $row["content"];
						// $entryownernames[] = $row["username"];
						echo "<li class='list-group-item' onclick=\"window.location.href='#'\" >".$row["content"]."</li>";
					}
				}
				else{
					echo "<li>No Entry Was Found For Your Search Result</li>";
					// echo "<li class='list-group-item' onclick=\"window.location.href='messages.php?recipient=$rec_name'\" >".$rec_name."</li>";
				}
			?>
		</ul>
	</div>
</body>
</html>