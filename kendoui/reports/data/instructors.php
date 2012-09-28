<?php

define( '_JEXEC', 1 );
define( '_VALID_MOS', 1 );
define('JPATH_BASE', '../../../');
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
/* Create the Application */
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
JPluginHelper::importPlugin('system');
$mainframe->triggerEvent('onAfterInitialise');
/* Make sure we are logged in at all. */
if (JFactory::getUser()->id == 0)
   die("You have to be logged in.");



$link = mysql_pconnect($mainframe->getCfg('host'), $mainframe->getCfg('user'), $mainframe->getCfg('password')) or die("Unable To Connect To Database Server");

mysql_select_db($mainframe->getCfg('db')) or die("Unable To Connect To DB");

// add the header line to specify that the content type is JSON
header("Content-type: application/json");

// determine the request type
$verb = $_SERVER["REQUEST_METHOD"];

// handle a GET
if ($verb == "GET") {
       
	$arr = array();
	$rs = mysql_query("SELECT id, name, username, email FROM pr_users LIMIT 0,1000");
	while($obj = mysql_fetch_object($rs)) {
		$arr[] = $obj;
	}
	
	echo "{\"data\":" .json_encode($arr). "}";	
}

// handle a POST
if ($verb == "POST") {
	$location = mysql_real_escape_string($_POST["location"]);
	$HourlyRate = mysql_real_escape_string($_POST["HourlyRate"]);
	$AttendeeNumber= mysql_real_escape_string($_POST["AttendeeNumber"]);
	$AttendeeTarget= mysql_real_escape_string($_POST["AttendeeTarget"]);
	
        $ApprovedByManager=0;
	if(mysql_real_escape_string($_POST["ApprovedByManager"])=="true")
	{	$ApprovedByManager=1 ;}
	else {$ApprovedByManager=0 ;}
		
	$id = mysql_real_escape_string($_POST["id"]);
	
	$rs = mysql_query("UPDATE pr_community_events SET AttendeeNumber= " .$AttendeeNumber .", AttendeeTarget= " .$AttendeeTarget .", HourlyRate = " .$HourlyRate .", ApprovedByManager= " .$ApprovedByManager ." WHERE id = " .$id);

	if ($rs) {
		echo json_encode($rs);
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		echo "Update failed for EmployeeID: " .$id;
	}
}

?>