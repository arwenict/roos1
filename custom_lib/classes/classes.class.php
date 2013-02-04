<?php

/**
 * @author mpak
 */
class Classes {
    private $db;
    
    public function __construct($db=null, $user=null) {
        if ($db != null) {
            $this->db = $db;
            $this->user = $user;
            $this->schema = $this->db->schema;
        }
        else
            throw new Exception("DB connection required.");
    }
    
    
    /**
     * Returns list of classes. 
     *
     * @param date      $datefrom    Start search date
     * @param date      $dateto      End search date
     * @param string    $order       Column to order results with.
     * @param direction $direction   ASC for ascending or DESC for descending. DESC by default
     * @param string    $order       Max number of results returned
     * 
     * @return array associative array containing the results
     *
     */
    public function getClassesList($datefrom="", $dateto="", $user=null, $order="StartDate, loc.name, u.Name, AttendeeNumber,ApprovedByManager", $direction = "ASC", $limit=500) {
        $limitStr = "LIMIT 0, $limit";
        
        if(empty($datefrom))
            $datefrom = date("Y-m-d");
        
        if(empty($dateto))
            $dateto = date("Y-m-d");
        
        if (in_array("Group Ex Coordinators", $user->userGroups) || 
                 in_array("Group Ex Managers", $user->userGroups) ) {
            $allowedLocations = "(";
            foreach ($user->locations['studio'] as $location) {
                $allowedLocations .= "{$location['nodeID']},";
            }
            $allowedLocations = rtrim($allowedLocations, ","). ")";
            
            $allowedLocationsSQL = "AND loc.nodeID IN $allowedLocations";
        }
        else
            $allowedLocationsSQL = "";
        
        $sql = " 
            SELECT ce.id, title as ClassName, loc.name as Location, StartDate, MID(TIME(`startdate`),1,5) AS StartTime, EndDate, InstructorID, u.Name as InstructorName, HourlyRate,
                (hour(TIMEDIFF(  `enddate` ,  `startdate` ))*60)  + (Minute(TIMEDIFF(  `enddate` ,  `startdate` )))   AS Minutes, 
                ((hour(TIMEDIFF(  `enddate` ,  `startdate` )))   + (Minute(TIMEDIFF(  `enddate` ,  `startdate` ))/60 ) )* HourlyRate  as TotalPayable, 
                CASE ApprovedByManager WHEN 0 THEN 'false' ELSE 'true' END AS ApprovedByManager, AttendeeNumber, Paid, BankTransactionID, AttendeeTarget 
            FROM {$this->schema}.pr_community_events ce
            INNER JOIN {$this->schema}.pr_users u on ce.InstructorID=u.Id 
            INNER JOIN {$this->schema}.locations loc on ce.location=loc.nodeID
            WHERE published=1 AND parent<>0 AND CatId=5 AND StartDate >='" .  $datefrom   .  "'  AND  StartDate <='" .  $dateto   .  "'
                $allowedLocationsSQL
            ORDER BY $order $direction 
            $limitStr
        ";
        
        $classes = $this->db->getMultiDimensionalArray($sql);

        return $classes;
        
    }
    
    public function getClassesForLocation($start, $end, $locationID) {
        $sql = "
            SELECT id, title, HourlyRate, AttendeeNumber, startdate, enddate, InstructorID FROM `{$this->schema}`.`pr_community_events` 
            WHERE `catid`<>0 AND `parent`<>0 AND `published`=1 AND `location`=$locationID AND `startdate`>='$start' AND `enddate` <= '$end'";

        $classes = $this->db->getMultiDimensionalArray($sql);

        $results = array();
        foreach ($classes as $class) {
            try {
                $instructorName = $this->db->getSingleValue("SELECT `name` FROM {$this->schema}.pr_users WHERE `id`={$class['InstructorID']}"); 
                $instructorName = substr($instructorName, 0, strpos($instructorName, " ")); 
            }
            catch (Exception $e) {
                $instructorName = "";
            }

            $results[] = array(
                "id" => $class['id'],
                "title" => $class["title"],
                "description" => "{$class['title']}<br />Instructor:$instructorName<br />Rate:$"."{$class['HourlyRate']}<br />Attendees:{$class["AttendeeNumber"]}",
                "start" => $class['startdate'],
                "end" => $class['enddate'],
                "allDay" => ""    
            );
        }
        //print_r($results);
        return $results;
    }
     
    public function updateClassesFields($classID, $fields) {
        $updateSQL = "UPDATE {$this->schema}.pr_community_events SET ";
        
        foreach ($fields as $field => $value) {
            $updateSQL .= "`$field`='$value',";
        }
        
        $updateSQL = rtrim($updateSQL, ",");
        $updateSQL .= " WHERE `id`=$classID";
        
        $this->db->update($updateSQL);

        return true;
    }

}
?>
