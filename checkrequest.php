<?php
session_start();
include 'connection.php';
$conn = new mysqli($server, $username, $password);
if(isset($_GET['requestid'])){
  $requestid = $_GET['requestid'];// get request id from ajax
   

if($conn->connect_error){
	die($conn->connect_error);
}
$sql = "SELECT * FROM ".$dbname.".`requests` WHERE  requestid=".$requestid;
$result = $conn->query($sql);
if($result->num_rows>0){
	while($row = $result->fetch_assoc()){
		if($row['status'] == 1){
			$recieverid = $row['recieverid'];
	$sql = "select * from ".$dbname.".gamesessions where pl1id =".$recieverid." and pl2id=".$_SESSION['Id'];
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	$_SESSION['gamesessionid'] = $row['sessionid'];	
	}
			$_SESSION['pid'] = $recieverid;
	$_SESSION['pltype'] = "sender";
	$_SESSION['boxs'] = array(0,0,0,0,0,0,0,0,0);
			echo "true";
			break;
		}		
	}
}
}
else 
echo "false";
	  
?>