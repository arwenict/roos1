<?php


$link = mysql_pconnect("localhost", "arw49555_b4", "@rwen1234") or die("Unable To Connect To Database Server");
mysql_select_db("arw49555_b5") or die("Unable To Connect To DB");

// add the header line to specify that the content type is JSON
header("Content-type: application/json");

// determine the request type
$verb = $_SERVER["REQUEST_METHOD"];

// handle a GET
if ($verb == "GET") {
         $date= mysql_real_escape_string($_GET["date"]);
         if($date=="")
         { $date = date("Y-m-d"); };
        //echo  . htmlspecialchars($_GET["date"]) . '!';
       
	$arr = array();
	$rs = mysql_query("SELECT ce.id, title as ClassName, LocationName as Location, StartDate, EndDate, instructorID, u.Name as InstructorName, HourlyRate,
	                      (hour(TIMEDIFF(  `enddate` ,  `startdate` ))*60)  + (Minute(TIMEDIFF(  `enddate` ,  `startdate` )))   AS Minutes, 
                              ((hour(TIMEDIFF(  `enddate` ,  `startdate` )))   + (Minute(TIMEDIFF(  `enddate` ,  `startdate` ))/60 ) )* HourlyRate  as TotalPayable, 
                              CASE ApprovedByManager WHEN 0 THEN 'false' ELSE 'true' END AS ApprovedByManager, AttendeeNumber, Paid, BankTransactionID FROM pr_community_events
                              ce Inner Join pr_users u on ce.InstructorID=u.Id inner join pr_locations loc
                              on ce.location=loc.locid
                              Where CatId=5 AND StartDate >='" .  $date   .  "'  Order by StartDate, LocationName, u.Name, AttendeeNumber,ApprovedByManager LIMIT 0,80");
	//WHERE ApprovedByManager=0
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
	
        $ApprovedByManager=0;
	if(mysql_real_escape_string($_POST["ApprovedByManager"])=="true")
	{	$ApprovedByManager=1 ;}
	else {$ApprovedByManager=0 ;}
		
	$id = mysql_real_escape_string($_POST["id"]);
	
	$rs = mysql_query("UPDATE pr_community_events SET AttendeeNumber= " .$AttendeeNumber .", HourlyRate = " .$HourlyRate .", ApprovedByManager= " .$ApprovedByManager ." WHERE id = " .$id);

	if ($rs) {
		echo json_encode($rs);
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		echo "Update failed for EmployeeID: " .$id;
	}
}

?>