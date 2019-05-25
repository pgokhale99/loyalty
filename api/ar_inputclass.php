<?php


include_once('ar_constants.php');

class cGetInput {

    private $dbhost = DBHOST;
    private $dbuser = DBUSER;
    private $dbpass = DBPASS;
    private $dbname = DBNAME;

	function __construct() {

		//		$this->clientpage_id = $_SESSION[$GLOBALS['visit_id']]['clientpage_id'];
		//	    $this->clientprofile_id =  $_SESSION[$GLOBALS['visit_id']]['clientprofile_id'];
	}

	function sanitize_text_field($input, $inputtype)
	{

	  $var = "";
	  if($inputtype=="POST")
		$var = !empty($_POST[$input]) ? $_POST[$input] : '' ;
	  elseif ($inputtype=="DB")
	  	$var = "DB"; //$var = cGetInput::GetData($customerRecord, $input);
	  else
	  	$var = "OTHER"; //$var = cGetInput::autorater_get_option($input, $configfilename);	

	  return $var;
	}

	function autorater_get_option($reqvalue, $filename = null)
	{
		if ($filename == null || $filename == "")
			$filename = "config.ini";

	    $dataini = parse_ini_file($filename);
	    //$license_id = autorater_get_option( 'ar_licenseid' );
	    $tmp =  "". $dataini[$reqvalue];
	    $GLOBALS[$reqvalue] = $tmp;
	    return $tmp;
	}

	function getUserInputParams($inputtype)
	{	

	    $ar_firstname    = cGetInput::sanitize_text_field('FirstName', $inputtype);
	    $ar_lastname     = cGetInput::sanitize_text_field('LastName', $inputtype);
	    $ar_phone        = cGetInput::sanitize_text_field('Phone', $inputtype);
	    $ar_email        = cGetInput::sanitize_text_field('Email', $inputtype);
	    $ar_city         = cGetInput::sanitize_text_field('City', $inputtype);	  

	    $arr_userinput = Array(
	        'v_firstname'     => $ar_firstname,
	        'v_lastname'      => $ar_lastname,
	        'v_email'         => $ar_email,
	        'v_phone'         => $ar_phone,
	        'v_city'          => $ar_city	        		        
	    );

	    return $arr_userinput;    

	}


}//END CLASS
?>
