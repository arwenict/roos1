<?php

/**
 * @author mpak
 */
class Classes {
    private $db;
    
    public function __construct($db=null) {
        if ($db != null)
            $this->db = $db;
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
    public function getClassesList($datefrom="", $dateto="", $order="StartDate, LocationName,  AttendeeNumber,ApprovedByManager", $direction = "ASC", $limit=500) {
        $limitStr = "LIMIT 0, $limit";
        
        if(empty($datefrom))
            $datefrom = date("Y-m-d");
        
        if(empty($dateto))
            $dateto = date("Y-m-d"); 
        
        $sql = " 
            SELECT ce.id, title as ClassName, LocationName as Location, StartDate, MID(TIME(`startdate`),1,5) AS StartTime, EndDate, InstructorID, HourlyRate,
                (hour(TIMEDIFF(  `enddate` ,  `startdate` ))*60)  + (Minute(TIMEDIFF(  `enddate` ,  `startdate` )))   AS Minutes, 
                ((hour(TIMEDIFF(  `enddate` ,  `startdate` )))   + (Minute(TIMEDIFF(  `enddate` ,  `startdate` ))/60 ) )* HourlyRate  as TotalPayable, 
                CASE ApprovedByManager WHEN 0 THEN 'false' ELSE 'true' END AS ApprovedByManager, AttendeeNumber, Paid, BankTransactionID, AttendeeTarget 
            FROM b5.pr_community_events ce
            INNER JOIN b5.pr_locations loc on ce.location=loc.locid
            WHERE published=1 AND parent<>0 AND CatId=5 AND StartDate >='" .  $datefrom   .  "'  AND  StartDate <='" .  $dateto   .  "' 
            ORDER BY $order $direction 
            $limitStr
        ";
        
        $classes = $this->db->getMultiDimensionalArray($sql);

        return $classes;
        
    }
     
    public function updateClassesFields($classID, $fields) {
        $updateSQL = "UPDATE b5.pr_community_events SET ";
        
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
