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

$db = new DBHandler($config->db);
$db->connect();
?>
 