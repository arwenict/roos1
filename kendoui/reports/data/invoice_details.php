<?php
$link = mysql_pconnect("localhost", "root", "root") or die("Could not connect");
mysql_select_db("northwind") or die("Could not select database");

$arr = array();
$employeeId = $_REQUEST["EmployeeID"];
$approved = $_REQUEST["Approved"];

$rs = mysql_query("SELECT ce.id, title as ClassName, Location, StartDate, EndDate, HourlyRate,
	                      AtendeeNumber, Paid, BankTransactionID FROM pr_community_events
                              ce Inner Join pr_users u on ce.InstructorID=u.Id 
				   WHERE ce.InstructorID = " .$employeeId ." and ApprovedByManager = " .$approved
				   . " ORDER BY StartDate");
 
while($obj = mysql_fetch_object($rs)) {
	$arr[] = $obj;
}

header("Content-type: application/json"); 
echo "{\"data\":" .json_encode($arr). "}";

?>