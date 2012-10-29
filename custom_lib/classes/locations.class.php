<?php

/**
 * @author mpak
 */
class Locations {
    private $db;
    
    public function __construct($db=null) {
        if ($db != null)
            $this->db = $db;
        else
            throw new Exception("DB connection required.");
    }
    
    public function getAllStudios() {
        $sql = "SELECT * FROM rooster.locations WHERE `type`='studio'";
        
        $studios = $this->db->getMultiDimensionalArray($sql);
        
        foreach ($studios as $studio) {
            $result = $this->walkUpTreeFromNode($studio['nodeID']);
            print_r($result);
        }
    }
    
    public function getNodeInfoAsArray($nodeID) {
        $result = $this->db->getResults("SELECT * FROM rooster.locations WHERE nodeID='$nodeID'");
        if($result->num_rows == 1) {
            $ret = $result->fetch_assoc();
            $result->free();
            return $ret;
        } else {
            throw new Exception("Get Node Info: node does not exist");
        }
        return false;
    }
    
    function walkUpTreeFromNode($nodeID) {
        $outputArray = array();
        $currentNode = $this->getNodeInfoAsArray($nodeID);
        $outputArray[$currentNode['nodeID']] = $currentNode;
        $count=0;
        while($currentNode['parentID'] != null ) {
            $count++;
            if($count>=16)
                throw new Exception("Walk up the tree too far, walked up $count levels, max 16");
            $currentNode = $this->getNodeInfoAsArray($currentNode['parentID']);
            $outputArray[$currentNode['nodeID']] = $currentNode;
        }
        return $outputArray;
    }
}
?>
