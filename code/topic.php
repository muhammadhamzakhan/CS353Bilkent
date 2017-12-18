  <?php
  include 'connect.php';
  $comment = "";
  //$topicsID = $_GET['topicsID'];
  $topicsID = 11;
  $userID = 1;
  $entryID = 6;
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

          <form action = "#">
            <input type="checkbox" name="chkbox" id = "chk" onclick="showHide()"/>
            <label for = "chk">Expand</label>
            <br />
            <label class="hidden">Enter your text here</label><input type="text" name="editArea" class = "hidden"/>
            <input type="submit" name="expand" value="Expand" class = "hidden"> 
          </form>
        <?php

      }
    }
  }
  echo "<br>";

  //fetch the entries
  $sql = "SELECT content, userID, username FROM Entry_Combined_View WHERE topicsID = '$topicsID'";
  $result = $conn->query($sql);
  if($result){
    while($rows = $result->fetch_assoc()){
      echo $rows['username'].": ".$rows['content'];
      if($rows['userID'] == $userID){ ?>

        <form action = "#">
          <input type="checkbox" name="chkbox" id = "chk" onclick="showHide()"/>
          <label for = "chk">Expand</label>
          <br />
          <label class="hidden">Enter your text here</label><input type="text" name="editArea" class = "hidden"/>
          <input type="submit" name="expand" value="Expand" class = "hidden"> 
        </form>
<?php
      }    
      echo "<br>";
    }
  }

  //insert a new entry
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["comment"])) {
      $comment = "";
    } 
    else {
      $comment = test_input($_POST["comment"]);
    }
    $sql = "INSERT INTO Entry (content,topicsID, userID) VALUES('$comment', '$topicsID', '$userID')";
    $conn->query($sql);
  }

  //expanding an entry
  function expandEntry(){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $editedEntry = test_input($_POST["editArea"]);
      $sql = "UPDATE Entry SET content = '$editedEntry' WHERE ID = '$entryID'";
      $conn->query($sql);
    }
  } 
  ?> 


  <!DOCTYPE html>
  <html>
  <head>
  	<title>Servo | Topic</title>
  </head>
  <body>
      <!-- JAVA SCRIPT to show or hide the Expand checkbox -->
  	 <script type="text/javascript">
     		function showHide(){
     			var checkbox = document.getElementById("chk");
     			var hiddeninputs = document.getElementsByClassName("hidden");
     			
     			for (var i = 0; 1 != hiddeninputs.length; i++) {
     				if(checkbox.checked){
     					hiddeninputs[i].style.display = "block";
     				}
     				else{
              hiddeninputs[i].style.display = "none";
     				}
     			}
     		}
  	</script>
  <style> 
  	.hidden{
  		display: none;	
  	}
  </style>


  	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
   		Comment: <textarea name="comment" rows="5" cols="40"></textarea>
    		<input type="submit" name="submit" value="Submit">  
   	</form>
   	
   
  </form>
  </body>
  </html>