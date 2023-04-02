<?php

use FirebaseJWT\JWT;

class Authenticate extends Endpoint
{
    public function __construct() {
        $db = new Database("db/login.sqlite");
        $this->validateRequestMethod("POST");
        $this->validateAuthParameters();
        $this->initialiseSQL();
        $queryResult = $db->executeSQL($this->getSQL(), $this->getSQLParams());
        $this->validateUsername($queryResult); 
        $this->validatePassword($queryResult);  
        $this-> validateUser($queryResult);
      
        // Get the name and account_id from the query result
        $username = $queryResult[0]['username'];
        $account_id = $queryResult[0]['account_id'];
        $status = $queryResult[0]['status'];
        $user_type = $queryResult[0]['user_type'];
        // Generate the JWT token
        $token = $this->createJWT($queryResult);

        // Store the name, account_id, and token in the response data
        $data = array(
            "username" => $username,
            "account_id" => $account_id,
            "status"=> $status,
            "token" => $token,
            "user_type" =>$user_type,
        );
        $this->setData( array(
          "length" => 0, 
          "message" => "Success",
          "data" => $data
        ));
    }
 
    protected function initialiseSQL() {
        $sql = "SELECT account_id, name, username, password,status,user_type,email
        FROM account 
        WHERE username = :username";
        $this->setSQL($sql);
        $this->setSQLParams(['username'=>$_SERVER['PHP_AUTH_USER']]);
    }
 
    private function validateRequestMethod($method) {
        if ($_SERVER['REQUEST_METHOD'] != $method){
            throw new UserInvalidException("invalid request method", 405);
        }
    }
 
    private function validateAuthParameters() {
        if ( !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ) {
            throw new UserInvalidException("username and password required", 401);
        }
    }
 
    private function validateUsername($data) {
        if (count($data) < 1) {
            throw new UserInvalidException("invalid credentials", 401);
        }
    }
    
   
    private function validateUser($data) {
      $user_type = $data[0]['user_type'];
      $status = $data[0]['status'];
  
      if ($status != 'approved') {
          throw new UserInvalidException("User not approved", 401);
      } elseif ($user_type != 'admin' && $user_type != 'user') {
          throw new UserInvalidException("User type not authorized", 401);
      } else {
          // Allow other user types with status approved to login and access dashboard
          return;
      }
  }
  
    private function validatePassword($data) {
        if (!password_verify($_SERVER['PHP_AUTH_PW'], $data[0]['password'])) {
            throw new UserInvalidException("invalid credentials", 401);
        } 
    }
    private function createJWT($queryResult) {
 
        $secretKey = SECRETKEY;
       
       // for the iat and exp claims we need to know the time
       $time = time();

       // In the payload we use the time for the iat claim and add  
       // one day for the exp claim. For the iss claim we get
       // the name of the host the code is executing on
       $tokenPayload = [
        'iat' => $time,
        'exp' => strtotime('+1 day', $time),
        'iss' => $_SERVER['HTTP_HOST'],
        'sub' => $queryResult[0]['account_id'],
        'user_type' => $queryResult[0]['user_type']
       ];

       $jwt = JWT::encode($tokenPayload, $secretKey, 'HS256');

       return $jwt;
   }      
}
