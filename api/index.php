<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);

/*
http://localhost/loyalty/index.html

https://maps.googleapis.com/maps/api/geocode/json?address=Mountain+View&key=AIzaSyCKxPZ-Ykvh1qMHmRUpfdN4PNeEsGFCcjQ
https://maps.googleapis.com/maps/api/geocode/json?address=Toronto&key=AIzaSyCKxPZ-Ykvh1qMHmRUpfdN4PNeEsGFCcjQ

*/

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('ar_constants.php');
require_once('ar_logger.php');
require_once('ar_helper.php');
require_once('ar_inputclass.php');
require_once('ar_datacontroller.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );


function receiveRequest($uri) {
  // all of our endpoints start with /api
  //if ($uri[1] !== 'api') {
  if (!in_array("api",$uri)){
      header("HTTP/1.1 403 Not Found");
      exit();
  }


  $requestMethod = $_SERVER["REQUEST_METHOD"];

  //***** GET PARAMS ***/
  $objInput = new cGetInput();
  $atts = $objInput->getUserInputParams('POST');

  // echo 'ReqMethod:' . $requestMethod;
  // echo 'username-url:' . $username;
  // echo print_r($atts);

  //if (empty($username))

  // the username is optional/from URI
  // $username = null;
  // if (isset($uri[2])) {
  //     $username = $uri[2];
  // }

  $username = $_GET['FirstName']; //for GET request, POST is derived from $atts
  if ( ($requestMethod == 'POST') || ( ($requestMethod == 'GET')  && !empty($username) ) )
  {
    $objDataController = new cDataController($requestMethod, $username, $atts);
    $objDataController->processRequest();
  }

  // $ar_user_postal    = !empty($ar_postal) ? $ar_postal : $ar_user_postal;

  //$objDataController = new cDataController('GET', 'ere', $atts);
  //$objDataController->processRequest();

  if ( !empty($atts['v_city']) )
  {
      //Get lat, long, temperature
      $objHelper = new cHelper();
      $t = $objHelper->geocode($atts['v_city']);
      $latitude = $t[0];
      $longitude = $t[1];

      //echo json_encode($ob$requestMethodjHelper->geocode('Toronto'));
      $t = $objHelper->geoTemperature($latitude, $longitude);
      $temperature = $t[0];
  }

  if ( empty($atts['v_firstname']) && empty($username) )
  {
    echo '{
      "code" : 401,
      "message"  : "Decline, Unauthorized",
      "location" : "client settings",
      "form"     : "contact-form"
    }';
  }
  elseif ($requestMethod == 'POST') {
    echo '{
      "code" : 200,
      "v_firstname" : "'. $atts['v_firstname'] .'",
      "v_lastname" : "'. $atts['v_lastname'] .'",
      "v_email" : "'.  $atts['v_email'] .'",
      "v_phone" : "'. $atts['v_phone'] .'",
      "v_city" : "'. $atts['v_city'] .'",
      "v_lat" : "'. $latitude .'",
      "v_long" : "'. $longitude .'",
      "v_temp" : "'. $temperature .'"                          
   }';

  }
} 

receiveRequest($uri);
?>