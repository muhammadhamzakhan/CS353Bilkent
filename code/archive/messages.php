<?php
	include 'connect.php';
	$userID = $_SESSION['userid'];
	$rec_id = "";
	$to = "";

	//Check if user is logged in, if not go to home
	if($userID == ""){
		echo "<script>alert('You have to be logged in in order to be able to user the messaging. Please Log In and try again later!')</script>";
		header("Location:home.php");
		exit;
	}
	
	$connected = FALSE;
	if($username != "" or $email != ""){
		$connected = TRUE;
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	//a function to check whether two users have blocked each other or not
	//returns true if blocked
	function is_blocked($user1_id, $user2_id, $db){
		//user_1 should be logged in
		if($user1_id != ""){
			$sql = "SELECT * from UserBlock where ( (blockerID = '$user1_id') and (blockedID = '$user2_id') ) or ( (blockerID = '$user2_id') and (blockedID = '$user1_id') )";
			$result = mysqli_query($db, $sql);

			if( mysqli_num_rows($result) > 0 ){
				return true;
			}
			else{
				return false;
			}
		}
	}
?>

<!-- HTML FILE -->
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Messages</title>
	</head>

	<body>
		<h1>Messages Template</h1>

		<!-- Show the list of available users -->
		<ul>
			<?php
				//construct a query for the users list and call it
				$user_list_sql = "SELECT * FROM User Where 1 ORDER BY username DESC";
				$user_list_sql_result = mysqli_query($conn, $user_list_sql);

				//display available users to interact
				if(mysqli_num_rows($user_list_sql_result) > 0){
					while($row = mysqli_fetch_array($user_list_sql_result, MYSQLI_ASSOC)){
						$rec_id = $row["ID"];
						$rec_name = $row["username"];
						//print the list of users that are not blocked
						if(!is_blocked($userID, $rec_id, $conn) and ($rec_id != $userID) and !empty($rec_name))
						{
							echo "<li onclick=\"window.location.href='messages.php?recipient=$rec_name'\" >".$rec_name."</li>";
						}
					}
				}
			?>
		</ul>

		<!-- Show the messages -->
		<div>
			<?php
				if(isset($_GET['recipient']) && !empty($_GET['recipient'])){
				$to = ($_GET['recipient']);
				}

				if($to != ""){

					$user_message_sql = "SELECT * FROM User Where username = '$to'";
					$user_message_result = mysqli_query($conn, $user_message_sql);

					//check if there is more than one user with the same name
					if(mysqli_num_rows($user_message_result) > 1){
						echo "<script>alert('Something went wrong! Please try again.')</script>";
						header("Location:messages.php");
						exit;
					}

					//get that row
					$row = mysqli_fetch_array($user_message_result,MYSQLI_ASSOC);

					// if(mysqli_num_rows($user_message_result) > 0){
					if($row){
						$rec_id = $row["ID"];
						//check whether the two users have blocked each other
						if(is_blocked($userID, $rec_id, $conn) or ($rec_id == $userID)){
							echo "<script>alert('You are not allowed to interact with this user!')</script>";
							header("Location:messages.php");
							exit;
						}
						else{
							$msg_sql = "SELECT * from UserMessage where ( (senderID = '$userID') and (receiverID = '$rec_id') ) or ( (senderID = '$rec_id') and (receiverID = '$userID') ) ORDER BY messageDate ASC";
							$msg_result = mysqli_query($conn, $msg_sql);

							while($row = mysqli_fetch_array($msg_result,MYSQLI_ASSOC)){
								if($userID == $row["senderID"]){
									echo "<p> You: ".$row["messageContent"]."</p>";
								}
								else{
									echo "<p>".$to.": ".$row["messageContent"]."</p>";
								}
							}

							//generate the form
							echo "<div><form name=\"send_msg\" method=\"post\"><input type=\"text\" name=\"message_field\"><button type=\"submit\">Send</button></form></div>";

							//Upon post generated by the form, declared above
							if($_SERVER["REQUEST_METHOD"] == "POST"){
								//if the message is not empty
								if(!empty($_POST["message_field"])){
									$msg = $_POST["message_field"];
									$timestamp = date('Y-m-d G:i:s');
									$sql = "INSERT INTO `UserMessage` (`messageContent`, `messageDate`, `senderID`, `receiverID`) VALUES ('$msg', '$timestamp', '$userID', '$rec_id')";
									if(mysqli_query($conn, $sql)){
										header("Refresh:0");
										exit;
									}
									else{
										echo "<script>alert('Something went wrong! Please try again.')</script>";
										header("Location:messages.php");
										exit;
									}
								}
							}
						}
					}
					else{
						echo "<script>alert('The user that you want to message does not exist')</script>";
						header("Location:messages.php");
						exit;
					}
				}	
			?>
		</div>
	</body>
</html>