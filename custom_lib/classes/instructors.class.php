<?php

/**
 * @author mpak
 */
class Instructors {
    private $db;
    private $mappingID = array(
        "mobile" => 6,
        "locations" => 22,
        "skills" => 19
    );
    
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
            SELECT u.id, u.name, cfvm.value as mobile, email, cfvs.value as skills,cfvp.value as permcov, COALESCE(cfvl.value, -1) as locations 
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
     
    /**
     * Updates values for an instructor. 
     *
     * @param integer    $instructorID      id of instructor
     * @param array      $fields            Fields to be updated as [key] => [value] array
     * 
     * @return bool     true on success
     *
     */
    public function updateInstructorFields($instructorID, $fields) {
        $userTableConditionSQL = "";
        
        foreach ($fields as $field => $value) {
            if (empty($value))
                continue;
            
            switch ($field) {

            case "name":
            case "email":
                $userTableConditionSQL .= " `$field`='$value',";
                break;
                
            case "mobile":
            case "locations":
            case "skills":
                
                try {
                    $idSQL = "SELECT `id` FROM b5.pr_community_fields_values WHERE `user_id`=$instructorID AND `field_id`={$this->mappingID[$field]}";
                    $id = $this->db->getSingleValue($idSQL);
                    $this->db->update("UPDATE b5.pr_community_fields_values SET `value` = \"$value\" WHERE `id` = $id");
                }
                catch (Exception $e) {
                    //echo $e->getMessage();
                    $valuesTableSQL = "INSERT INTO b5.pr_community_fields_values (`user_id`, `field_id`, `value`) VALUES ($instructorID, {$this->mappingID[$field]}, \"$value\")";
                    $this->db->insert($valuesTableSQL);
                }
                //echo $valuesTableSQL."\n";
                break;
                
            default:
                break;
            }
        }
        
        if (!empty($userTableConditionSQL)) {
            $userTableConditionSQL = rtrim($userTableConditionSQL, ",");
            $sql = "UPDATE b5.pr_users SET $userTableConditionSQL WHERE `id`=$instructorID";
            $this->db->update($sql);
        }
        
        return true;
        
    }

    /**
     * Searches for instructorID value by full name. 
     *
     * @param string    $name      Full name of instructor
     * 
     * @return  int     instructorID or false on failure
     *
     */
    public function getIDbyName($name) {
        $sql = "SELECT id FROM b5.pr_users WHERE `name` = \"$name\" ";
        
        try {
            return $this->db->getSingleValue($sql);
        }
        catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Searches for instructors name by instructorID. 
     *
     * @param string    $instructorID       ID of the instructor in the database.     
     * 
     * @return  string  $name   instructors full name
     *
     */
    public function getNameByID($id) {
        $sql = "SELECT name FROM b5.pr_users WHERE `id` = $id ";
        
        try {
            return $this->db->getSingleValue($sql);
        }
        catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Returns instructor's details by instructorID.
     *
     * @param   int     $id      InstructorID
     * 
     * @return  array   $result[0]  Array with instructor's details
     *
     */
    public function getDetailsByInstructorID($id) {
        #mapping of community_fields table 
        $fields = array (
            "Mobile number" => 6,
            "Address" => 8,
            "Suburb" => 10,
            "State" => 9,
            "Hourly rate" => 20,
            "ABN" => 17,
            "GST" => 18,
            "permOrCover" => 21,
            "Locations" => 22,
            "Skillset" => 19
        );
        
        $sql = "
            SELECT `field_id`, `value` 
            FROM `pr_community_fields_values`
            WHERE `user_id` = $id 
        ";
        
        try {
            $resultArr = $this->db->getMultiDimensionalArray($sql);
            
            $detailsArr = array();
            foreach ($resultArr as $value) {
                $detailsArr[$value['field_id']] = $value['value'];
            }

            $userDetails = array();
            $userDetails['Full name'] = $this->getNameByID($id);
            foreach ($fields as $key => $fieldID) {
                if(isset($detailsArr[$fieldID]))
                    $userDetails[$key] = $detailsArr[$fieldID];
                else
                    $userDetails[$key] = "";
            }
            
            return $userDetails;
        }
        catch (Exception $e) {
            return false;
        }
        
    }
}
?>
