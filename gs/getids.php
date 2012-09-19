<?php
// load Zend Gdata libraries
require_once './Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

// set credentials for ClientLogin authentication
$user = "caeschli@gmail.com";
$pass = "Quantum01";
try {  
  // connect to API
  $service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
  $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
  $service = new Zend_Gdata_Spreadsheets($client);

  // get list of available spreadsheets
  $feed = $service->getSpreadsheetFeed();
} catch (Exception $e) {
  die('ERROR: ' . $e->getMessage());
}
foreach($feed->entries as $entry) {
    $spreadsheetURL = $entry->id;
}
$spreadsheetKey = basename($spreadsheetURL);
$query = new Zend_Gdata_Spreadsheets_DocumentQuery();
$query->setSpreadsheetKey($spreadsheetKey);
$feed = $service->getWorksheetFeed($query);
echo "Spreadsheet Key: <strong>$spreadsheetKey</strong> <br>";
foreach($feed as $entry) {
    $sName = $entry->title->text;
    echo "ID of sheet $sName is: <strong>".basename($entry->id)."</strong><br>";
}
?>