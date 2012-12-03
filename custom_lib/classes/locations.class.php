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
    
    public function getAllStudios($inclCompany=false) {
        $studios = array();
        $sql = "SELECT * FROM rooster.locations WHERE `type`='studio'";
        
        $studiosArr = $this->db->getMultiDimensionalArray($sql);
        
        foreach ($studiosArr as $studio) {
            $resultArray = $studio;
            $tree = $this->walkUpTreeFromNode($studio['nodeID']);
            
            $code = "";
            foreach ($tree as $node) {
                if ($node['parentID'] != 0 || $inclCompany)
                    $code = "{$node['code']}-".$code;  
            }
            $code = trim($code, "-");
           
            $resultArray['displayCode'] = $code;
            
            $studios[$resultArray['nodeID']] = $resultArray;
        }
        
        return $studios;
    }
    
    public function getAllLocations($inclCompany=false) {
        $studios = array();
        $sql = "SELECT * FROM rooster.locations WHERE `type`='location'";
        
        $studiosArr = $this->db->getMultiDimensionalArray($sql);
        
        foreach ($studiosArr as $studio) {
            $resultArray = $studio;
            $tree = $this->walkUpTreeFromNode($studio['nodeID']);
            
            $code = "";
            foreach ($tree as $node) {
                if ($node['parentID'] != 0 || $inclCompany)
                    $code = "{$node['code']}-".$code;  
            }
            $code = trim($code, "-");
           
            $resultArray['displayCode'] = $code;
            
            $studios[$resultArray['nodeID']] = $resultArray;
        }
        
        return $studios;
    }
    
    public function getNodeInfoAsArray($nodeID) {
        $result = $this->db->getResults("SELECT * FROM b5.locations WHERE nodeID='$nodeID'");
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
        while($currentNode['parentID'] != 0 ) {
            $count++;
            if($count>=16)
                throw new Exception("Walk up the tree too far, walked up $count levels, max 16");
            $currentNode = $this->getNodeInfoAsArray($currentNode['parentID']);
            $outputArray[$currentNode['nodeID']] = $currentNode;
        }
        return $outputArray;
    }
    
    function getStudioCode($nodeID) {
        $sql = "SELECT * FROM b5.locations WHERE `type`='studio' AND `nodeID`=$nodeID";
        
        $studio = $this->db->getSingleRowAssoc($sql);
        
        $tree = $this->walkUpTreeFromNode($studio['nodeID']);
            
        $code = "";
        foreach ($tree as $node) {
            if ($node['parentID'] != 0 )
                $code = "{$node['code']}-".$code;  
        }
        $code = trim($code, "-");

        return $code;

    }
    
    public function getLocationNameByID($locationID) {
        $tree = $this->walkUpTreeFromNode($locationID);
            
        $code = "";
        foreach ($tree as $node) {
            if ($node['parentID'] != 0)
                $code = "{$node['code']}-".$code;  
        }
        $code = trim($code, "-");
        
        return $code;
    }
}
?>
