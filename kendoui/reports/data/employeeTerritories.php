<?php
$employeeID = mysql_real_escape_string($_REQUEST["filter"]["filters"][0]["value"]);

$link = mysql_pconnect("localhost", "root", "root") or die("Unable To Connect To Database Server");
mysql_select_db("northwind") or die("Unable To Connect To Northwind");

// add the header line to specify that the content type is JSON
header("Content-type: application/json"); 

// determine the verb type
$verb = $_SERVER["REQUEST_METHOD"];

if ($verb == "GET") {
	$arr = array();
	$rs = mysql_query("SELECT CONCAT(et.EmployeeID, et.TerritoryID) AS EmployeeTerritoryID, t.TerritoryID, e.EmployeeID, 
					   TRIM(t.TerritoryDescription) AS TerritoryDescription
					   FROM Territories t
					   INNER JOIN EmployeeTerritories et ON t.TerritoryID = et.TerritoryID 
					   INNER JOIN Employees e ON et.EmployeeID = e.EmployeeID
					   WHERE e.EmployeeID = " .$employeeID);
					    
	while($obj = mysql_fetch_object($rs)) {
		$arr[] = $obj;
	}

	echo "{\"data\":" .json_encode($arr). "}";
}

if ($verb == "DELETE") {
	parse_str(file_get_contents('php://input'), $_DELETE);
	$territoryId = mysql_real_escape_string($_DELETE["TerritoryID"]);
	$employeeID = mysql_real_escape_string($_DELETE["EmployeeID"]);
	
	$rs = mysql_query("DELETE FROM EmployeeTerritories WHERE TerritoryID = " .$territoryId ." AND 
					   EmployeeID = " .$employeeID);
	
	if ($rs) {
		echo true;
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		echo false;
	}
}


if ($verb == "PUT") {
	$request_vars = Array();
	parse_str(file_get_contents('php://input'), $request_vars );
	
	$territoryId = mysql_real_escape_string($request_vars["TerritoryID"]);
	$employeeID = mysql_real_escape_string($request_vars["EmployeeID"]);
	
	$sql = "INSERT INTO EmployeeTerritories (EmployeeID, TerritoryID) VALUES (" .$employeeID ."," .$territoryId .")";
	
	$rs = mysql_query($sql);

	if ($rs) {
		echo true;
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		echo false;
	}
}

?>