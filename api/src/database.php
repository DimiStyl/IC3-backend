<?php
 /**
 *this page is the database class where it connects to the db
 * and throws an exception if their is a connection error and fetches everything from the database
 */
class Database 
{
    private $dbConnection;
   
    public function __construct($dbName) {
        $this->setDbConnection($dbName);
    }

    /**
     * Create database connection using PDO
     */
    private function setDbConnection($dbName) {
        try {           
            $this->dbConnection = new PDO('sqlite:'.$dbName);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch( PDOException $e ) {
            http_response_code(500);
            $error['message'] = "Database connection error:".$e->getMessage();
            echo json_encode($error);
            exit();
          }
        }

    /**
     * Execute an SQL prepared statement
     *
     * This function executes the query and uses the PDO 'fetchAll' method with the
     * 'FETCH_ASSOC' flag set so that an associative array of results is returned.
     *
     * @param  string  $sql     An SQL statement
     * @param  array   $params  An associative array of parameters (default empty array) 
     * @return array            An associative array of the query results
     */
    public function executeSQL($sql, $params=[]) { 
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

