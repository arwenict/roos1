<?php
 
/**
 * @author mpak
 */
class Locations {
    private $db;
    
    public function __construct($db=null) {
        if ($db != null){
            $this->db = $db;
            $this->schema = $this->db->schema;
        }
        else
            throw new Exception("DB connection required.");
    }
    
    public function getAllStudios($inclCompany=false, $user=null) {
        $studios = array();
        $sql = "SELECT * FROM {$this->schema}.locations WHERE `type`='studio'";
        
        $studiosArr = $this->db->getMultiDimensionalArray($sql);
        
        foreach ($studiosArr as $studio) {
            if ($user != null) {
                $companyArr = $this->walkUpCompanyFromNode($studio['nodeID']);
                $companyID = current($companyArr);
                if (empty($user->locations['company'][$companyID])) 
                    continue;
            }
            
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
    
    public function getAllLocations($inclCompany=false, $user=null) {
        # ini_set("display_errors", 1);
        $studios = array();
        $sql = "SELECT * FROM {$this->schema}.locations WHERE `type`='location'";
        
        $studiosArr = $this->db->getMultiDimensionalArray($sql);

        foreach ($studiosArr as $studio) {
            if ($user != null) {
                $companyArr = $this->walkUpCompanyFromNode($studio['nodeID']);
                $companyID = current($companyArr);
                if (empty($user->locations['company'][$companyID])) 
                    continue;
            }
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
        $result = $this->db->getResults("SELECT * FROM {$this->schema}.locations WHERE nodeID='$nodeID'");
        if($result->num_rows == 1) {
            $ret = $result->fetch_assoc();
            $result->free();
            return $ret;
        } else {
            throw new Exception("Get Node Info: node [$nodeID] does not exist");
        }
        return false;
    }
    
    public function walkUpTreeFromNode($nodeID) {
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
    
    public function walkDownTreeFromNode($nodeID) {
        $outputArray = array();
        $childrenNodes = $this->getAllChildNodeID($nodeID);
        $childrenArray = explode(",", $childrenNodes);
        $count = 0;
        while (!empty($childrenNodes)) {
            foreach ($childrenArray as $child) {
                if (!empty($child)) {
                    $count++;
                    if($count>=20){
                        //error_log (print_r($outputArray,true));
                        throw new Exception("Walk up the tree too far, walked up $count levels, max 20");
                    }
                    $childrenNodes = $this->getAllChildNodeID($child);
                    $outputArray[$child] = $this->getNodeInfoAsArray($child);
                }
            }
        }
        
        return $outputArray;
    }
    
    public function walkUpCompanyFromNode($nodeID) {
        $outputArray = array();
        $currentNode = $this->getNodeInfoAsArray($nodeID);
        $outputArray[$currentNode['nodeID']] = $currentNode;
        $count=0;
        while($currentNode['parentID'] != 0 ) {
            $count++;
            if($count>=16)
                throw new Exception("Walk up the tree too far, walked up $count levels, max 16");
            $currentNode = $this->getNodeInfoAsArray($currentNode['parentID']);
        }
        return $currentNode;
    }
    
    function getStudioCode($nodeID) {
        $sql = "SELECT * FROM {$this->schema}.locations WHERE `type`='studio' AND `nodeID`=$nodeID";
        
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
    
    public function getCompaniesFromLocations($locations, $return = "array") {
        $locationsArr = explode(",", $locations);
        
        foreach ($locationsArr as $location) {
            $companyInfo = $this->walkUpCompanyFromNode($location);
            $companies[$companyInfo['nodeID']] = $companyInfo;
        }
        
        if ($return == "str") {
            $companiesStr = "";
            foreach ($companies as $companyID => $info) {
                $companiesStr .= "$companyID,";
            }
            $companiesStr = rtrim($companiesStr, ",");
            
            return $companiesStr;
        }
        else
            return $companies;
    }
    
    public function getAllChildNodeID($nodeID) {
        $sql = "SELECT nodeID FROM {$this->schema}.locations WHERE parentID='$nodeID'";

        $ids="";
        $ids_array = $this->db->getSingleValueArray($sql);
        
        if (!empty($ids_array)) {
            foreach ($ids_array as $id) {
                $ids .= "$id,";
                $x = $this->getAllChildNodeID((int)$id);
                $ids .= $x;
            }
        }

        return $ids;
        //print_r($ids_array);
    }
    
    public function buildTreeFromNodeID($nodeID) {
        $treeArray = array();
        $upperNodes = $this->walkUpTreeFromNode($nodeID);
        $lowerNodes = $this->walkDownTreeFromNode($nodeID);
        
        foreach ($upperNodes as $node) {
            $treeArray[$node['type']][$node['nodeID']] = $node;
        }
        
        foreach ($lowerNodes as $node) {
            $treeArray[$node['type']][$node['nodeID']] = $node;
        }
        
        return $treeArray;
    }
}
?>
