<?php
/* Including neccessary libraries */
include_once("../boot.php");
include_once("classes/classes.class.php");
include_once("classes/locations.class.php");
include_once("classes/user.class.php");

$locationID = getParameterNumber("location");
$startTime = getParameterString("start");
$endTime = getParameterString("end");

$start = date("Y-m-d", $startTime);
$end = date("Y-m-d", $endTime);

if (count($user->locations['companies']) == 1) {
    foreach ($user->locations['companies'] as $id => $company) {
        $companyID = $id;
    }
}

$allowedLocations = array();
if (in_array("Instructors", $user->userGroups)) {
    foreach ($user->locations['clubs'] as $clubID => $club) {
        $allowedLocations[] = "$clubID";
    }
}
else { 
    if(!in_array("Super User", $user->userGroups))
        $locationsStr = rtrim($locations->getAllChildNodeID($companyID), ", ");
    
    $allowedLocations = explode(", ", $locationsStr);
}
$classes = new Classes($db);

if (in_array($locationID, $allowedLocations)) 
    $events = $classes->getClassesForLocation($start, $end, $locationID);
else
    throw new Exception ("You are trying to access classes you do not have rights to");
/*
$link = mysql_pconnect($mainframe->getCfg('host'), $mainframe->getCfg('user'), $mainframe->getCfg('password')) or die("Unable To Connect To Database Server");


mysql_select_db($mainframe->getCfg('db')) or die("Unable To Connect To DB");

    $loc= $_GET["location"];
       

    $sql = "select * from pr_community_events where catid<>0 and parent<>0 and published=1 and location='" . $loc ."'";


   $res = mysql_query($sql);
    while ($row = mysql_fetch_assoc($res)) {
	    $eventsArray['id'] =  $row['id']; 
	    $sqli="select name from pr_users where id=".$row['InstructorID'];
	    $resi=mysql_query($sqli); 
	    $rowi = mysql_fetch_assoc($resi); 
	    $instname=$rowi['name'];
	    	$pos = strrpos($instname, " ");
		if ($pos > 0) { $instname = substr($instname,0,$pos);};
		
	    $eventsArray['title'] = $row['title']."\n".$instname; 
	    $eventsArray['description'] = $row['title']."<br>Instructor:".$instname."<br>Rate:$".$row['HourlyRate']."<br>Attendees:".$row['AttendeeNumber'];
	    $eventsArray['start'] = $row['startdate'];
	    $eventsArray['end'] = $row['enddate'];
	    
	    $eventsArray['allDay'] = "";
            
            $colcat = "";
switch ($row['location']) {
    case 8:
        $colcat='#BDB76B';
        break;
    case 9:
        $colcat='#4682B4';
        break;
    case 0:
        $colcat='#D8BFD8';
        break;
}

	    $eventsArray['color'] = $colcat; 
	    $events[] = $eventsArray; 
} ;
*/

echo json_encode($events);

?>