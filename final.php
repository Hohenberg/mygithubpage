<?php
include ("dbConnect.php");
echo "<style>
.finalTitle{
	color: white;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	font-weight: bold;
	font-size: 36px;
	position: absolute;
	top: 18%;
	left: 8%;
}
.bigOval{
	border-radius: 600px / 600px;
	border: 10px solid white;
	width: 50%;
	height: 40%;
	position: absolute;
	left: 3%;
	top: 3%;
}
.secondOval{
	border-radius: 600px / 600px;
	border: 10px solid white;
	width: 20%;
	height: 16%;
	position: absolute;
	left: 1%;
	top: 47%;
}
.thirdOval{
	border-radius: 600px / 600px;
	border: 10px solid white;
	width: 10%;
	height: 8%;
	position: absolute;
	left: 8%;
	top: 68%;
}
.fourthOval{
	border-radius: 600px / 600px;
	border: 10px solid white;
	width: 4%;
	height: 3%;
	position: absolute;
	left: 16%;
	top: 80%;
}
.fifthOval{
	border-radius: 600px / 600px;
	border: 10px solid white;
	width: 2%;
	height: 1%;
	position: absolute;
	left: 20%;
	top: 87%;
}
.listBox{
	color: white;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	font-weight: bold;
	font-size: 20px;
	position: absolute;
	left: 57%;
	top: 10%;
}
.error{
	color: white;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	font-weight: bold;
	font-size: 20px;
	position: absolute;
	left: 57%;
	top: 10%;
}
.arrow{
    width: 0px;
    height: 0px;
    border-top: 15px solid transparent;
    border-bottom: 15px solid transparent;
    border-left: 30px solid white;
    position: absolute;
    top: 32.5%;
    left: 45%;
}
.shaft{
	background: white;
	height: 3.75%;
	width: 35%;
	position: absolute;
	left: 10%;
	top: 32.5%;
}
</style>";
if ($_POST["total"]) $total = $_POST["total"];
if ($_POST["dubTime"]) $dubTime = $_POST["dubTime"];
if ($_POST["newTime"]) $newTime = $_POST["newTime"];
$scores = array();
$ids = array();
for ($i=0; $i<$total; $i++){
	if ($_POST["score".$i]) $scores[$i] = $_POST["score".$i];
	else $scores[$i] = 0;
	if ($_POST["ids".$i]) $ids[$i] = $_POST["ids".$i];
	executeQuery("UPDATE messages SET score = '$scores[$i]' WHERE id = '$ids[$i]'");
}
$result = executeQuery("SELECT message, name FROM messages WHERE time<'$newTime' AND time>'$dubTime' ORDER BY score DESC, name LIMIT 10");
$count = 1;
echo "<div style = 'width: 100%; height: 100%; position: absolute; top:0px; left:0px; background: #33ffcc;'>";
echo "<div class = 'bigOval'></div>";
echo "<div class = 'secondOval'></div>";
echo "<div class = 'thirdOval'></div>";
echo "<div class = 'fourthOval'></div>";
echo "<div class = 'fifthOval'></div>";
echo "<div class = 'arrow'></div>";
echo "<div class = 'shaft'></div>";
echo "<span class = 'finalTitle'>The most popular messages from <br>last hour, around the globe <br></span>";
echo "<div class = 'listBox'>";
while ($row = $result->fetch_assoc()){
	echo "<span style = 'font-weight:bold;'>".$count.". </span>".$row["message"]." - <span style = 'font-style:oblique'>".$row["name"]."</span><br>";
	$count++;
}
echo "</div>";
if ($count==1) echo "<span class = 'error'>Whoops, there appears to have been no messages <br> submitted in the last hour.<br><br>
	Lashings of apologies and all that.<br></span>";
echo "</div>";
?>