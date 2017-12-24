<?php
	include 'connect.php';
	$uid = $_SESSION['userid'];
	
	$sql = "SELECT isAdmin FROM User WHERE ID = '$uid'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	if($row['isAdmin'] == 1){
	  //redirect to admin
	  header("Location:settingsadmin.php");
	}
	else{
	  //redirect to pleb
	  header("Location:settingsuser.php");
	}
?>