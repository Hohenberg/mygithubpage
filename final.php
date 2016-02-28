<?php
//connect to database
include ("dbConnect.php");
//styles
echo "<style>
.listMask{
	width: 40%;
	height: 100%;
	opacity: 0.4;
	background: #d9d9d9;
	border: 2px solid #d9d9d9;
	position: absolute;
	left: 57%;
	top: 0%;
}
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
	border: 10px solid #ffffff;
	width: 50%;
	height: 40%;
	position: absolute;
	left: 3%;
	top: 3%;
}
.secondOval{
	border-radius: 600px / 600px;
	border: 10px solid #d9d9d9;
	width: 20%;
	height: 16%;
	position: absolute;
	left: 1%;
	top: 47%;
}
.thirdOval{
	border-radius: 600px / 600px;
	border: 10px solid #b3b3b3;
	width: 10%;
	height: 8%;
	position: absolute;
	left: 8%;
	top: 68%;
}
.fourthOval{
	border-radius: 600px / 600px;
	border: 10px solid #8c8c8c;
	width: 4%;
	height: 3%;
	position: absolute;
	left: 16%;
	top: 80%;
}
.fifthOval{
	border-radius: 600px / 600px;
	border: 10px solid #666666;
	width: 2%;
	height: 1%;
	position: absolute;
	left: 20%;
	top: 87%;
}
.listBox{
	color: white;
	width: 36.5%;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	font-weight: bold;
	font-size: 20px;
	position: absolute;
	left: 59%;
	top: 20%;
}
.error{
	color: white;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	font-weight: bold;
	font-size: 20px;
	position: absolute;
	left: 59%;
	top: 20%;
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
	width: 36.5%;
	position: absolute;
	left: 8.5%;
	top: 32.5%;
}
</style>";
//posting up required variables
if ($_POST["total"]) $total = $_POST["total"];
if ($_POST["dubTime"]) $dubTime = $_POST["dubTime"];
if ($_POST["newTime"]) $newTime = $_POST["newTime"];
$scores = array();
$ids = array();
//update scores to reflect current vote
for ($i=0; $i<$total; $i++){
	if ($_POST["score".$i]) $scores[$i] = $_POST["score".$i];
	else $scores[$i] = 0;
	if ($_POST["ids".$i]) $ids[$i] = $_POST["ids".$i];
	executeQuery("UPDATE messages SET score = '$scores[$i]' WHERE id = '$ids[$i]'");
}
//select high scores
$result = executeQuery("SELECT message, name FROM messages WHERE time<'$newTime' AND time>'$dubTime' ORDER BY score DESC, name LIMIT 10");
$count = 1;
//generate content elements
echo "<div style = 'width: 100%; height: 100%; position: absolute; top:0px; left:0px;'>";
echo "<div>
		<img src = '/php/messageMatch/background2.jpg' style = 'width: 100%; height: 100%;'></img>
	</div>";
echo "<div class = 'bigOval'></div>";
echo "<div class = 'secondOval'></div>";
echo "<div class = 'thirdOval'></div>";
echo "<div class = 'fourthOval'></div>";
echo "<div class = 'fifthOval'></div>";
echo "<div class = 'arrow'></div>";
echo "<div class = 'shaft'></div>";
echo "<span class = 'finalTitle'>The most popular messages from <br>last hour, around the globe <br></span>";
echo "<div class = 'listMask'></div>";
echo "<div class = 'listBox'>";
//display high scores
while ($row = $result->fetch_assoc()){
	echo "<span style = 'font-weight:bold;'>".$count.". </span>&#34".$row["message"]."&#34 &#8212 <span style = 'font-style:oblique'>".$row["name"]."</span><br><br>";
	$count++;
}
echo "</div>";
//error message
if ($count==1) echo "<span class = 'error'>Whoops, there appears to have been no messages <br> submitted in the last hour.<br><br>
	Lashings of apologies and all that.<br></span>";
echo "</div>";
?>