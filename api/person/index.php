<?php
  $content = '<h2>Contact Info</h2>';
  include('../index.php');

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
 
function get_records_for_person() {
	
}

function post_record_for_person() {

}


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
$requestMethod = $_SERVER["REQUEST_METHOD"];

echo "reached here!";
?>