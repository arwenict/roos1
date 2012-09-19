<?php

 define( '_JEXEC', 1 );
define( '_VALID_MOS', 1 );
define('JPATH_BASE', '../../../../../');
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
/* Create the Application */
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
/* Make sure we are logged in at all. */
if (JFactory::getUser()->id == 0)
   die("You have to be logged in.");



$link = mysql_pconnect("localhost", "arw49555_b4", "@rwen1234") or die("Unable To Connect To Database Server");
mysql_select_db("arw49555_b5") or die("Unable To Connect To DB");

// add the header line to specify that the content type is JSON
header("Content-type: application/json");

// determine the request type
$verb = $_SERVER["REQUEST_METHOD"];

// handle a GET
if ($verb == "GET") {
	$arr = array();
	$rs = mysql_query("SELECT Concat(u.Name , ApprovedByManager) as Id, u.Id as InstructorID,  u.Name as InstructorName, Count(ce.id) as NumberOfClasses, ApprovedByManager,
	                      SUM(hour(TIMEDIFF(  `enddate` ,  `startdate` ))  + (Minute(TIMEDIFF(  `enddate` ,  `startdate` ))/60 ) )  AS TotalHours, 
                              SUM((hour(TIMEDIFF(  `enddate` ,  `startdate` ))   + (Minute(TIMEDIFF(  `enddate` ,  `startdate` ))/60 ) )* HourlyRate) as TotalPayable
                              FROM pr_community_events
                              ce Inner Join pr_users u on ce.InstructorID=u.Id GRoup by  Concat(u.Name , ApprovedByManager),u.Id, u.Name, ApprovedByManager
                              AND published=1 AND parent<>0");
	
	while($obj = mysql_fetch_object($rs)) {
		$arr[] = $obj;
	}
	
	echo "{\"data\":" .json_encode($arr). "}";	
}

// handle a POST
if ($verb == "POST") {
	$location = mysql_real_escape_string($_POST["location"]);
	$HourlyRate = mysql_real_escape_string($_POST["HourlyRate"]);
	$AtendeeNumber= mysql_real_escape_string($_POST["AtendeeNumber"]);
	$ApprovedByManager= mysql_real_escape_string($_POST["ApprovedByManager"]);
	
	$id = mysql_real_escape_string($_POST["id"]);
	
	$rs = mysql_query("UPDATE pr_community_events SET AtendeeNumber= " .$AtendeeNumber .", HourlyRate = " .$HourlyRate .", ApprovedByManager= " .$ApprovedByManager ." WHERE id = " .$id);

	if ($rs) {
		echo json_encode($rs);
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		echo "Update failed for EmployeeID: " .$id;
	}
}

?>