<?php 
session_start();
include "connection.php";
?><table class="table-bordered table-hover table-responsive" style="font-size:20px; text-align:center; background:white; color:black; width:100%"> <tr><th style="text-align:center"> Id</th><th style="text-align:center"> Player Name</th><th>  </th></tr>
      <?php 
	  $error = "";
	  $conn = new mysqli($server, $username, $password);
// Check connection
$sql = "select * from ".$dbname.".online";
$result = $conn->query($sql);// this loads online users on page load
	  if($result->num_rows > 0){
	  while($row = $result->fetch_assoc()) {
		  if(!( $_SESSION['Id'] == $row['plrid'] &&  $_SESSION['Name'] == $row['plrname'] ) ){
			echo "<tr><td>". $row['plrid'] . "</td><td>". $row['plrname'] . "</td>" ;
			echo '<td> <form action="online.php" method="post"> <input type="submit" value="Challenge"><input type="hidden" name="ans" value="1"/> <input type="hidden" name="plrid" value="'.$row["plrid"].'"/> </form></td></tr>';
		  }
	  }}
	  else {
		  $error = "No user is Online!"; // set error of no user online
	  }
	  ?>
      
       </table>