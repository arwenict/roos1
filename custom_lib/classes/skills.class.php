<?php

/**
 * @author mpak
 */
class Skills {
    private $db;
    
    public function __construct($db=null) {
        if ($db != null)
            $this->db = $db;
        else
            throw new Exception("DB connection required.");
    }
    
    
    /**
     * Returns list of skills. 
     *
     * @param string    $order      Column to order results with.
     * @param direction $direction  ASC for ascending or DESC for descending. DESC by default
     * 
     * @return array associative array containing the results
     *
     */
    public function getSkillsList($order="", $direction = "DESC") {
        $sql = " 
            SELECT * FROM rooster.skills 
        ";
        
        if (!empty($order)) {
            $sql .= " ORDER BY $order $direction";
        }
        
        $skills = $this->db->getMultiDimensionalArray($sql);

        return $skills;
        
    }
     

}
?>