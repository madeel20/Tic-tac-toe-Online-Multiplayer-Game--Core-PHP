<?php 
session_start();
if(isset($_GET['r'])){
include 'connection.php';
$ret ="";
$conn = new MySQLi($server,$username,$password);
	$sql = "select * from ".$dbname.".gamesessions where sessionid=".$_SESSION['gamesessionid'];
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$count = $row['count'] ;
	$boxs = array(0,$row['box1'],$row['box2'],$row['box3'],$row['box4'],$row['box5'],$row['box6'],$row['box7'],$row['box8'],$row['box9']);
	if($boxs[1] == 1 && $boxs[2] == 1 && $boxs[3] == 1 ||
               $boxs[4] == 1 && $boxs[5] == 1 && $boxs[6] == 1 ||
               $boxs[7] == 1 && $boxs[8] == 1 && $boxs[9] == 1 ||

               $boxs[1] == 1 && $boxs[4] == 1 && $boxs[7] == 1 ||
               $boxs[2] == 1 && $boxs[5] == 1 && $boxs[8] == 1 ||
               $boxs[3] == 1 && $boxs[6] == 1 && $boxs[9] == 1 ||

               $boxs[1] == 1 && $boxs[5] == 1 && $boxs[9] == 1 ||
               $boxs[3] == 1 && $boxs[5] == 1 && $boxs[7] == 1)
            {
                $ret = "pl1";
				echo $ret;
               
			   
            }
            else if($boxs[1] == 2 && $boxs[2] == 2 && $boxs[3] == 2 ||
               $boxs[4] == 2 && $boxs[5] == 2 && $boxs[6] == 2 ||
               $boxs[7] == 2 && $boxs[8] == 2 && $boxs[9] == 2 ||

               $boxs[1] == 2 && $boxs[4] == 2 && $boxs[7] == 2 ||
               $boxs[2] == 2 && $boxs[5] == 2 && $boxs[8] == 2 ||
               $boxs[3] == 2 && $boxs[6] == 2 && $boxs[9] == 2 ||

               $boxs[1] == 2 && $boxs[5] == 2 && $boxs[9] == 2 ||
               $boxs[3] == 2 && $boxs[5] == 2 && $boxs[7] == 2)
                {  
                 $ret = "pl2";
				 echo $ret;
                }
				else if($count == 9){
					$ret = "draw";
					echo $ret;
				}	
	}
	if($ret == ""){
$conn = new MySQLi($server,$username,$password);
$sql = "select * from ".$dbname.".gamesessions where sessionid=".$_SESSION['gamesessionid'] ;
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	
	$pl1id= $row['pl1id'];
	$pl2id= $row['pl2id'];
	$pl1scr = $row['pl1scr'];
	$pl2scr = $row['pl2scr'];
	$count = $row['count'];
	$turn = $row['turn'];
	$boxs = array($row['box1'],$row['box2'],$row['box3'],$row['box4'],$row['box5'],$row['box6'],$row['box7'],$row['box8'],$row['box9']);
	for($i=0; $i<9; $i++){
    if($_SESSION['boxs'][$i] != $boxs[$i]){
		
		$_SESSION['boxs'][$i] = $boxs[$i];
		echo $i+1;
	}}
}
}

}
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


if(isset($_GET['t'])){
	include 'connection.php';
$conn = new MySQLi($server,$username,$password);
	$sql = "select * from ".$dbname.".gamesessions where sessionid=".$_SESSION['gamesessionid'] ;
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	$turn = $row['turn'];
	if($turn == 0){
	$sql = "UPDATE ".$dbname.".`gamesessions` SET `turn`=1 WHERE sessionid=".$_SESSION['gamesessionid'];
	$conn->query($sql);
	}
	else if($turn == 1){
	$sql = "UPDATE ".$dbname.".`gamesessions` SET `turn`=0 WHERE sessionid=".$_SESSION['gamesessionid'];
	$conn->query($sql);
	}
	}
	
	$sql = "select * from ".$dbname.".gamesessions where sessionid=".$_SESSION['gamesessionid'] ;
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	echo $row['turn'];
	}
}
?>