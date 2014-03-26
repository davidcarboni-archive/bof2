<?php
require_once "lib/nusoap.php";
//$client = new nusoap_client("http://localhost/anpr/server.php");
$client = new nusoap_client("http://localhost/server.php");
 
$error = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}

// http://stackoverflow.com/questions/6459171/how-to-set-default-value-to-a-string-in-php-if-another-string-is-empty
// For a 64-bit system, intval should work, but worth checking to be sure:
$sourceURN = $_GET["sourceURN"] ? intval($_GET["sourceURN"]) : 1234567890;
$pncId = $_GET["pncId"] ? intval($_GET["pncId"]) : 5;
// Just some fake data to represent a capture - this is not in the correct format!
$capture = $_GET["capture"] ?: "001010011001001010101010100101";
 
$result = $client->call("alertForCapture", array("sourceURN" => $sourceURN, "pncId" => $pncId, "capture" => $capture));
 
if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Capture</h2><pre>";
        echo $result;
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

?>

