<!DOCTYPE HTML>
<?php
include "../re_used_file/check_session.php";
include "../re_used_file/header.php";
include "../re_used_file/menu.php";
include "../re_used_file/config.php"; //load in any variables
include "../re_used_file/clean_input.php";; //load in any variables
//checkUser();
//loginStatus(); 
?>
<html><head><title>View Room</title> </head>
 <body>

<?php

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}

//do some simple validation to check if id exists
$id = $_GET['id'];
if (empty($id) or !is_numeric($id)) {
 echo "<h2>Invalid Room ID</h2>"; //simple error feedback
 exit;
} 

//prepare a query and send it to the server
//NOTE for simplicity purposes ONLY we are not using prepared queries
//make sure you ALWAYS use prepared queries when creating custom SQL like below
$query = 'SELECT * FROM room WHERE roomid='.$id;
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result); 
?>
<h1>Room Details View</h1>
<h2><a href='listrooms.php'>[Return to the Room listing]</a><a href='index.php'>[Return to the main page]</a></h2>

<?php
//makes sure we have the Room
if($rowcount > 0)
{  
   echo "<fieldset><legend>Room detail #$id</legend><dl>"; 
   $row = mysqli_fetch_assoc($result);
   echo "<dt>Room name:</dt><dd>".$row['roomname']."</dd>".PHP_EOL;
   echo "<dt>Description:</dt><dd>".$row['description']."</dd>".PHP_EOL;
   echo "<dt>Room type:</dt><dd>".$row['roomtype']."</dd>".PHP_EOL;
   echo "<dt>Sleeps:</dt><dd>".$row['beds']."</dd>".PHP_EOL; 
   echo '</dl></fieldset>'.PHP_EOL;  
}
else
{
	echo "<h2>No Room found!</h2>"; //suitable feedback
}
mysqli_free_result($result); //free any memory used by the query
mysqli_close($db_connection); //close the connection once done
?>
</table>
</body>
</html>
  