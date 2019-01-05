<?php 
session_start();
if(isset($_GET['b'])){
	include 'connection.php';
$conn = new MySQLi($server,$username,$password);
	$sql = "select * from ".$dbname.".gamesessions where sessionid=".$_SESSION['gamesessionid'] ;
$result = $conn->query($sql);
$val =0;
$box = $_GET['b'] ;
while($row = $result->fetch_assoc()){
	$p1id = $row['pl1id'];
	$p2id = $row['pl2id'];
	$bx = $row['box'.$box];
	$pid = $_SESSION['Id'];
	if($pid ==  $p1id)
	$val = 1;
	else if($pid == $p2id)
	$val =2;
}
if($bx == 0){
	$box = $_GET['b'] ;
$sql = "UPDATE ".$dbname.".`gamesessions` SET `box".$box."`=".$val." , count = count+1 WHERE sessionid=".$_SESSION['gamesessionid'];
if($conn->query($sql) == true){
	echo "record inserted!";
}
}
else {
	 echo $conn->error;
}	
	}


?>