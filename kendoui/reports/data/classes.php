<?php 
/* Including neccessary libraries */
include_once("../../../boot.php");
include_once("classes/classes.class.php");
include_once("classes/instructors.class.php");

$classes = new Classes($db);
$instructors = new Instructors($db);

// add the header line to specify that the content type is JSON
header("Content-type: application/json");

// determine the request type
$verb = $_SERVER["REQUEST_METHOD"];

// handle a GET
if ($verb == "GET") {
        $datefrom= $db->escape($_GET["datefrom"]);
        $dateto = $db->escape($_GET["dateto"]);
        $classesArr = $classes->getClassesList($datefrom, $dateto, $user);
        
        $results = array();
        foreach ($classesArr as $class) {
            $results[] = $class;
        }
	echo "{\"data\":" .json_encode($results). "}";	
}

// handle a POST
if ($verb == "POST") {
        $instructorID = $instructors->getIDbyName($db->escape($_POST['InstructorName']));
    
        if ($instructorID) {
            $id = $db->escape($_POST["id"]);
            $updateFields['InstructorID'] = $instructorID;
            $updateFields['HourlyRate'] = $db->escape($_POST["HourlyRate"]);
            $updateFields['AttendeeNumber'] = $db->escape($_POST["AttendeeNumber"]);
            $updateFields['AttendeeTarget'] = $db->escape($_POST["AttendeeTarget"]);
            if($_POST["ApprovedByManager"]=="true")
                $updateFields['ApprovedByManager'] = 1;
            else
                $updateFields['ApprovedByManager'] = 0;

            $result = $classes->updateClassesFields($id, $updateFields);

            echo json_encode("success");
        }
        else {
            echo "Invalid instructor. Save failed.";
        }

}

$db->close();
