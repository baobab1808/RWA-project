<?php
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


    $sql_query = $link->prepare("DELETE FROM poruke WHERE ID_poruke = ?");
    $sql_query->bind_param('i', $_GET["ID_poruke"]);
    $sql_query->execute();
    $result = $sql_query->get_result();
    $sql_query->close();
    header('Location: poruke.php');
?>
