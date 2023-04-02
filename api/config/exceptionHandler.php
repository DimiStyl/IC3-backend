 <?php
 // we create a generic exception handler that
 // will be automatically triggered in the event of an exception
function exceptionHandler($e) {
   http_response_code(500);
   $output['message'] = $errstr;
   $outupt['number'] = $errno;
   $output['location']['file'] = $errfile;
   $output['location']['line'] = $$errline;
   echo json_encode($output);
   die();

}