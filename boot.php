<?php
#including config file
require_once("configuration.php");
$config = new JConfig();

#Setting instance
$instance = "";
$instArr = explode("/", $_SERVER['PHP_SELF']);

foreach ($instArr as $pretender) {
    $instance = !empty($pretender) ? $pretender : "";

    if (!empty($instance))
        break;
}

if ($instance != "main")
    ini_set("display_errors", 1);

$custom_libraries = "/var/www/$instance/custom_lib";

ini_set('include_path', $custom_libraries); // Set default path to custom library.

include_once("core/dbTools.php");
include_once("core/utils.php");
include_once("classes/locations.class.php");
include_once("classes/user.class.php");

$db = new DBHandler($config->db);
$db->connect();

$locations = new Locations($db);
# Setting JOOMLA application
if (!defined('_JEXEC')) {
    define( '_JEXEC', 1 );
    define( '_VALID_MOS', 1 );
    define('JPATH_BASE', "/var/www/$instance/administrator");
    define( 'DS', DIRECTORY_SEPARATOR );
    require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
    require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

    /* Create the Application */
    $mainframe =& JFactory::getApplication('site');
    $mainframe->initialise();
    JPluginHelper::importPlugin('system');
    $mainframe->triggerEvent('onAfterInitialise');
    
    $userID = JFactory::getUser()->id;
    
    if ($userID == 0)
        if ($_COOKIE['activeProfile'] > 0)
            $userID = $_COOKIE['activeProfile'];
        
    if ($userID > 0) {
        try {
            $user = new User($userID, $db);
            $user->setUser($locations);
            //print_r($user);
        }
        catch (Exception $e) {
            //echo $e->getMessage();
            //echo "no companies";
        }
    }
}
?>
 