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

function geodata($city)
{

  if ( !empty($city) )
  {
      //Get lat, long, temperature
      $objHelper = new cHelper();
      $t = $objHelper->geocode($city);
      $latitude = $t[0];
      $longitude = $t[1];

      return array($latitude, $longitude);
  }

  return array();

}


function geotemperature($lat, $long)
{

  if ( !empty($lat) && !empty($long) )
  {
      $objHelper = new cHelper();
      $t = $objHelper->geoTemperature($lat, $long);
      $temperature = $t[0];
      return $temperature;
  }

  return "";

}


function receiveRequest($uri, $requestMethod, $username) {
  $response = "";
  // all of our endpoints start with /api
  //if ($uri[1] !== 'api') {
  if (!in_array("api",$uri)){
      header("HTTP/1.1 200 Not Found");
      $response = '{
      "code" : 404,
      "message"  : "Not Found"
    }';
      //echo 'hello';
      echo $response;
      return;
  }


  //***** GET PARAMS ***/
  $objInput = new cGetInput();
  $atts = $objInput->getUserInputParams('POST');
  // the username is optional/from URI
  // $username = null;
  // if (isset($uri[2])) {
  //     $username = $uri[2];
  // }

  //$username = $_GET['FirstName']; //for GET request, POST is derived from $atts
  if ( ($requestMethod == 'POST') || ( ($requestMethod == 'GET')  && !empty($username) ) )
  {
    $objDataController = new cDataController($requestMethod, $username, $atts);
    $result = $objDataController->processRequest();
    //echo $result;
  }

  if ( !empty($atts['v_city']) )
  {

      $t = geodata($atts['v_city']);
      $latitude = $t[0];
      $longitude = $t[1];

      $temperature = geoTemperature($latitude, $longitude);

      // //Get lat, long, temperature
      // $objHelper = new cHelper();
      // $t = $objHelper->geocode($atts['v_city']);
      // $latitude = $t[0];
      // $longitude = $t[1];

      // $t = $objHelper->geoTemperature($latitude, $longitude);
      // $temperature = $t[0];
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

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );


$requestMethod = $_SERVER["REQUEST_METHOD"];
$username = $_GET['FirstName'];

$response = receiveRequest($uri, $requestMethod, $username);

?>