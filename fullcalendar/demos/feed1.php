<?php

include_once("dbconfig.php");
include_once("functions.php");

    $loc= $_GET["location"];
         
    $db = new DBConnection();
    $db->getConnection();
    $sql = "select * from pr_community_events where catid<>0 and parent<>0 and published=1 and location='" . $loc ."'";
   // if($loc!="")
   // {
   //  $sql = $sql . " and location='" . $loc ."'";
   // }
   //echo $sql;
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