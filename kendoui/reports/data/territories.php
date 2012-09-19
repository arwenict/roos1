<?php
$link = mysql_pconnect("localhost", "root", "root") or die("Could not connect");
mysql_select_db("northwind") or die("Could not select database");

$arr = array();
$employeeId = $_REQUEST["EmployeeID"];

$rs = mysql_query("SELECT t.TerritoryID, TRIM(t.TerritoryDescription) AS TerritoryDescription 
				   FROM EmployeeTerritories et
				   INNER JOIN Territories t ON et.TerritoryID = t.TerritoryID
				   WHERE et.EmployeeID != " .$employeeId
				   . " ORDER BY t.TerritoryDescription ASC");
 
while($obj = mysql_fetch_object($rs)) {
	$arr[] = $obj;
}

header("Content-type: application/json"); 
echo "{\"data\":" .json_encode($arr). "}";

?>