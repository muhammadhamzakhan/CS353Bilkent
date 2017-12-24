  <?php
  include 'connect.php';
  $comment = "";
  $entryID = "";
  if(isset($_GET["varname"])){
    $topicsID = $_GET["varname"];
    $_SESSION['topicsID'] = $topicsID;
  }
  else {
    $topicsID = $_SESSION['topicsID'];
  }

  $userID = $_SESSION['userid'];
  $username = "";
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
   
  function upvote(){

  }

  
  //fetch the topic
  $sql = "SELECT content, username, userID FROM Topic_Combined_View WHERE ID = '$topicsID'";
  $result = $conn->query($sql);
  if($result){
    while($rows = $result->fetch_assoc()){
      echo $rows['username'].": ".$rows['content'];
      if($rows['userID'] == $userID){ 
        ?>

          <form action = "topic.php" method="POST">
            <input type="checkbox" name="chkbox" id = "chk0" onclick="showHide()"/>
            <label for = "chk0">Expand</label>
            <br />
            <label class="hidden0">Edit your Topic here</label><input type="text" name="editTopic" class = "hidden0"/>
            <input type="submit" name="expandTopic" value="Expand" class = "hidden0"> 
          </form>
        <?php

      }
      else{
        ?>
          <input type="checkbox" name="favour" id = "setfavour" onclick="addFavourite(<?php echo $topicsID;?>)"><label for = "setfavour">Add to Favourites</label>
          <button>Report</button>
        <?php
      }
    }
  }
  echo "<br>";

  //fetch the entries
  $sql = "SELECT content, userID, username, ID FROM Entry_Combined_View WHERE topicsID = '$topicsID'";
  $result = $conn->query($sql);
  if($result){
    while($rows = $result->fetch_assoc()){
      echo $rows['username'].": ".$rows['content'];
      if($rows['userID'] == $userID){ 
        ?>
        <style>
          .hidden<?php echo $rows['ID'];?>{
            display: none;  
          }
          .unhidden<?php echo $rows['ID'];?>{
            display: none;
          }
        </style>
        <form action = "topic.php" method = "POST">
          <input type="checkbox" name="chkboxentry" id =<?php echo "\"".$rows['ID']."\"";?> onclick="showHideEntry(<?php echo $rows['ID'];?>)">
         <input type="text" name="entryID" value =<?php echo $rows['ID'];?> style = "display: none" />
          <label for = <?php echo "\"".$rows['ID']."\"";?>>Expand</label>
          <br />
          <label class=<?php echo "\"unhidden".$rows['ID']."\"";?>></label><input type="text" 
          name="editEntry" class=<?php echo "\"unhidden".$rows['ID']."\"";?>/>
          <input type="submit" name="expandEntry" value="Expand" class=<?php echo "\"unhidden".$rows['ID']."\"";?>> 
        </form>
        <?php
      } 
      else{
        ?>
          <form>
            <input type="text" name="entryID" value =<?php echo $rows['ID'];?> style = "display: none" />

            <input type="submit" value = "+1" name="ratingUp" id = "rateUp" >
            <input type="submit" value = "-1" name="ratingDown" >
            <input type="submit" value = "Report" name="report">
          </form>
        <?php
      } 
      echo "<br>";
    }
  }
  //rating up
  if(isset($_POST['ratingUp']) && isset($_POST["entryID"]) && !empty($_POST["entryID"])){
    $entryID = test_input($_POST["entryID"]);    
    $up = 1;
    $sql = "INSERT INTO Rating (userID, entryID, value) VALUES('$userID', '$entryID', '$up')";
    $conn->query($sql);
    //header("Refresh:0");
  }
  //rating down
  if(isset($_POST['ratingDown']) && isset($_POST["entryID"]) && !empty($_POST["entryID"])){
    $entryID = test_input($_POST["entryID"]);    
    $down = -1;
    $sql = "INSERT INTO Rating (userID, entryID, value) VALUES('$userID', '$entryID', '$down')";
    $conn->query($sql);
    //header("Refresh:0");
  }
  //reporting
  if(isset($_POST['report']) && isset($_POST["entryID"]) && !empty($_POST["entryID"])){
    $entryID = test_input($_POST["entryID"]);    
    $sql = "INSERT INTO Rating (userID, entryID, value) VALUES('$userID', '$entryID', '$up')";
    $conn->query($sql);
    //header("Refresh:0");
  }
  //insert a new entry
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["comment"])) {
      $comment = "";
    } 
    else {
      $comment = test_input($_POST["comment"]);
      $sql = "INSERT INTO Entry (content,topicsID, userID) VALUES('$comment', '$topicsID', '$userID')";
      $conn->query($sql);
      //header("Refresh:0");

    }
   
  }
  //edit a topic
  if (isset($_POST["editTopic"]) && !empty($_POST["editTopic"])){
      $editedTopic = test_input($_POST["editTopic"]);
      $sql = "UPDATE Topic SET content = '$editedTopic' WHERE ID = '$topicsID'";
      $conn->query($sql);
      //header("Refresh:0");
  }
  //edit an entry
  if (isset($_POST["editEntry"]) && !empty($_POST["editEntry"])){
       if (isset($_POST["entryID"]) && !empty($_POST["entryID"])){
          $entryID = test_input($_POST["entryID"]);
       }   
      $editedEntry = test_input($_POST["editEntry"]);
      $sql = "UPDATE Entry SET content = '$editedEntry' WHERE ID = '$entryID'";
      $conn->query($sql);
      //header("Refresh:0");
  }  
 
  ?> 

  <!DOCTYPE html>
  <html>
  <head>
  	<title>Servo | Topic</title>
  </head>
  <body>
      <!-- JAVA SCRIPT to show or hide the Expand edit box -->
  	 <script type="text/javascript">
         
     		function showHide(){
     			var checkbox = document.getElementById("chk0");
     			var hiddeninputs = document.getElementsByClassName("hidden0");
     			
     			for (var i = 0; i != hiddeninputs.length; i++) {
     				//try{
            if(checkbox.checked){
     					hiddeninputs[i].style.display = "block";
     				}
     				else{
              hiddeninputs[i].style.display = "none";
     				}//}catch(err){}
     			}
     		}
        function showHideEntry(id){
          var checkbox = document.getElementById(""+id);
          var hiddeninputs = document.getElementsByClassName("unhidden"+id);
          
          for (var i = 0; i != hiddeninputs.length; i++) {
            //try{            
              if(checkbox.checked){
              hiddeninputs[i].style.display = "block";
            }
            else{
              hiddeninputs[i].style.display = "none";
            }//}catch(err){}
          }
        }
        
  	</script>

    <style>
          .hidden0{
            display: none;  
          }
          .unhidden0{
            display: none;
          }
    </style>

  	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
   		Comment: <textarea name="comment" rows="5" cols="40"></textarea>
    		<input type="submit" name="submit" value="Submit">  
   	</form>
   	<a href="logout.php">Logout</a>
    <a href="home.php">Home</a>

  </body>
  </html>
