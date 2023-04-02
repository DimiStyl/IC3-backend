<?php
  /**
 *this page is used as a response for the request class
 * @author: Dimitriana Stylianou
 */
class Response
{
    public function __construct() {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *"); 
    }
}