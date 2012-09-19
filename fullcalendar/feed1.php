<?php

define( '_JEXEC', 1 );
define( '_VALID_MOS', 1 );
define('JPATH_BASE', '../');
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

    $loc= $_GET["location"];
       

    $sql = "select * from pr_community_events where catid<>0 and parent<>0 and published=1 and location='" . $loc ."'";


   $res = mysql_query($sql);
    while ($row = mysql_fetch_assoc($res)) {
	    $eventsArray['id'] =  $row['id']; 
	    $sqli="select name from pr_users where id=".$row['InstructorID'];
	    $resi=mysql_query($sqli); 
	    $rowi = mysql_fetch_assoc($resi); 
	    $instname=$rowi[name];
	    	$pos = strrpos($instname, " ");
		if ($pos > 0) { $instname = substr($instname,0,$pos);};
		
	    $eventsArray['title'] = $row['title']."\n".$instname; 
	    $eventsArray['description'] = $row['title']."<br>Instructor:".$instname."<br>Rate:$".$row['HourlyRate']."<br>Attendees:".$row['AttendeeNumber'];
	    $eventsArray['start'] = $row['startdate'];
	    $eventsArray['end'] = $row['enddate'];
	    
	    $eventsArray['allDay'] = "";
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

 echo json_encode($events);

?>