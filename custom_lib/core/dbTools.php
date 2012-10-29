<?php 

/**
 * Attempts to connect to a database, and if successful stores the connection in a variable.
 * @param mysqli $retVar The mysqli object to set, if any.
 * @param string $dbHost The hostname of the database.
 * @param string $user The account username.
 * @param string $pass The account password.
 * @param string $schema (optional) The default schema to set for this connection.
 * @param string $errorDescriptor (optional) The word to use in connection errors to describe this DB server.
 * @return bool True on connection success, false otherwise. 
 */
function tryConnect(&$retVar, $dbHost, $user, $pass, $schema="", $errorDescriptor ="the")
{
    $retVar = @new mysqli($dbHost,$user,$pass,$schema);
    
    if($retVar == null || mysqli_connect_errno() > 0) {
        error_log("DBTools - Can't connect to $errorDescriptor MySQL server $dbHost. Error msg: ".mysqli_connect_error());
        error_log("DBTools - $user, $pass, $dbHost");
        $retVar = null;
        return false;
    } else return true;
}

class DBHandler
{
    /**
     * @var mysqli the database object
     */
    private $mysqli;
        
    /**
     * @var string DB host server
     */
    private $host="localhost";   
    
    
    public $total_rows=0;
    
    private $_mysqli_last = null; // pointer to the last mysql object used to run a query - holds error message.
    
    /**
     * Construct a DBTool object
     * 
     * @param boolean $singleServerMode  Select whether a writable DB connection should also connect to a different Read Only server
     */
    public function __construct()
    {
            //Constructor
    }
    
    /**
     *
     * @param boolean $writeable if false will allow read only access to database
     * @param string $account choose a different account to access the DB (autoencoder,livestream,dvbcapture,stats,austar,dropbox,etc...)
     * @param string $host the database host to use, defaults to 10.2.1.223 which is macsvdb1.switch.internal
     *
     * @throws Exception on database connection fail
     */
    function connect($account="root",$host="") {	
        if($account=="root") {
            $user = "arw49555_b5";
            $pass = "f1shb0ard";
            $schema = 'rooster';
        }
            
        if(strlen($this->host)>0) {

            if(tryConnect($this->mysqli, $host, $user, $pass, $schema, "specific")) 
                return;
            else
                throw new Exception("Can't connect to DB Server {$this->host}. Error msg: ". mysqli_connect_error());
        }
        else
            throw new Exception("No DB host specified");
    
        return;
    }
    
    /**
     * A generic SQL query wrapper function to centralise logging.
     * @param string $sql the SQL query to be run. Please make sure this query has been sanitised!
     * @param bool $readOnly Whether to use the read-only DB connection handle.
     * @return object A mysqli results object.
     */
    function doQuery($sql) {
        
        $result = $this->mysqli->query($sql);
        $this->_mysqli_last=$this->mysqli;
        
        return $result;
    }
    
    
    /**
     * Runs a query and returns a multiples row as an multidimensional associative array.
     *
     * @param string $sql the SQL query to be run. Please make sure this query has been sanitised!
     * @param Booleam $calcRows Flag to determine whether the total rows should be calculate for queries with a SQL_CAL_FOUND_ROWS and LIMIT clause
     * @return array associative array containing the results
     *
     */
    function getMultiDimensionalArray($sql,$calcRows=false) {		
        $data = array();
        if($result = $this->doQuery($sql))
        {

                $data = self::convertResultsToHashtable($result);
                if($calcRows)
                {
                        $rows = $this->doQuery("SELECT FOUND_ROWS() AS 'found_rows';");
                        $rows = $rows->fetch_assoc();
                        $this->total_rows = $rows['found_rows'];
                }
                $result->close();
        }
        else
                throw( new Exception("Query failed! $sql ".$this->_mysqli_last->error));

        return $data;
    }
    
    function getResults($sql, $calcRows=false) {
        if($result = $this->doQuery($sql)) {
            if($calcRows) {
                $rows = $this->doQuery("SELECT FOUND_ROWS() AS 'found_rows';",true);
                $rows = $rows->fetch_assoc();
                $this->total_rows = $rows['found_rows'];
            }

            return $result;
        }
        else
            throw( new Exception("Query failed! $sql ".$this->_mysqli_last->error));
    }
    
    /**
     * Closes the mysqli connection
     */
    function close() {
        $this->mysqli->close();
    }
        
    /**
     * Takes a mysqli results object and iterates over it to convert it into a hash table
     * @param mysqli_result $results
     * @return array array containing results
     */
    function convertResultsToHashtable($results)  {
        $hash = array();
        $count = $results->num_rows;
        for($i=0;$i<$count;$i++)  {
             $hash[] = $results->fetch_assoc();
		}
        return $hash;
    }
}
?>