<?php


class insertuser extends Endpoint
{
    protected function initialiseSQL() {
        $sql = "INSERT INTO account (name, email, password, username, user_type, status) 
        VALUES (:name, :email, :password, :username, :user_type, :status)";
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
        $this->setSQL($sql);
        $this->setSQLParams($sqlParams);
    }
        protected function endpointParams() {
        return ['account_id'];
        }
    }      