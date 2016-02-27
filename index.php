<?php
//Connect to the database
include("dbConnect.php");
//populate main page
echo "<html>";
echo "<style>
.textBox{
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	background: #00e6ac;
	border: 2px solid #333333;
	border-radius: 10px; 
	height:40%; 
	width:30%; 
	position: absolute; 
	left: 35%; top:20%; 
	overflow-y:auto;
}
.removeButton{
	cursor: pointer;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	color: white;
	font-weight: bold;
	position:relative;
	padding-top:20px;
	padding-bottom:20px;
	padding-left:39.5724%;
	padding-right:39.5724%;
	background: #333333;
	border: 2px solid #333333;
	top:25%;
	width:90%;
}
.inBox{
	color: #888;
	width: 40%;
	position: absolute;
	left: 30%;
	top:40%;
	height: 5%;
	font-size: 16px;
}
.subBtn{
	cursor: pointer;
	font-size: 16px;
	color: white;
	font-weight: bold;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	background: #333333;
	colour: white;
	width: 100%;
	height: 5%;
	position: absolute;
	top: 60%;
	left: 0;
	border: 0px;
}
.titleBlock{
	color: white;
	font-family: 'Trebuchet MS', Helvetica, sans-serif;
	font-size: 90px;
	font-weight: bold;
	position: absolute;
	top: 15%;
	left: 28%;
}
</style>";
echo "<div id = 'bigBox'>";
echo "<div style = 'width:100%; height:100%; z-index:7; opacity:0.8; background:#999999; position:absolute; left:0px; top:0px;' id = 'mask'>
	<div class = 'textBox' style = '!important opacity:1.0'>
		<span style = 'font-size:24px; font-weight: bold; color:white;'><br>Welcome to Yammr.<br></span>
		<span style = 'font-size: 16px;'><br>Post whatever message you want. Anything you can think of. Then vote on other people's messages in a head to 
		head system, replicated by others wherever this site is used, in order to determine the most popular message in the world of the last hour. 
		Find out what people think of each other.<br></span>
	<a class = 'removeButton' onclick = 'removeMask()' style = 'opacity:1.0;'>Get Started</a>
	</div>
</div>
";
echo "<script type = 'text/javascript'>
	function removeMask(){
		var mask = document.getElementById('mask');
		var box = document.getElementById('bigBox');
		var form = document.getElementById('bigForm');
		var linker = document.getElementById('bigLink');
		form.style.opacity = '1.0';
		linker.style.opacity = '1.0';
		box.removeChild(mask);
	}
</script>";
echo "	<form id = 'bigForm' action = 'voting.php' method = 'post' style = 'z-index: 3; opacity: 0.5; width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: #33ffcc;'>
			<span class = 'titleBlock'>Yammr</span>
			<input type = 'textbox' id = 'namebox' name = 'writeName' class = 'inBox' value = 'Name (Optional)' onfocus='inputFocus(this)' onblur='inputBlur(this)'>
			<input type = 'textarea' id = 'msgbox' name = 'writeMessage' class = 'inBox' value = 'Message' onfocus='inputFocus(this)' onblur='inputBlur(this)' style = 'top:48%;'>
			<input type = 'submit' class = 'subBtn' style = 'height: 7%'>
		</form>
	<a id = 'bigLink' href = 'voting.php' style = 'z-index: 5; text-align: center; padding-top: 20px; top:80%; text-decoration: none;' class = 'subBtn'>Skip to Voting</a>
	<div style = 'width: 100%; height: 15%; background: #ff9999; position: absolute; left: 0; top: 67%; z-index:4'></div>
	</div>
</html>";	
?>