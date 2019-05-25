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

//https://weather.cit.api.here.com/weather/1.0/report.json?product=observation&latitude=52.516&longitude=13.389&oneobservation=true&app_id=D5exNs3PTzRoiQMSZCMl&app_code=BTtstViIGClKv3diMc9_-g

function geoTemperature($lat, $long)
{

/*

$url = "https://weather.cit.api.here.com/weather/1.0/report.json?product=observation&latitude=52.516&longitude=13.389&oneobservation=true&app_id=D5exNs3PTzRoiQMSZCMl&app_code=BTtstViIGClKv3diMc9_-g";


example call: geoTemperature('52.516', '13.389');

Array ( [observations] => 
    Array ( [location] => 
        Array ( [0] =>
            Array ( [observation] => 
                Array ( [0] => 
                    Array ( [daylight] => N [description] => Passing clouds. Cool. [skyInfo] => 7 [skyDescription] => Passing clouds [temperature] => 10.00 [temperatureDesc] => Cool [comfort] => 8.18 [highTemperature] => 19.90 [lowTemperature] => 9.70 [humidity] => 76 [dewPoint] => 6.00 [precipitation1H] => * [precipitation3H] => * [precipitation6H] => * [precipitation12H] => * [precipitation24H] => * [precipitationDesc] => [airInfo] => * [airDescription] => [windSpeed] => 12.97 [windDirection] => 260 [windDesc] => West [windDescShort] => W [barometerPressure] => 1015.24 [barometerTrend] => [visibility] => * [snowCover] => * [icon] => 14 [iconName] => night_mostly_clear [iconLink] => https://weather.cit.api.here.com/static/weather/icon/23.png [ageMinutes] => 25 [activeAlerts] => 0 [country] => Germany [state] => Berlin [city] => Unter den Linden [latitude] => 52.5178 [longitude] => 13.3874 [distance] => 7.65 [elevation] => 0 [utcTime] => 2019-05-26T00:50:00.000+02:00 ) ) [country] => Germany [state] => Berlin [city] => Unter den Linden [latitude] => 52.51784 [longitude] => 13.38736 [distance] => 0.23 [timezone] => 1 ) ) ) [feedCreation] => 2019-05-25T23:15:27.708Z [metric] => 1 ) 
*/

$geokey = "D5exNs3PTzRoiQMSZCMl&app_code=BTtstViIGClKv3diMc9_-g";
$url = "https://weather.cit.api.here.com/weather/1.0/report.json?product=observation&latitude=$lat&longitude=$long&oneobservation=true&app_id=$geokey";

//echo 'url:' . $url;

$resp_json = file_get_contents($url);
$resp = json_decode($resp_json, true);
$temperature = $resp['observations']['location'][0]['observation'][0]['temperature'] ;

// put the data in the array
$data_arr = array();            
                 
array_push(
    $data_arr, 
    $temperature 
);

return $data_arr;

//echo 'resp:'. var_dump($data_arr);
//echo "temperature:" . $temperature;

}

function geocode($address){
     
        // url encode the address
        $address = urlencode($address);
         
        // google map geocode api url
        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=YOUR_API_KEY";
        $geokey = "AIzaSyCKxPZ-Ykvh1qMHmRUpfdN4PNeEsGFCcjQ";
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$geokey";
     
        // get the json response
        $resp_json = file_get_contents($url);
         
        // decode the json
        $resp = json_decode($resp_json, true);
     
        // response status will be 'OK', if able to geocode given address 
        if($resp['status']=='OK'){
     
            // get the important data
            $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
            $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
            $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
             
            // verify if data is complete
            if($lati && $longi && $formatted_address){
             
                // put the data in the array
                $data_arr = array();            
                 
                array_push(
                    $data_arr, 
                        $lati, 
                        $longi, 
                        $formatted_address
                    );
                 
                return $data_arr;
                 
            }else{
                return false;
            }
             
        }
     
        else{
            echo "<strong>ERROR: {$resp['status']}</strong>";
            return false;
        }
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