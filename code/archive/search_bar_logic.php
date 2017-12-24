//open up a new page and execute code below

$uid = $userid;
$searchBarInput;

$usernames = array();
$userids = array();
$entryids = array();
$entrycontents = array();
$entryownernames = array();
$topicids = array();
$topiccontents = array();
$topicownernames = array();

$searchusersql = "SELECT​ ​ ID,​ ​ username​ ​ FROM​ ​ User​ ​ WHERE​ ​ username​ ​ LIKE​ ​ (“%'$searchBarInput'%”)";
$searchtopicsql = "SELECT​ ​ ID,​ ​ content,​ ​ username​ ​ FROM​ ​ topic ​ WHERE​ ​ username​ ​ LIKE​ ​ (“%'$searchBarInput'%”)
ORDER​ ​ BY​ ​ date";
$searchentrysql = "SELECT​ ​ ID,​ ​ content,​ ​ username​ ​ FROM​ ​ entry ​ WHERE​ ​ username​ ​ LIKE​ ​ (“%'$searchBarInput'%”)
ORDER​ ​ BY​ ​ date";

$searchuserresult = mysqli_query($db, $searchusersql);
$searchtopicresult = mysqli_query($db, $searchtopicsql);
$searchentryresult = mysqli_query($db, $searchentrysql);



if(mysqli_num_rows($searchuserresult) > 0){
	while($row = mysqli_fetch_array($searchuserresult,MYSQLI_ASSOC)) {
		$usernames[] = $row["username"];
		$userids[] = $row["ID"];
	}
}


if(mysqli_num_rows($searchentryresult) > 0){
	while($row = mysqli_fetch_array($searchentryresult,MYSQLI_ASSOC)) {
		$entryids[] = $row["ID"];
		$entrycontents[] = $row["content"];
		$entryownernames[] = $row["username"];
	}
}

if(mysqli_num_rows($searchtopicresult) > 0){
	while($row = mysqli_fetch_array($searchtopicresult,MYSQLI_ASSOC)) {
		$topicids[] = $row["ID"];
		$topiccontents[] = $row["content"];
		$topicownernames[] = $row["username"];
	}
}
 

