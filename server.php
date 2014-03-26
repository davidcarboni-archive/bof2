<?php
require_once "lib/nusoap.php";

// This is the web service action:
function alertForCapture($sourceURN, $pncId, $capture) {
        return join(",", array(
            "Source URN: ".$sourceURN,
            "PNC ID: ".$pncId,
            "Capture: ".$capture));
}

// This sets up a SOAP server with a WSDL:
$server = new soap_server();
$server->configureWSDL("AlertWebService", "bof:alert");
$server->register("alertForCapture",
    array("sourceURN" => "xsd:long", "pncId" => "xsd:integer", "capture" => "xsd:string"),
    array("return" => "xsd:string"),
    "bof:AlertWebService",
    "bof:AlertWebService#alertForCapture",
    "rpc",
    "encoded",
    "Receive an alert for a capture match from a remote BOF machine");

// Process the request:
$server->service($HTTP_RAW_POST_DATA);

?>
