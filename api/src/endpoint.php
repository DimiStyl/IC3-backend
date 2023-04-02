<?php

/**
 * A general class for endpoints which will be used to the other endpoints to extend
 */
abstract class Endpoint 
{
    private $data;
    private $sql;
    private $sqlParams;
 
    /**
     * Query the database and save the result 
     */
    public function __construct() {
  
        $db = new Database("db/login.sqlite");
 
        // The initialiseSQL method can be overridden by
        // child classes to set the SQL as appropriate for
        // each endpoint
        $this->initialiseSQL();

        $data = $db->executeSQL($this->sql, $this->sqlParams);
 
        // We are following the pattern from the first
        // answer by providing the length of the data array 
        $this->setData( array(
            "length" => count($data),
            "message" => "Success",
            "data" => $data
        ));
    }
    protected function setSQL($sql) {
        $this->sql = $sql;
    }
 
    protected function getSQL() {
        return $this->sql;
    }
 
    protected function setSQLParams($params) {
        $this->sqlParams = $params;
    }
    protected function getSQLParams() {
        return $this->sqlParams;
    }
    /**
     * Define SQL and params for the endpoint
     * 
     * This method can be overridden by child classes
     * with to set the SQL query needed for the specific
     * endpoint. It is just blank here because this is an
     * abstract endpoint.
     */
    protected function initialiseSQL() {
        $sql = "";
        $this->setSQL($sql);
        $this->setSQLParams([]);
    }
 
    protected function setData($data) {
        $this->data = $data;
    }
 
    public function getData() {
        return $this->data;
    }
    /**
 * Define valid parameters for this endpoint
 */
protected function endpointParams() {
    return [];
}
protected function validateParams($params) {
    foreach ($_GET as $key => $value) {
        if (!in_array($key, $params)) {
            http_response_code(400);
            $output['message'] = "Invalid parameter: " . $key;
            die(json_encode($output));
        }
     }    
}
 
}
