<?php 
session_start();
if(!(isset($_SESSION['requestid']))){
	header("Location: online.php"); /* if requestid is not set then redirect it to online.php */
exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $_SESSION['Name'];?> -Online Test</title>
<!-- Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="jQueryAssets/jquery.ui-1.10.4.button.min.js" type="text/javascript"></script>
<link href="css/bootstrap.css" rel="stylesheet">
</head>
<body style="background:#646BF4; color:white;">
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
   <a href="online.php" > <button style="float:left; margin:2%;" class="btn btn-default"><span class="glyphicon glyphicon-backward"> </span> Back</button></a>
    <a href="Logout.php" > <button style="float:right; margin:2%;" class="btn btn-default"> <span class="glyphicon glyphicon-log-out"> </span> Log Out</button></a>
      
</div></nav>

<div class="container text-center" style="text-align:center;">
  
  <h1> Waiting For Your Opponent To Accept Your Challenge... </h1>
  <hr>
  <div style="width:80%; margin-left:10%; text-align:center"><div style="width:80%; margin-left:10%; text-align:left;">
 <script>
 var id = <?php echo $_SESSION['requestid'] ?>; 
 function check(){ // this function send requestid to checkrequest.php page to check if the request is accepted or not
	 if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
				if(this.responseText == "true"){
					document.getElementById("txt").innerHTML = "<center><h2> Accepted!</h2></center>";
				deleterequest();	
				window.location = "game.php";	
				}
            }
        };
        xmlhttp.open("GET","checkrequest.php?requestid="+id,true);
        xmlhttp.send();
		}
		function deleterequest(){ // this function send requestid to checkrequest.php page to check if the request is accepted or not
	 if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txt").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","requestaccepted.php?requestid="+id,true);
        xmlhttp.send();
		}
		
 check();
setInterval("check();",600);
//}5000;
</script><span id="txt"> </span><span id="txt1"> </span>
   </div>
  </div></div>

</body>
</html>
