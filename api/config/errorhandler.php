<?php
//$errno means error number, $errstr=error string,
// $errfile=error file, $errline=error line

function errorHandler($errno, $errstr, $errfile, $errline) {
    if($errno != 2 && $errno != 8){
    throw new Exception($errstr);
}
}
  