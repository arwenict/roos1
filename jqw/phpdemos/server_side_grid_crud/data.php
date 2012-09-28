<?php
#Include the connect.php file
include('connect.php');
#Connect to the database
//connection String
$connect = mysql_connect($hostname, $username, $password)
or die('Could not connect: ' . mysql_error());
//Select The database
$bool = mysql_select_db($database, $connect);
if ($bool === False){
   print "can't find $database";
}
// get data and store in a json array
$query = "SELECT * FROM kezov_users";

if (isset($_GET['insert']))
{
	// INSERT COMMAND 
	$insert_query = "INSERT INTO `kezov_users`(`name`, `username`, `email`) VALUES ('".$_GET['name']."','".$_GET['username']."','".$_GET['email']."')";
	
   $result = mysql_query($insert_query) or die("SQL Error 1: " . mysql_error());
   echo $result;
}
else if (isset($_GET['update']))
{
	// UPDATE COMMAND 
	$update_query = "UPDATE `kezov_users` SET `name`='".$_GET['name']."',
	`name`='".$_GET['name']."',
	`username`='".$_GET['username']."',
	`email`='".$_GET['email']."' WHERE `id`='".$_GET['id']."'";
	 $result = mysql_query($update_query) or die("SQL Error 1: " . mysql_error());
     echo $result;
}
else if (isset($_GET['delete']))
{
	// DELETE COMMAND 
	$delete_query = "DELETE FROM `kezov_users` WHERE `id`='".$_GET['id']."'";	
	$result = mysql_query($delete_query) or die("SQL Error 1: " . mysql_error());
    echo $result;
}
else
{
    // SELECT COMMAND
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$users[] = array(
			'id' => $row['id'],
			'name' => $row['name'],
			'username' => $row['username'],
			'email' => $row['email']
		  );
	}
	 
	echo json_encode($users);
}
?>