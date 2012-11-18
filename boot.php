<?php
$instance = strstr($_SERVER['PHP_SELF'], 'max') ? "max" : "roos1";

if ($instance != "roos1")
    ini_set("display_errors", 1);

$custom_libraries = "/var/www/$instance/custom_lib";

ini_set('include_path', $custom_libraries); // Set default path to custom library.

include_once("core/dbTools.php");

$db = new DBHandler();
$db->connect();
?>
 