<?php

//include_once("/var/www/html/sites/info.php");
//include_once('/var/www/html/creator/lib/mergeData.php');

/* SAMPLE SERVER VARIABLES

        // HTTP_ORIGIN => https://sandbox.brokerlift.net <br />
        // HTTP_X_REQUESTED_WITH => XMLHttpRequest <br />
        // HTTP_REFERER => https://sandbox.brokerlift.net/prasad-test?v=gEljd3kg7z37pvTM5En3Qw==:hPS4Ydun4fBS8QW11bd0sg== <br />
        // SERVER_NAME => sandbox.brokerlift.net <br />
        // SERVER_ADDR => 172.31.9.204 <br />
        // SERVER_PORT => 443 <br />
        // REMOTE_ADDR => 74.15.61.100 <br />
        // REQUEST_URI => /sites/prasad-test/calculations/ar_handler.php <br />
        // SCRIPT_NAME => /sites/prasad-test/calculations/ar_handler.php <br />
        // PHP_SELF => /sites/prasad-test/calculations/ar_handler.php <br />
*/

include_once('ar_constants.php');

class cHelper {

    private $dbhost = DBHOST;
    private $dbuser = DBUSER;
    private $dbpass = DBPASS;
    private $dbname = DBNAME;


    function isAjax() {
       return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    function printservervars()
    {

       while (list($var,$value) = each ($_SERVER)) {
          echo "$var => $value <br />";
       }

       foreach($_POST as $key => $value) {
            echo "POST Key=" . $key . ", Value=" . print_r($value);
        }

        foreach($_GET as $key => $value) {
            echo "GET Key=" . $key . ", Value=" . print_r($value);
        }
    }

    function printinputvars()
    {

       foreach($_POST as $key => $value) {
            echo "POST Key=" . $key . ", Value=" . print_r($value);
        }

        foreach($_GET as $key => $value) {
            echo "GET Key=" . $key . ", Value=" . print_r($value);
        }
    }


    function InsertRowLeadTable($formid, $visitid, $fieldid, $fieldvalue, $question){

        $dbhost = DBHOST;
        $dbuser = DBUSER;
        $dbpass = DBPASS;
        $dbname = DBNAME;

        //$con = mysqli_connect($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']);
        $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        // *** ADD TO LEAD TABLE
        $sql = "INSERT INTO `" . $dbname . "`.`lead` ( `form_id`, `field_id`, `field_value`, `visit_id`, `date_time`,`ip_address`,`question`) VALUES ('" . $formid. "', '" . $fieldid . "', '" . encrypt($fieldvalue) . "', " . $visitid . ", CURRENT_TIMESTAMP,'" . encrypt(getRealIpAddr()) . "','". $question . "')";

        $s_err = mysqli_query($con, $sql);

        mysqli_close($con);

    }

    function InsertRecord($atts, $arrresult=""){

        $dbhost = DBHOST;
        $dbuser = DBUSER;
        $dbpass = DBPASS;
        $dbname = DBNAME;

        //echo 'arrjson:' . print_r($arrresult);

        $minvalue = "0.0";
        if ( is_array($arrresult) && array_key_exists("min",$arrresult) )
            $latitude = $arrresult["latitude"];

        $maxvalue = "0.0";
        if ( is_array($arrresult) && array_key_exists("max",$arrresult) )
            $longitude = $arrresult["longitude"];

        $singlevalue = "0.0";
        if ( is_array($arrresult) && array_key_exists("single",$arrresult) )
            $temperature = $arrresult["temperature"];

        //$con = mysqli_connect($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']);
        $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        // *** ADD TO LEAD TABLE
        $sql = "INSERT INTO `" . $dbname . "`.`tbltest`
        (`firstname`,
        `lastname`,
        `phone`,
        `email`,
        `city`,
        `datecreated`
        )";

        $sql .= " VALUES ('" . $atts['v_firstname']. "'
        , '" . $atts['v_lastname']. "'
        , '" . $atts['v_phone']. "'
        , '" . $atts['v_email']. "'
        , '" . $atts['v_city'] . "'
        ,  CURRENT_TIMESTAMP
        )";

        //echo 'SQL:' . $sql;

        $s_err = mysqli_query($con, $sql);

        if ($s_err != "1")
        {
             echo("SQL Error 1: " . $s_err . ' -' . mysqli_error($con));
        }

        mysqli_close();

    }

    function GetSessionID()
    {

        // $a = session_id();
        // if ($a == '') session_start();
        // if ( ...add check if you want to regenerate and destroy vars on some condition only [recommended :)]...  ) 
        // { session_unset(); //destroys variables
        //    session_destroy() //destroys session;
        // }
        $a='';

        $a = session_id();
        if ($a == '') session_start();
        if (!isset($_SESSION['safety']))
        {
            session_regenerate_id(true);
            $_SESSION['safety'] = true;
        }
        $_SESSION['sessionid'] = session_id();

        return session_id();

    }

    function GetDateInteger()
    {

        $date=new DateTime(); //this returns the current date time
        //$result = $date->format('Y-m-d-H-i-s');
        $result = $date->format('H-i-s');        
        //echo $result;
        //echo "<br>";
        $krr = explode('-',$result);
        //echo "<br>";
        $result = implode("",$krr);
        return $result;        
    }

function CreateGUID() {
        return strtoupper(bin2hex(openssl_random_pseudo_bytes(16)));
    }


    // function write_log()
    // {
        //require_once('ar_logger.php');

    //     // ********************* WRITE LOG
    //     // $log = new cLogger("log.txt");
    //     // $log->setTimestamp("D M d 'y h.i A");
    //     // $log->putLog("Successful Login: ". $clientprofileid);

    //     // //CHECK LOG
    //     // echo 'log:' . $log->getLog();

    // }

}//END CLASS
?>