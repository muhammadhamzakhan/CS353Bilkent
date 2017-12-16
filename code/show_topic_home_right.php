$uid = $userid;
$usertopicsql = "SELECT ID, content FROM topic WHERE userID = '$uid'";
$usertopicsresult = mysqli_query($db, $usertopicsql);
$usertopicnames = array();
$usertopicids = array();

if(mysqli_num_rows($usertopicsresult) > 0){
	while($row = mysqli_fetch_array($usertopicsresult,MYSQLI_ASSOC)) {
		$usertopicnames[] = $row["ID"];
		$usertopicids[] = $row["content"];
	}
}

$favoritetopicsql = "SELECT​ ​ * ​ ​ FROM​ ​ Topic_Combined_View​ ​ WHERE​ ​ ID​ ​ in​ ​ (SELECT​ ​ Favorite.contentID​ ​ FROM
Favorite​ ​ WHERE​ ​ userID​ ​ = ​ ​ '$userID'​ ​ &&​ ​ isInstanceTopic​ ​ = ​ ​ 1)​ ​ ORDER​ ​ BY​ ​ date​ ​ DESC";
$favoritetopicsresult = mysqli_query($db, $favoritetopicsql);
$favoritetopicnames = array();
$favoritetopicids = array();

if(mysqli_num_rows($favoritetopicsresult) > 0){
	while($row = mysqli_fetch_array($favoritetopicsresult,MYSQLI_ASSOC)) {
		$favoritetopicnames[] = $row["topicsID"];
		$favoritetopicids[] = $row["topicName"];
	}
}
