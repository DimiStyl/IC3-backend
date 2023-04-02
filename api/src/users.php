<?php

class UsersApi extends Endpoint
{

    public function __construct()
    {
        $this->validateRequestMethod("POST");
        $db = new Database("db/login.sqlite");
        $this->validateAddParams();
        $this->initialiseSQL();
        $queryResult = $db->executeSQL($this->getSQL(), $this->getSQLParams());

        $this->setData(array(
            "length" => 0,
            "message" => "User added successfully",
            "data" => null
        ));
    }

    /**
     * Adds a new user to the database
     */
    private function validateRequestMethod($method)
    {
      if ($_SERVER['REQUEST_METHOD'] != $method) {
        throw new UserInvalidException("Invalid Request Method", 405);
      }
    }

    private function validateAddParams()
    {
        $required_params = array('name', 'email', 'password', 'username', 'user_type', 'status');
     
        foreach ($required_params as $param) {
            if (!filter_has_var(INPUT_POST, $param)) {
              throw new UserInvalidException("$param parameter required", 400);
            }
          }
    
        // Check if email is valid
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$email) {
        throw new UserInvalidException("Invalid email format", 400);
        }

        // Check if password is at least 8 characters long
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        if (strlen($password) < 8) {
            throw new UserInvalidException("Password must be at least 8 characters long", 400);
        }
    }
    protected function initialiseSQL()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $user_type = $_POST['user_type'];
        $status = $_POST['status'];
    
        $sql = "INSERT INTO account (name, email, password, username, user_type, status) 
        VALUES (:name, :email, :password, :username, :user_type, :status)";
        $this->setSQL($sql);
        $this->setSQLParams([
            ":name" => $name,
            ":email" => $email,
            ":password" => $password,
            ":username" => $username,
            ":user_type" => $user_type,
            ":status" => $status
        ]);
    }
  }    