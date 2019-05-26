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
            echo $response['body'];
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
                $CustomerData = array($row['id'],$row['firstname'],$row['lastname']);
                array_push($CustomerRecord,$CustomerData);
            }
        } else {
            echo "0 results";
        }

        mysqli_close($conn);
        print json_encode($CustomerRecord);        
    }


function getExternalValue($form_id, $visit_id) {


    $CustomerRecord = array();
        $con = mysqli_connect($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']);
        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $sql = "SELECT * FROM `" . $GLOBALS['dbname'] . "`.`lead` WHERE form_id='" . $form_id . "' AND visit_id=" . $visit_id . " ORDER by id DESC";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (decrypt($row['field_value']) != 'empty') 
                {
                 $CustomerData = array($row['field_id'],decrypt($row['field_value']),$row['date_time']);
                 array_push($CustomerRecord,$CustomerData);
                } 
            }
        }
        mysqli_close($con);
        return $CustomerRecord;

    }
//Your Business
//$CustomerRecord = getExternalValue($form_id, $visit_id);
//var_dump($CustomerRecord);




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

        mysqli_close();


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