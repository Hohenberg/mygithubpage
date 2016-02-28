<?php
//connect to database
include("dbConnect.php");
//initialize name and message variables
$name = false;
$msg = false;
if ($_POST["writeName"]) $name = htmlspecialchars($_POST["writeName"], ENT_QUOTES);
else $name = "Anonymous";
if ($_POST["writeMessage"]) $msg = htmlspecialchars($_POST["writeMessage"], ENT_QUOTES);
//insert new message into the database
if ($name&&$msg){
	$result = executeQuery("SELECT id FROM messages ORDER BY ID DESC LIMIT 1");
	while ($row = $result->fetch_assoc()){
		$latest = $row["id"];
	}
	$newID = $latest+1;
	$curTime = date('Y-m-d H:i:s');
	executeQuery("INSERT IGNORE INTO messages VALUES ($newID, '$msg', 0, '$curTime', '$name')");
}
//generate time for the voting population
$curTime = date('Y-m-d H:i:s');
$curY = substr($curTime, 0, 4);
$curM = substr($curTime, 5, 2);
$curD = substr($curTime, 8, 2);
$curH = substr($curTime, 11, 2);
$newTime = $curY."-".$curM."-".$curD." ".$curH.":00:00";
$dubH = 0;
if ($curH==0){
	$curD--;
	$dubH=23;
	if ($curD<1){
		$curM--;
		if ($curM==0){
			$curY--;
			$curM=12;
		}
		if ($curM==1||$curM==3||$curM==5||$curM==7||$curM==8||$curM==10||$curM==12) $curD = 31;
		else if ($curM==2) $curD = 28;
		else if ($curM==4||$curM==6||$curM==9||$curM==11) $curD = 30;
	}
}
else $dubH = $curH-1;
$dubTime = $curY."-".$curM."-".$curD." ".$dubH.":00:00";
//get values for all voting options in that time slot
$result = executeQuery("SELECT message, score, id FROM messages WHERE time<'$newTime' AND time>'$dubTime'");
$total = mysqli_num_rows($result);
$message = array();
$score = array();
$ids = array();
$holder = array();
$pair = array();
$i=0;
while ($row = $result->fetch_assoc()){
	$message[$i] = $row["message"];
	$score[$i] = $row["score"];
	$ids[$i] = $row["id"];
	$holder[$i] = $i;
	$i++;
}
//figure out the pairings
$pairNum = floor($total/2);
for ($c=0; $c<$pairNum; $c++){
	$og = $holder[$c];
	$pair[$c] = rand(($pairNum), ($pairNum*2-1));
	$n=0;
	while ($n<$c){
		if ($pair[$c]==$pair[$n]){
			$pair[$c] = rand(($pairNum), ($pairNum*2-1));
			$n=0;
		}
		else $n++;
	}
	$holder[$c] = "$og v ".$pair[$c];
}
//styles
echo "<style>
.voteBtn{
	font-weight: bold;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	background: #808080;
	color: white;
	border: 2px solid #808080;
	border-radius: 5px;
	font-size: 16px;
	width: 36%;
	height: 10%;
	text-align: center;
	vertical-align: middle;
	cursor: pointer;
	position: absolute;
	white-space: normal;
	z-index: 3;
}
.results{
	font-weight: bold;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	background: #808080;
	color: white;
	font-size: 16px;
	width: 100%;
	height: 7%;
	border: 2px solid #808080;
	text-align: center;
	vertical-align: middle;
	cursor: pointer;
	position: absolute;
	white-space: normal;
}
.legendTitle{
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	color: #333333;
}
.optionField{
	width: 40%;
	height: 21%;
	position: absolute;
}
.titleBlock{
	color: white;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	font-size: 90px;
	font-weight: bold;
	position: absolute;
	top: 20%;
	left: 38%;
	z-index: 8;
}
.emptyOptions{
	z-index: 1;
	color: white;
	font-size: 24px;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	font-weight: bold;
	position: absolute;
	top: 45%;
	left: 40%;
}
</style>";
//create content elements
echo "<div id = 'container' style = 'width:100%; height: 100%; position: absolute; left: 0px; top: 0px;'>
<div>
	<img src = '/php/messageMatch/background2.jpg' style = 'width: 100%; height: 100%;'></img>
</div>
<fieldset style = 'border: 2px solid; color: #999999; top: 45%; left: 5%;' class = 'optionField'>
	<legend class = 'legendTitle'>Option 1</legend>
	<span class='emptyOptions'>No more</span>
</fieldset>
<fieldset style = 'border: 2px solid; color: #999999; top: 45%; left: 52%;' class = 'optionField'>
	<legend class = 'legendTitle'>Option 2</legend>
	<span class='emptyOptions'>options left</span>
</fieldset>
<script type = 'text/javascript'>
	var leftButton = new Array();
	var rightButton = new Array();
	var message = new Array();
	var holder = new Array();
	var score = new Array();
	var ids = new Array();
	var nextStep = new Array();
</script>
</div>
";
//generate the two different buttons repetitively
for ($s=0; $s<$pairNum; $s++){
	$pos = strpos($holder[$s], v);
	$og = substr($holder[$s], 0, ($pos-1));
	$new = substr($holder[$s], ($pos+2));
	echo "<script type = 'text/javascript'>
		message[$og]='".$message[$og]."';
		message[$new]='".$message[$new]."';
		holder[$s]='".$holder[$s]."';
		score[$og]='".$score[$og]."';
		score[$new]='".$score[$new]."';
		ids[$og]='".$ids[$og]."';
		ids[$new]='".$ids[$new]."';

		var container = document.getElementById('container');
		if ($s!=($pairNum-1)){
			nextStep[$s] = $s+1;
		}
		else {
			nextStep[$s] = -1;
		}
		var text = message[$og];
		text = text.replace('&#039;', '\u0027');	
		leftButton[$s] = document.createElement('INPUT');
		leftButton[$s].value = text;
		leftButton[$s].type = 'button';
		leftButton[$s].setAttribute('id', '".$og."');
		leftButton[$s].setAttribute('name', '".$s."');
		leftButton[$s].setAttribute('onclick', 'stepper(nextStep[$s], this.id)')
		leftButton[$s].className = 'voteBtn';
		leftButton[$s].style.display = 'none';
		leftButton[$s].style.top = '52%';
		leftButton[$s].style.left = '8%';
		container.appendChild(leftButton[$s]);

		var text = message[$new];
		text = text.replace('&#039;', '\u0027');
		rightButton[$s] = document.createElement('INPUT');
		rightButton[$s].value = text;
		rightButton[$s].type = 'button';
		rightButton[$s].setAttribute('id', '".$new."');
		rightButton[$s].setAttribute('name', '".$s."');
		rightButton[$s].setAttribute('onclick', 'stepper(nextStep[$s], this.id)');
		rightButton[$s].className = 'voteBtn';
		rightButton[$s].style.display = 'none';
		rightButton[$s].style.top = '52%';
		rightButton[$s].style.left = '55%';
		container.appendChild(rightButton[$s]);
	</script>";
}
//functionality for proceeding in rankings
echo "<script type = 'text/javascript'>
	function stepper(key, winner){
		if (winner){
			var hidScore = document.getElementById('hid'+winner);
			var tempValue = hidScore.value;
			var newScore = tempValue+1;
			hidScore.value = newScore;
		}

		var curSet = document.getElementsByName(key);
		if (curSet.length>0){
			curSet[0].style.display = 'inline-block';
			curSet[1].style.display = 'inline-block';
			for (var i=0; i<$pairNum; i++){
				if (i!=key){
					var subSets = document.getElementsByName(i);
					subSets[0].style.display = 'none';
					subSets[1].style.display = 'none';
				} 
			}
		}
		else{
			var subSets = document.getElementsByName($pairNum-1);
			subSets[0].style.display = 'none';
			subSets[1].style.display = 'none';
		}
	}
	stepper(0);
</script>";
//generate elements that will carry info that will be saved for the score board
echo "<form action = 'final.php' method = 'post'>";
echo "<span class = 'titleBlock'>Yammr</span>";
echo "<input type = 'hidden' name = 'total' value = '".($pairNum*2)."'>";
for ($v=0; $v<($pairNum*2); $v++){
	echo "<input type = 'hidden' name = 'dubTime' value = '$dubTime'>";
	echo "<input type = 'hidden' name = 'newTime' value = '$newTime'>";
	echo "<input type = 'hidden' name = 'score$v' id = 'hid$v' value = '$score[$v]'>";
	echo "<input type = 'hidden' name = 'ids$v' value = '$ids[$v]''>";
}
echo "<input type = 'submit' class = 'results' style = 'top: 75%; left: 0%; width: 100%; height: 7%;' value = 'See Results'>";
echo "</form>";
?>