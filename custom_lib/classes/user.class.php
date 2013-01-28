<?php
 
/**
 * @author mpak
 */
class User {
    private $db;
    public $userID;
    public $locations;
    public $userGroups;
    
    public function __construct($userID = 0, $db=null) {
        if ($userID > 0 && $db != null){
            $this->db = $db;
            $this->dbSchema = $this->db->schema;
            $this->userID = $userID;
        }
        else
            throw new Exception("Paramters missing.");
    }
    
    public function setUser($locationsClass=null) {
        if ($locationsClass != null) {
            $this->locations = $this->getUserLocations($locationsClass);
            $this->userGroups = $this->getUserGroups();
        }
        else
            throw new Exception("One or more parameters are missing.");
    }
    
    /**
     * Returns list of user groups. 
     *
     * @param integer    $userID      ID of user
     * 
     * @return array associative array containing the results
     *
     */
    private function getUserGroups() {
        $sql = "
            SELECT g.title 
            FROM `{$this->dbSchema}`.`pr_user_usergroup_map` um
            LEFT JOIN `{$this->dbSchema}`.`pr_usergroups` g ON g.id=um.group_id
            WHERE user_id = $this->userID
        ";

        $tmp = $this->db->getMultiDimensionalArray($sql);
        $groups = array();
        foreach ($tmp as $rec) {
            $groups[] = $rec['title'];
        }

        return $groups;
    }
    
    /**
     * Returns companyID of a company current user is entitled to. 
     *
     * @param integer    $userID      ID of user
     * 
     * @return array associative array containing the results
     *
     */
    private function getUserLocations($locationsClass) {
        
        # Retrieving user's locations ids
        $sql = "
            SELECT value 
            FROM  `{$this->dbSchema}`.`pr_community_fields_values` 
            WHERE user_id = $this->userID
            AND field_id = 22
        ";

        $userLocations = $this->db->getSingleValue($sql);
        $locationsArr = explode(",", $userLocations);

        # Parsing locations ids and building a tree of permitted locaitons
        $locations = array();
        foreach ($locationsArr as $location) {
            $tree = $locationsClass->buildTreeFromNodeID($location);
            
            # Extracting list of different location types and merging arrays 
            $types = array_keys($tree);
            foreach ($types as $type) {
                foreach ($tree[$type] as $node) {
                    $locations[$type][$node['nodeID']] = $node;
                }
            }
        }
        //error_log("Locations are ".print_r($locations,true)."\n");
        return $locations;
    }
    
    
}
?>
