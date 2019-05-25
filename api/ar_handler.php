<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);

/*
http://localhost/loyalty/index.html

*/
require_once('ar_constants.php');
require_once('ar_logger.php');
require_once('ar_helper.php');
require_once('ar_inputclass.php');


$v_firstname = $_POST["FirstName"];
$v_lastname = $_POST["LastName"];
$v_email = $_POST["Email"];
$v_phone = $_POST["Phone"];
$v_city = $_POST["City"];


//***** GET PARAMS ***/
$objInput = new cGetInput();
$objHelper = new cHelper();

$atts = $objInput->getUserInputParams('POST');
$objHelper->InsertRecord($atts, "");
//echo 'atts:' . print_r($atts);

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
    "v_firstname" : "'. $atts['v_firstname'] .'",
    "v_lastname" : "'. $atts['v_lastname'] .'",
    "v_email" : "'. $atts['v_email'] .'",
    "v_phone" : "'. $atts['v_phone'] .'",
    "v_city" : "'. $atts['v_city'] .'"                      
 }';
}

?>