<?php
use FirebaseJWT\JWT;
class Register extends Endpoint {
    function __construct()
    {
        $db = new Database("db/login.sqlite");
        $this->validateRequestMethod("POST");
        $this->validateAuthParameters();
        $this->initialiseSQL();
        $queryResult = $db->executeSQL($this->getSQL(), $this->getSQLParams());
        $this->validateUsername($queryResult); 
        $this->validatePassword($queryResult);  
   }
   protected function initialiseSQL() {
  $sql= "INSERT INTO account
   (account_id, username,password,name,email,user_type,status)
   VALUES ('account_id', 'username', 'password', 'name', 'email', 'user_type', 'status')";
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
    if (count($data)<1) {
        throw new UserInvalidException("invalid credentials", 401);
    } 
}

private function validatePassword($data) {
    if (!password_verify($_SERVER['PHP_AUTH_PW'], $data[0]['password'])) {
        throw new UserInvalidException("invalid credentials", 401);
    } 
}
private function createJWT($queryResult) {
 
    // 1. Uses the secret key defined earlier
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
     'sub' => $queryResult[0]['id']
   ];
         
   $jwt = JWT::encode($tokenPayload, $secretKey, 'HS256');
   
   return $jwt;
} 
}