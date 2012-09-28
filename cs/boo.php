<?php

// Configure connection settings

$db = 'arw49555_b5';
$db_admin = 'arw49555_b4';
$db_password = '@rwen1234';
$tablename = 'pr_community_events';

// Title

echo "Contents of the table:";

// Connect to DB

$sql = mysql_connect("localhost", $db_admin, $db_password)
or die(mysql_error());

mysql_select_db("$db", $sql);

// Fetch the data
$datefrom=date('Y-m-d H:i', strtotime('today'));
$dateto=date('Y-m-d H:i', strtotime('now'));

$query = "SELECT * FROM $tablename WHERE startdate >= '". $datefrom . "' AND startdate <= '". $dateto . "'";


$result = mysql_query($query);

// Return the results, loop through them and echo

while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
echo "<b>AttendeeNumber:</b> {$row['AttendeeNumber']}" .
"<b>When:</b> {$row['startdate']}" . "<b>title:</b> {$row['title']}<br>";
}

?>
