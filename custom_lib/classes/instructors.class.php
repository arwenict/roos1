<?php

/**
 * @author mpak
 */
class Instructors {
    private $db;
    
    public function __construct($db=null) {
        if ($db != null)
            $this->db = $db;
        else
            throw new Exception("DB connection required.");
    }
    
    
    /**
     * Returns list of instructors. 
     *
     * @param string    $order      Column to order results with.
     * @param direction $direction  ASC for ascending or DESC for descending. DESC by default
     * 
     * @return array associative array containing the results
     *
     */
    public function getListOfInstructors($order="", $direction = "DESC") {
        $sql = " 
            SELECT u.id, u.name, cfvm.value as mobile, email, cfvs.value as skills,cfvp.value as permcov, cfvl.value as locationID 
            FROM b5.pr_users u
            LEFT JOIN b5.pr_community_fields_values cfvm on u.id=cfvm.user_id AND cfvm.field_id=6 
            LEFT JOIN b5.pr_community_fields_values cfvs on u.id=cfvs.user_id AND cfvs.field_id=19 
            LEFT JOIN b5.pr_community_fields_values cfvp on u.id=cfvp.user_id AND cfvp.field_id=21 
            LEFT JOIN b5.pr_community_fields_values cfvl on u.id=cfvl.user_id AND cfvl.field_id=22 
        ";
        
        if (!empty($order)) {
            $sql .= " ORDER BY u.$order $direction";
        }
        
        $instructors = $this->db->getMultiDimensionalArray($sql);
        
        return $instructors;
        
    }
}
?>
