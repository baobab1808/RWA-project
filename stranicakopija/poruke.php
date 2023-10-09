<?php
session_start();

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'korisnici');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

/*$host    = "localhost";
$user    = "username_here";
$pass    = "password_here";
$db_name = "database_name_here";*/

//get results from database
$message = '<center><h1 style="color:#333;font-weight:bold;" >PORUKE</h1></center>';
echo $message;


$result = mysqli_query($link,"SELECT * FROM poruke");
$all_property = array();  //declare an array for saving property

//showing property
echo '<table class="data-table" >
        <tr class="data-heading" id="HEADING">';  //initialize table tag
while ($property = mysqli_fetch_field($result)) {
    echo '<td>' . $property->name . '</td>';  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}
echo '<td>'.'</td>';
echo '<td>'.'</td>';
echo '</tr>'; //end tr tag

//showing all data
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    foreach ($all_property as $item) {
        echo '<td>' . $row[$item] . '</td>'; //get items using property value
    }
	echo "<td><a href='delete.php?ID_poruke=".$row["ID_poruke"]."'>Delete</a></td>";
    echo "<td><a href='https://mail.google.com/mail/u/1/#inbox?compose=new'>Odgovori</a></td>";
    echo "</tr>";
}
echo "</table>";
?>

<!DOCTYPE html>
<html>
<head>
<style>


table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

#HEADING {
  background-color: #00CCFF;
  color: white;
}

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
<body style="background-image:url('pozadina3.jpg'); background-size:cover;">
<br/>
	<center><form>
		<input type="button" class="button" value="Natrag!" onclick="history.back()">
	</form></center>
</body>
</html>