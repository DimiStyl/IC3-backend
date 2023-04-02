<?php
use FirebaseJWT\JWT;

class dashboard extends Endpoint
{
    protected function authenticate() {
        // Require authentication
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new Exception("Unauthorized", 401);
        }

        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace("Bearer ", "", $authHeader);

        try {
            // Verify the JWT token
            JWT::decode($token, SECRETKEY, ['HS256']);
        } catch (Exception $e) {
            throw new Exception("Unauthorized", 401);
        }
    }
    protected function initialiseSQL() {
        $sql = "SELECT DISTINCT account_id,username,password,name,email,user_type,status
         FROM account";
            
        if (filter_has_var(INPUT_GET, 'account_id')) {
            // isset will return false if there are no WHERE
            // clauses set yet
            if (isset($where)) {
                $where .= " AND account.account_id = :account_id";
            } else {
                $where = " WHERE account.account_id = :account_id";
            }
            $sqlParams['account_id'] = $_GET['account_id'];
            $sql.=$where;
        }
        if (filter_has_var(INPUT_GET, 'username')) {
            // isset will return false if there are no WHERE
            // clauses set yet
            if (isset($where)) {
                $where .= " AND account.username = :username";
            } else {
                $where = " WHERE account.username = :username";
            }
            $sqlParams['username'] = $_GET['username'];
            $sql.=$where;
        }
        $this->setSQL($sql);
        $this->setSQLParams($sqlParams);
    }
        protected function endpointParams() {
        return ['account_id'];
        }
    }      