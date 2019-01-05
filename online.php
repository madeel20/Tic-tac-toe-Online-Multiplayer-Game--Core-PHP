<?php 
session_start();
if(!(isset($_SESSION['Name']))){
	header("Location: index.php"); /* this redirect user to index page if user is not logged in */
exit();
}
include 'connection.php'; // this file contains $server,$username,$password
// PHP script on challenge
if(isset($_POST['plrid'])){
$id = $_POST['plrid']; // get id of challenged player
$name ="";
$conn = new mysqli($server, $username, $password);
$sql = "SELECT * FROM ".$dbname.".`users` WHERE Id =".$id;
$result = $conn->query($sql);
if($result->num_rows>0){
	while($row = $result->fetch_assoc()){
		$name = $row['username']; // get the name of challenged player
	}
}
$sql = "select * from $dbname.requests";// select requests 
$result = $conn->query($sql);
$i = 0;
if($result->num_rows>0){
	while($row = $result->fetch_assoc()){// check if the request is already sended.
	      if($row['senderid'] == $_SESSION["Id"] && $row['recieverid'] == $id){
			 $i=1;
			 break; 
		  }
	}
}
if($i == 0){// insert request in request table
$sql = "INSERT INTO ".$dbname.".`requests`(`senderid`, `sendername`, `recieverid`, `recievername`, `status`)  VALUES (".$_SESSION['Id'].",'".$_SESSION['Name']."',".$id.",'".$name."',false)";
$conn->query($sql) ;
}
	$sql = "SELECT requestid FROM ".$dbname.".`requests` WHERE senderid=".$_SESSION['Id']." and recieverid=$id";// get the id of request send
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	   $_SESSION['requestid'] = $row['requestid']; // set a session for request id
	   header("Location: challenge.php"); /* Redirect to challenge page */
exit();
}
}

$error = "";
   
// Create connection

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $_SESSION['Name'];?> - TicTacToe</title>
<link href="css/bootstrap.css" rel="stylesheet">
</head>
<body style="background:#646BF4; color:white;">
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
   
    <a href="Logout.php" > <button style="float:right; margin:2%;" class="btn btn-default"> <span class="glyphicon glyphicon-log-out"> </span> Log Out</button></a>
      
</div></nav>
<div class="container text-center" style="text-align:center;">
  
  <h1> online players: </h1>
  <hr>
  <div style="width:80%; margin-left:10%; text-align:center"><div style="width:80%; margin-left:10%; text-align:left;">
      
<span id="onlinepl"> </span>

    
  
  <p> <?php echo $error // display error ?></p>
   </div>
  </div></div>
  
  <div class="text-center" style=" margin-left:20%;width:60%; background:white; color:black;" >
  <h2> Requests </h2>
  <span id="req"> </span>
  </div>
  
  <script>
  function loadreq(){
	  
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("req").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","requests.php?r=1",true);
        xmlhttp.send();
	  
  }
  function loadonlinepl(){
	  
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("onlinepl").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","loadonlinepl.php?r=1",true);
        xmlhttp.send();
	  
  }
  loadreq();
 setInterval("loadreq();",500);
 loadonlinepl();
 setInterval("loadonlinepl();",500
 );
  </script>
  
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.2.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
</body>
</html>