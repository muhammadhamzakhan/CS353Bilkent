<?php
include 'connect.php';
$userID = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Servo | Topic</title>
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
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
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
                echo "<h4 class='panel-title'>".$taglist[$i]."</a></h4>";
                echo "</div>";
                echo "<ul class='list-group'>";
                for ($j = 0; $j < (sizeof($topiccontent)); $j++)
                {
                  if(strcmp($topictag[$j], $taglist[$i]) == 0)
                  {
                    //tag matches
                    // Topics
                    echo "<div id='collapseOne1' class='panel-collapse collapse in'>";
                    echo "<div class='panel-body'>"."<a href='topic.php?varname=$topicidlist[$j] class='list-group-item list-group-item-action'>".$topiccontent[$j]."</a>"."</div>";
                    echo "</div>";          
                  } 
                }
                echo "</ul>";
                echo "</div>";
              }
              ?>
            </div>
          </div>    

          <div class="col-sm-5" id = "middlecolumn">
            <?php
            // Xheni's code
             // <?php
  //include 'connect.php';
  //include 'topicnew.php';
  $comment = "";
  $entryID = "";
  if(isset($_GET["varname"])){
    $topicsID = $_GET["varname"];
    $_SESSION['topicsID'] = $topicsID;
  }
  else {
    $topicsID = $_SESSION['topicsID'];
  }

  //$userID = $_SESSION['userid'];
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
            <label class="hidden0">Edit your Topic here</label><input type="textarea" name="editTopic" class = "hidden0" rows="3" style="width:100%;" 
            value = "<?php echo $rows['content']?>"/>
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
         <input type="texta" name="entryID" value =<?php echo $rows['ID'];?> style = "display: none" />
          <label for = <?php echo "\"".$rows['ID']."\"";?>>Expand</label>
          <br />
          <label class=<?php echo "\"unhidden".$rows['ID']."\"";?>></label><input type="textarea" 
          name="editEntry" rows="4" style="width:100%;" value = "<?php echo $rows['content'];?>" class=<?php echo "\"unhidden".$rows['ID']."\"";?>/>
          <input type="submit" name="expandEntry" value="Expand" class=<?php echo "\"unhidden".$rows['ID']."\"";?>> 
        </form>
        <?php
      } 
      else{
        ?>
          <form method = "POST" action = "topic.php">
            <input type="text" name="entryID" value =<?php echo $rows['ID'];?> style = "display: none" />
            <input type="submit" value = "+1" name="ratingUp" id = "rateUp" >
            <input type="submit" value = "-1" name="ratingDown" >
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
    mysqli_query($conn, $sql);
    header("Refresh:0");
  }
  //rating down
  if(isset($_POST['ratingDown']) && isset($_POST["entryID"]) && !empty($_POST["entryID"])){
    $entryID = test_input($_POST["entryID"]);    
    $down = -1;
    $sql = "INSERT INTO Rating (userID, entryID, value) VALUES('$userID', '$entryID', '$down')";
    $conn->query($sql);
    header("Refresh:0");
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
      header("Refresh:0");

    }
   
  }
  //edit a topic
  if (isset($_POST["editTopic"]) && !empty($_POST["editTopic"])){
      $editedTopic = test_input($_POST["editTopic"]);
      $sql = "UPDATE Topic SET content = '$editedTopic' WHERE ID = '$topicsID'";
      $conn->query($sql);
      header("Refresh:0");
  }
  //edit an entry
  if (isset($_POST["editEntry"]) && !empty($_POST["editEntry"])){
       if (isset($_POST["entryID"]) && !empty($_POST["entryID"])){
          $entryID = test_input($_POST["entryID"]);
       }   
      $editedEntry = test_input($_POST["editEntry"]);
      $sql = "UPDATE Entry SET content = '$editedEntry' WHERE ID = '$entryID'";
      $conn->query($sql);
      header("Refresh:0");
  }  
 
  ?> 

  <!DOCTYPE html>
  <html>

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
        <input type="submit" name="submitEntry" value="Submit">  
    </form>

  </body>
  </html>
            

          </div>
          <div class="col-sm-4" id="rightbar">
            <div id="usertopicsbar">
              <h3>Your Topics:</h3>
              <ul class="list-group">
                <?php 
                $usertopicsql = "SELECT ID, content FROM Topic WHERE userID = '$userID'";
                $usertopicsresult = mysqli_query($conn, $usertopicsql);
                if(mysqli_num_rows($usertopicsresult) > 0)
                {
                  while($row = mysqli_fetch_array($usertopicsresult,MYSQLI_ASSOC)) 
                  {
                    $topicid = $row["ID"];
                    echo "<a href='topic.php?varname=$topicid' class='list-group-item list-group-item-action'>".$row["content"]."</a>";       
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
                if(mysqli_num_rows($favoritetopicsresult) > 0)
                {
                  while($row = mysqli_fetch_array($favoritetopicsresult,MYSQLI_ASSOC)) 
                  {
                    $topicid = $row["ID"];
                    echo "<a href='topic.php?varname=$topicid' class='list-group-item list-group-item-action'>".$row["content"]."</a>";
                  }
                }
                else
                  echo "<li class='list-group-item'> You Don't Have Any Favorite Topics";
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>  
    </body>
  </html>
