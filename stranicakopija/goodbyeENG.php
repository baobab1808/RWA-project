<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: loginENG.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Goodbye</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center;
			  background-image: url('Haus.jpg');
			  background-size: cover;}
		.button {
  display: inline-block;
  padding: 15px 25px;
  font-size: 24px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: white;
  background-color: #ff7733;
  border: none;
  border-radius: 15px;
  box-shadow: 0 9px #999;
}

.button:hover {background-color: #ffbb99}

.button:active {
  background-color: #e64d00;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
    </style>
</head>
<body>
   <center> <div  style="background:rgba(255,255,255,0.4); background-size:100px; width:800px; text-align:center; border-radius:25px" >
        <h1>Hello, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Thanks for doing business with us.</h1>
    </div></center>
    <center><div style="margin-top: 150px; background:rgba(255,255,255,0.4); height:350px; width:300px; border-radius:25px;">
		<br>
		<img src="user.png" style="height:100px; width:100px;">
		<br><br>
        <a href="reset.php" class="btn btn-warning">Reset your password</a>
		<br><br>
        <a href="logout.php" class="btn btn-danger">Logout</a>
		<br/><br/>
		<form>
			<input type="button" class="button" value="Back!" onclick="history.back()">
		</form>
	</div></center>
</body>
</html>

