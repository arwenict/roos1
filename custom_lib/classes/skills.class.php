<?php
 
/**
 * @author mpak
 */
class Skills {
    private $db;
    
    public function __construct($db=null) {
        if ($db != null){
            $this->db = $db;
            $this->schema = $this->db->schema;
        }
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
            SELECT * FROM {$this->schema}.skills 
        ";
        
        if (!empty($order)) {
            $sql .= " ORDER BY $order $direction";
        }
        
        $skills = $this->db->getMultiDimensionalArray($sql);

        return $skills;
        
    }
    
    public function getSkillNameByID($id) {
        $sql = " 
            SELECT name FROM {$this->schema}.skills WHERE `skillID` = $id
        ";
        
        $skill = $this->db->getSingleValue($sql);

        return $skill;
        
    }
     

}
?>
