<?php 
session_start();
if(!(isset($_SESSION['Name']))){
	header("Location: index.php"); /* Redirect browser */
exit();
}
if(!isset($_SESSION['pid'])){
	header("Location: online.php"); /* Redirect browser */
exit();
}

include 'connection.php';
$conn = new MySQLi($server,$username,$password);
$sql = "select * from ".$dbname.".gamesessions where sessionid=".$_SESSION['gamesessionid'] ;
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	
	$pl1id= $row['pl1id'];
	$pl2id= $row['pl2id'];
}
$sql = "select * from ".$dbname.".users where Id=".$pl1id;
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	
	$pl1name= $row['username'];
}
$sql = "select * from ".$dbname.".users where Id=".$pl2id;
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	
	$pl2name= $row['username'];
}
$pltype =$_SESSION['pltype'];
if($pltype == 'rec'){
$pname = $pl1name;
$oppname = $pl2name;	
}
else if($pltype == 'sender'){
$pname = $pl2name;
$oppname = $pl1name;	
}

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $_SESSION['Name'];?> - Tic Tac Toe</title>
<link href="css/stylesheet.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap-3.3.4.css" rel="stylesheet" type="text/css">
<script src="jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
<script> 
var checkedboxes = new Array(0,0,0,0,0,0,0,0,0);
var z =0;
var turn = 0;
function sendmove(box){
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				    
					
            }
        };
		xmlhttp.open("GET","sendmove.php?b="+box,true);
        xmlhttp.send();	
}
function recievemove(){
	 if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				<?php echo  "var plrtype = '".$_SESSION['pltype']."';";?>
			   z = this.responseText;
			   if(z == "pl1"){
				   document.getElementById("plwin").innerHTML="<?php if($pltype == 'rec' ){ 
				   echo 'You ';}
				   else {
					   echo $pl2name;} ?> Won!";
					$("#myModal").css("display","block");
			   }
			   else if(z== "pl2"){
				   document.getElementById("plwin").innerHTML="<?php if($pltype == 'rec' ){ 
				   echo $pl2name;}
				   else {
					   echo 'You ';} ?> Won!";
					$("#myModal").css("display","block");
			   }
			   else if(z == "draw"){
				   document.getElementById("plwin").innerHTML="Draw !";
					$("#myModal").css("display","block");
			   }
			   else {
			   if(checkedboxes[z-1] == 0){ 
			   if(plrtype == 'rec'){
			  $(".div"+z).css("background-image", "url(images/cross1.png)");
			  turn=0;
			   }
			   else if(plrtype == 'sender'){
				   $(".div"+z).css("background-image", "url(images/tic1.png)");
				   turn =1;
				   
			   }
			   if(turn == <?php if($_SESSION['pltype'] == 'rec'){
				echo 0;
			}
			else if($_SESSION['pltype'] == 'sender'){
				echo 1;
			} ?>){
				document.getElementById("turntxt").innerHTML = "Your Turn!";
		document.getElementById("pl1").checked = true;
	}
	else {
		document.getElementById("turntxt").innerHTML = "Opponent Turn!";
		document.getElementById("pl2").checked = true;
	}	
			   checkedboxes[z-1] =1;
			   }
			   
    	
            }
			}
        };
        xmlhttp.open("GET","recievedata.php?r=1",true);
        xmlhttp.send();
	
}
recievemove();
setInterval("recievemove();",500);
$(document).ready(function(){
	var i =0;
	function radbtn(){
	
	if(turn == <?php if($_SESSION['pltype'] == 'rec'){
				echo 0;
			}
			else if($_SESSION['pltype'] == 'sender'){
				echo 1;
			} ?>){
				document.getElementById("turntxt").innerHTML = "Your Turn!";
		document.getElementById("pl1").checked = true;
	}
	else {
		document.getElementById("turntxt").innerHTML = "Opponent Turn!";
		document.getElementById("pl2").checked = true;
	}	
}
radbtn();
	    function onbuttonclick(box){
			
			if(turn == <?php if($_SESSION['pltype'] == 'rec'){
				echo 0;
			}
			else if($_SESSION['pltype'] == 'sender'){
				echo 1;
			} ?>){
				
			if(checkedboxes[box-1] == 0){ 
			if(i==0){
				<?php echo  "var plrtype = '".$_SESSION['pltype']."';";?>
			if(plrtype == 'rec'){
				
				
        $(".div"+box).css("background-image", "url(images/tic1.png)");
		turn = 1;
		}
		else {
			 $(".div"+box).css("background-image", "url(images/cross1.png)");
			 turn = 0;
		}
		radbtn();
		sendmove(box);
			}
			checkedboxes[box-1] = 1;
			}
			
		}}
		$(".div1").click(function(){
		onbuttonclick(1);
    });
	$(".div2").click(function(){
		onbuttonclick(2);
    });
	$(".div3").click(function(){
		onbuttonclick(3);
    });
	$(".div4").click(function(){
		onbuttonclick(4);
    });
	$(".div5").click(function(){
		onbuttonclick(5);
    });
	$(".div6").click(function(){
		onbuttonclick(6);
    });
	$(".div7").click(function(){
		onbuttonclick(7);
    });
	$(".div8").click(function(){
		onbuttonclick(8);
    });
	$(".div9").click(function(){
		onbuttonclick(9);
    });
	});
</script>
</head>
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
   <a href="online.php" > <button style="float:left; margin:2%;" class="btn btn-default"><span class="glyphicon glyphicon-backward"> </span> Back</button></a>
    <a href="Logout.php" > <button style="float:right; margin:2%;" class="btn btn-default"> <span class="glyphicon glyphicon-log-out"> </span> Log Out</button></a>
      
</div></nav>
<body style="background:#8DC9F4;">
<div class="container">
<center>
<h1 id="txt"></h1>
<form action="#" method="post">

<div  id="divback" style="background:url(images/bisaat.png); background-repeat:no-repeat; background-size:auto; background-position:center; height:400px; width:360px;">
<div id="tictac-div" class="div1" style="margin-left:0; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div2" style=" background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div3" style=" background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div4" style="margin-top:10px; margin-left:0; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div5" style=" margin-top:10px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div6" style=" margin-top:10px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div7" style=" margin-top:10px;margin-left:0; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div8" style=" margin-top:10px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div9" style=" margin-top:10px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>

 </div>
 <br>
 <span style="font-size:20px;">
 <p id="turntxt" style="color:white;"></p> 
 <input type="radio" id="pl1" name="player" value="1" disabled/> <?php echo $pname; ?>&nbsp;
 <input type="radio" id="pl2" name="player" value="2" disabled/> <?php echo $oppname; ?><br>
</span>
</form>
</div></center>
<!-- The Modal -->
<div id="myModal" style="background:rgba(255,255,255,1); border:2px solid black; padding:20px; color:black; width:30%; height:30%; margin-left:35%; margin-top:10%;" class="modal">

  <!-- Modal content --> 
      <h1 id="plwin"> </h1><br>
  <form action="online.php">  <button type="submit" style="
  <border:1px solid black;" autofocus> Done!</button></form>
</div>
</body>
</html>