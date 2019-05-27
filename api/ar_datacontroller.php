<?php

include_once('ar_constants.php');

class cDataController {

    private $dbhost = DBHOST;
    private $dbuser = DBUSER;
    private $dbpass = DBPASS;
    private $dbname = DBNAME;

    private $requestMethod;
    private $username;
    private $atts;
    //private $dataGateway;    


    public function __construct($requestMethod, $username, $atts)
    {
        $this->requestMethod = $requestMethod;
        $this->username = $username;
        $this->atts = $atts;
        //$this->dataGateway = new dataGateway();
    }

    public function processRequest()
    {
        $response = array();

        switch ($this->requestMethod) {
            case 'GET':
                if ($this->username) {
                    $result = $this->FindRecord($this->username);
                    if (! $result) {
                        return $this->notFoundResponse();
                    }
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = $result;
                    //return $response;

                } else {
                    $response = $this->FindAllRecords();
                };
                break;
            case 'POST':
                $repsonse = $this->InsertRecord($this->atts, "");
                break;
            case 'PUT':
                $response = $this->notFoundResponse();
                break;
            case 'DELETE':
                $response = $this->notFoundResponse();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) {
            return $response['body'];
        }
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }    

    public function FindRecord($id)
    {
        $dbhost = DBHOST;
        $dbuser = DBUSER;
        $dbpass = DBPASS;
        $dbname = DBNAME;

        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "
            SELECT id, firstname, lastname, email, phone, city
            FROM `" . $dbname . "`.`tbltest` 
            WHERE firstname ='" . $id . "';" ;

        //echo 'SQL Select:' . $sql;

        $CustomerRecord = array();
        
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. PHP_EOL;
                $CustomerData = array("id:" . $row['id'], "firstname:" . $row['firstname'], "lastname:" . $row['lastname']);
                array_push($CustomerRecord,$CustomerData);
            }
            print json_encode($CustomerRecord); 
        } else {
            return '{
              "code" : 200,
              "message"  : "No results",
              "location" : "data controller",
              "form"     : "contact-form"
            }';
        }

        mysqli_close($conn);
               
    }

    function InsertRecord($atts, $arrresult=""){

        $dbhost = DBHOST;
        $dbuser = DBUSER;
        $dbpass = DBPASS;
        $dbname = DBNAME;

        //echo 'arrjson:' . print_r($arrresult);

        $latitude = "0.0";
        if ( is_array($arrresult) && array_key_exists("latitude",$arrresult) )
            $latitude = $arrresult["latitude"];

        $longitude = "0.0";
        if ( is_array($arrresult) && array_key_exists("longitude",$arrresult) )
            $longitude = $arrresult["longitude"];

        $temperature = "0.0";
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

        if ($s_err != "1"){
             echo("SQL Error 1: " . $s_err . ' -' . mysqli_error($con));
        }

        mysqli_close($con);


        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
        
        // echo '{
        //     "code" : 200,
        //     "status" : "Success"          
        // }';
    }

}//END CLASS
?>