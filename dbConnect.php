<?php
//connect to the database
date_default_timezone_set('America/New_York');
$dbConnect = mysqli_connect("127.0.0.1", "root", "UWestern", "messageMatch");
if (!$dbConnect){
	echo "Error, database failed to connect<BR>";
}
function executeQuery($queryString){
	$dbC = mysqli_connect("127.0.0.1", "root", "UWestern", "messageMatch");
	if ($dbC){
		$result = $dbC->query($queryString);
	}
	return $result;
}
?>