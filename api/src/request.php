<?php
  /**
 *this page is used in index.php to request path for the api and to validate the method which is used
 * @author: Dimitriana Stylianou
 */
class Request 
{
    private $method;
    private $path;
 
    public function __construct() {
        $this->setMethod();
        $this->setPath();
    }
 
    private function setMethod() {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
 
    public function validateRequestMethod($validMethods) {
        if (!in_array($this->method, $validMethods)) {
            $output['message'] = "Invalid request method: ".$this->method;
            die(json_encode($output));
        }
    }
 
    private function setPath() {
        $this->path = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->path = str_replace("/group/test/api","",$this->path);
    }
 
    public function getPath() {
        return $this->path;
    }
 
}