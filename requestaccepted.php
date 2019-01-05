<?php 
if(isset($_GET['requestid'])){
  $requestid = $_GET['requestid'];// get request id from ajax
   include 'connection.php';
$conn = new mysqli($server, $username, $password);
if($conn->connect_error){
	die($conn->connect_error);
}
$sql = "DELETE FROM ".$dbname.".`requests` WHERE requestid=".$requestid;
if($conn->query($sql) == true){
	unset($_SESSION['requestid']);
	echo "true";
}
}


?>
