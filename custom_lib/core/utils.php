<?php

    function ar_out($arr) {
        print_r($arr);
        echo "\n<br />";
    }

    function out($m) {
        echo $m."\n<br />";
    }
    
    /**
    * Gets the specified HTTP Parameter string, SQL escaping it if the DB object is passed and also converting non standard quote characters if need too.
    *
    * @param string $param HTTP Parameter to get
    * @param string $default The default value to return if that parameter isn't defined
    * @param dbTools $db the DB object used to escape SQL characters - use this if the parameters value is passed through to SQL
    * @param boolean $convertQuotes whether to convert quotes to standard ascii values - eg ' and "
    * @return string The HTTP parameter value after processing
    */
    function getParameterString($param, $default = "", $db = null, $convertQuotes = false) {
       if (isset($_REQUEST[$param]))
           if ($db != null)
               if ($convertQuotes) {
                   return $db->escape(convertSpecialQuotes($_REQUEST[$param]));
               }
               else
                   return $db->escape($_REQUEST[$param]);
           else
               return $_REQUEST[$param];
       else
       if ($db != null)
           return $db->escape($default);
       else
           return $default;
    }

    function getParameterNumber($param, $default = 0) {

       if (isset($_REQUEST[$param])) {
           $tmp = trim($_REQUEST[$param]);
           if (is_numeric($tmp))
               return $tmp;
       }

       return $default;
    }
?>
