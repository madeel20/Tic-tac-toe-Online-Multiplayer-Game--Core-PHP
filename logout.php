<?php
session_start();
include 'connection.php';
$conn = new mysqli($server, $username, $password);
// Check connection
if ($conn->connect_error) {
	$error = "Connection failed: " . $conn->connect_error;
} 
$sql = "DELETE FROM  ".$dbname.".`requests` WHERE senderid=".$_SESSION['Id'];
$conn->query($sql);
$sql = "DELETE FROM ".$dbname.".`online` WHERE plrid=".$_SESSION['Id'];
$conn->query($sql);
if($conn->query($sql) == true){
	session_unset();
header("Location: index.php"); /* Redirect browser */
exit();
session_destroy();
}

?>
