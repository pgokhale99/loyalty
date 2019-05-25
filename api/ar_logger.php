<?php

/*
$log = new Logger("log.txt");
$log->setTimestamp("D M d 'y h.i A");

if (user logs in) {
    $log->putLog("Successful Login: ".$_SESSION["user_name"]);
}
if (user logs out) {
    $log->putLog("Logout: ".$_SESSION["user_name"]);
}

//CHECK LOG
$log->getLog();

*/

class cLogger {

    private
        $file,
        $prefix;

    public function __construct($filename) {
        $this->file = $filename;
    }

    public function setTimestamp($format) {
        $this->prefix = date($format)." &raquo; ";
    }

    public function putLog($insert) {
        if (isset($this->prefix)) {
            file_put_contents($this->file, $this->prefix.$insert."<br>", FILE_APPEND);
        } else {
            echo "<script>alert(\"Timestamp is not set yet.\");</script>", die;
        }
    }

    public function getLog() {
        $content = @file_get_contents($this->file);
        return $content;
    }

}

?>