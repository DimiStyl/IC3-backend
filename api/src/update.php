<?php
use FirebaseJWT\JWT;
use FirebaseJWT\Key;
header('Access-Control-Allow-Headers: Authorization');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

class Update
{
public function __construct()
{
      // Validate the token
      $this->validateToken();
}

private function validateToken() {
    // 1. Use the secret key
    $key = SECRETKEY;
            
    // Get all headers from the http request
    $allHeaders = getallheaders();
    $authorizationHeader = "";
                
    // 3. Look for an Authorization header. This 
    // this might not exist. It might start with a capital A (requests
    // from Postman do), or a lowercase a (requests from browsers might)
    if (array_key_exists('Authorization', $allHeaders)) {
        $authorizationHeader = $allHeaders['Authorization'];
    } elseif (array_key_exists('authorization', $allHeaders)) {
        $authorizationHeader = $allHeaders['authorization'];
    }
            
    // 4. Check if there is a Bearer token in the header
    if (substr($authorizationHeader, 0, 7) != 'Bearer ') {
        throw new UserInvalidException("Bearer token required", 401);
    }
    
    // 5. Extract the JWT from the header (by cutting the text 'Bearer ')
    $jwt = trim(substr($authorizationHeader, 7));
    
    try {
      // 6. Use the JWT class to decode the token
      $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    } catch (Exception $e) {
        throw new UserInvalidException($e->getMessage(), 401);
    }
    if ($decoded->iss != $_SERVER['HTTP_HOST']) {
      throw new UserInvalidException("invalid token issuer", 401);
    }
  }
  
}
    // connect to the database
    $db = new PDO('sqlite:group/test/api/db/login.sqlite');

    // retrieve the form data
    $account_id = $_POST['account_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    $user_type = $_POST['user_type'];
    
   
    //hash password
    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    // update the existing user in the database
    $stmt = $db->prepare('UPDATE account SET username=:username, email=:email, name=:name, status=:status, user_type=:user_type WHERE account_id=:account_id');
    $stmt->bindParam(':account_id', $account_id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':user_type', $user_type);
    $stmt->execute();
