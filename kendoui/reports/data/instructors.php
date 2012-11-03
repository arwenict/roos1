<?php

define( '_JEXEC', 1 );
define( '_VALID_MOS', 1 );
define('JPATH_BASE', '../../../');
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

ini_set("display_errors", 1); //displaying errors. Should be removed on production
ini_set('include_path', '/var/www/roos1/custom_lib/'); // Set default path to custom library.

/* Including neccessary libraries */
include_once("core/dbTools.php");
include_once("classes/locations.class.php");
include_once("classes/instructors.class.php");

/* Inititalising objects */
$db = new DBHandler();
$db->connect();

$locations = new Locations($db);
$instructors = new Instructors($db);

/* Create the Application */
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
JPluginHelper::importPlugin('system');
$mainframe->triggerEvent('onAfterInitialise');
/* Make sure we are logged in at all. */
if (JFactory::getUser()->id == 0)
   die("You have to be logged in.");

// add the header line to specify that the content type is JSON
header("Content-type: application/json");

// determine the request type
$verb = $_SERVER["REQUEST_METHOD"];

// handle a GET
if ($verb == "GET") {
        $instructorsArr = $instructors->getListOfInstructors("name", "ASC");

        $i=0;
        $results = array();
        foreach ($instructorsArr as $instructor) {
            $results[$i] = $instructor;
            if (!empty($instructor['locationID'])){
                $locationCode = $locations->getStudioCode($instructor['locationID']);
                $results[$i]['locations'] = $locationCode;
            }
            $i++;
        }

	echo "{\"data\":" .json_encode($results). "}";	
}

// handle a POST
if ($verb == "POST") {
	$name = mysql_real_escape_string($_POST["name"]);
	$mobile = mysql_real_escape_string($_POST["mobile"]);

//$username = mysql_real_escape_string($_POST["username"]);
	$email = mysql_real_escape_string($_POST["email"]);
	$id = mysql_real_escape_string($_POST["id"]);

	$rs = mysql_query("UPDATE pr_users SET name= '" .$name ."',email= '".$email."' WHERE id = " .$id);
	$rs = mysql_query("UPDATE pr_community_fields_values SET value= '" .$mobile."' WHERE field_id=6 AND user_id = " .$id);
//	$rs = mysql_query("UPDATE pr_community_fields_values SET value= '" .$mobile."' WHERE field_id=6 AND user_id = " .$id);


	if ($rs) {
		echo json_encode($rs);
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		echo "Update failed for ID: " .$id;
	}
	

}

/*
$link = mysql_pconnect($mainframe->getCfg('host'), $mainframe->getCfg('user'), $mainframe->getCfg('password')) or die("Unable To Connect To Database Server");

mysql_select_db($mainframe->getCfg('db')) or die("Unable To Connect To DB");

// add the header line to specify that the content type is JSON
header("Content-type: application/json");

// determine the request type
$verb = $_SERVER["REQUEST_METHOD"];

// handle a GET
if ($verb == "GET") {
       
	$arr = array();
	$rs = mysql_query("
        SELECT u.id, u.name, cfvm.value as mobile, email, cfvs.value as skills,cfvp.value as permcov, rosl.`name` as locations 
        FROM pr_users u
        LEFT JOIN pr_community_fields_values cfvm on u.id=cfvm.user_id AND cfvm.field_id=6 
        LEFT JOIN pr_community_fields_values cfvs on u.id=cfvs.user_id AND cfvs.field_id=19 
        LEFT JOIN pr_community_fields_values cfvp on u.id=cfvp.user_id AND cfvp.field_id=21 
        LEFT JOIN pr_community_fields_values cfvl on u.id=cfvl.user_id AND cfvl.field_id=22 
        LEFT JOIN rooster.locations rosl on cfvl.value = rosl.nodeID
        ORDER BY u.name        
        ");
	while($obj = mysql_fetch_object($rs)) {
		$arr[] = $obj;
	}
	
	echo "{\"data\":" .json_encode($arr). "}";	
}

// handle a POST
if ($verb == "POST") {
	$name = mysql_real_escape_string($_POST["name"]);
	$mobile = mysql_real_escape_string($_POST["mobile"]);

//$username = mysql_real_escape_string($_POST["username"]);
	$email = mysql_real_escape_string($_POST["email"]);
	$id = mysql_real_escape_string($_POST["id"]);

	$rs = mysql_query("UPDATE pr_users SET name= '" .$name ."',email= '".$email."' WHERE id = " .$id);
	$rs = mysql_query("UPDATE pr_community_fields_values SET value= '" .$mobile."' WHERE field_id=6 AND user_id = " .$id);
//	$rs = mysql_query("UPDATE pr_community_fields_values SET value= '" .$mobile."' WHERE field_id=6 AND user_id = " .$id);


	if ($rs) {
		echo json_encode($rs);
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		echo "Update failed for ID: " .$id;
	}
	

}
*/

$db->close(); // Closing DB connection
?>
