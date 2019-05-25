<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);

/*
http://localhost/loyalty/index.html

https://maps.googleapis.com/maps/api/geocode/json?address=Mountain+View&key=AIzaSyCKxPZ-Ykvh1qMHmRUpfdN4PNeEsGFCcjQ
https://maps.googleapis.com/maps/api/geocode/json?address=Toronto&key=AIzaSyCKxPZ-Ykvh1qMHmRUpfdN4PNeEsGFCcjQ

*/

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('ar_constants.php');
require_once('ar_logger.php');
require_once('ar_helper.php');
require_once('ar_inputclass.php');
require_once('ar_datacontroller.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /api
//if ($uri[1] !== 'api') {
if (!in_array("api",$uri)){
    header("HTTP/1.1 404 Not Found");
    exit();
}

// the username is optional
$username = null;
if (isset($uri[2])) {
    $username = $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

//***** GET PARAMS ***/
$objInput = new cGetInput();
$atts = $objInput->getUserInputParams('POST');

// echo 'ReqMethod:' . $requestMethod;
// echo 'username-url:' . $username;
// echo print_r($atts);

$objDataController = new cDataController('GET', 'ere', $atts);
echo $objDataController->processRequest();

// $objDataController = new cDataController($requestMethod, $username, $atts);
// echo $objDataController->processRequest();

//$objHelper->InsertRecord($atts, "");
//echo 'atts:' . print_r($atts);

$objHelper = new cHelper();

$t = $objHelper->geocode('Toronto');
$latitude = $t[0];
$longitude = $t[1];

echo json_encode($objHelper->geocode('Toronto'));
$t = $objHelper->geoTemperature($latitude, $longitude);
$temperature = $t[0];


if ( empty($atts['v_firstname']) )
{
  echo '{
    "code" : 401,
    "message"  : "Decline, Unauthorized",
    "location" : "client settings",
    "form"     : "contact-form"
  }';
}
else {
  echo '{
    "code" : 200,
    "v_firstname" : "'. $atts['v_firstname'] .'",
    "v_lastname" : "'. $atts['v_lastname'] .'",
    "v_email" : "'. $atts['v_email'] .'",
    "v_phone" : "'. $atts['v_phone'] .'",
    "v_city" : "'. $atts['v_city'] .'",
    "v_lat" : "'. $latitude .'",
    "v_long" : "'. $longitude .'",
    "v_temp" : "'. $temperature .'"                          
 }';

}
