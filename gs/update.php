<!DOCTYPE html 
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Importing worksheet cells from a database</title>
    <style>
    body {
      font-family: Verdana;
    }
    </style>    
  </head>
  <body>
    <?php
    // load Zend Gdata libraries
    require_once './Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

    // set credentials for ClientLogin authentication
    $user = "caeschli@gmail.com";
    $pass = "Quantum01";

    // create PDO connection
    $dbh = new PDO('mysql:host=localhost;dbname=arw49555_b5', 'arw49555_b4', '@rwen1234');
    $sql = 'SELECT * FROM pr_community_events WHERE 1';

    try {
      // connect to API
      $service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
      $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
      $service = new Zend_Gdata_Spreadsheets($client);

      // set target spreadsheet and worksheet
      $ssKey = 'ts-5gsU9JdRxzEf3Xa6ObXQ';
      $wsKey = 'od6';

      // get results from database
      // insert header row
      $rowCount = 1;
      $result = $dbh->query($sql, PDO::FETCH_ASSOC);
      for ($x=0; $x<$result->columnCount(); $x++) {
        $col = $result->getColumnMeta($x);
          $service->updateCell($rowCount, ($x+1), $col['name'], $ssKey, $wsKey);
      }
      $rowCount++;
      // insert each field of each row as a spreadsheet cell
      // if large result set, increase PHP script execution time
      foreach($result as $row) {
        $colCount=1;
        foreach ($row as $k=>$v) {        
          $service->updateCell($rowCount, $colCount, $v, $ssKey, $wsKey);
          $colCount++;
        }
        $rowCount++;
      }

    } catch (Exception $e) {
      die('ERROR: ' . $e->getMessage());
    }
    ?>
  </body>
<html>