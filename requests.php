<?php 
session_start();
if(isset($_GET['r'])){
	// Create connection
	include "connection.php";
$conn = new mysqli($server, $username, $password);
$sql = "select * from ".$dbname.".requests";
$result = $conn->query($sql);
echo '<table class="table-bordered table-hover table-responsive" style="font-size:20px; text-align:center; width:100%"> <tr > <th style="text-align:center"> ID </th><th style="text-align:center"> Name</th><th style="text-align:center"></th>';
if($result->num_rows>0){
while ($row = $result->fetch_assoc()){
	if($_SESSION['Id'] == $row['recieverid']){
		echo "<tr>";
		echo "<td>".$row['senderid']."</td>";
		echo "<td>".$row['sendername']."</td>";
		echo "<td>".'<form action="recieve.php" method="post"><input type="hidden" name="requestid" value="'.$row['requestid'].'"> <input type="submit" value="Accept"></form>'."</td>";
		echo "</tr>";	
	}
}
}
echo "</table>";
// this loads online users on page load
	
}
?>