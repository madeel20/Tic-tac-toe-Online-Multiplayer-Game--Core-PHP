<?php 
session_start();
if(isset($_POST['requestid'])){
	$reqid = $_POST['requestid'];
	include "connection.php";
	// Create connection
$conn = new mysqli($server, $username, $password);
$sql = "UPDATE ".$dbname.".`requests` SET `status`=1 WHERE requestid=".$reqid;
if($conn->query($sql) == true){
	$senderid = "";
	$sql = "select * from ".$dbname.".requests where requestid=".$reqid;
	$result = $conn->query($sql);
	if($result->num_rows>0){
	while($row = $result->fetch_assoc()){
		$senderid = $row['senderid'];
	}
	}
	$sql = "DELETE FROM ".$dbname.".`gamesessions` WHERE pl1id=".$_SESSION['Id']." and pl2id=".$senderid;
	$conn->query($sql);
	
	// pl1id is reciever id  and pl2 is senderid
	$sql = "INSERT INTO ".$dbname.".`gamesessions`(`pl1id`, `pl2id`, `box1`, `box2`, `box3`, `box4`, `box5`, `box6`, `box7`, `box8`, `box9`, `pl1scr`, `pl2scr`, `turn`, `count`) VALUES (".$_SESSION['Id'].",".$senderid.",0,0,0,0,0,0,0,0,0,0,0,0,0)";
	$conn->query($sql);
	$sql = "select * from ".$dbname.".gamesessions where pl1id =".$_SESSION['Id']." and pl2id=".$senderid;
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	$_SESSION['gamesessionid'] = $row['sessionid'];	
	}
	$_SESSION['pid'] = $senderid;
	$_SESSION['pltype'] = "rec";
	$_SESSION['boxs'] = array(0,0,0,0,0,0,0,0,0);
	header("Location: game.php");
	exit();	
}
}

?>