<?php 
 /**
 *this page is for wwhen an exception must be thrown, when invalid parameters are used for example
 * @author: Dimitriana Stylianou
 */
class BadRequest extends Exception
{
  public function badRequestMessage()
  {  
     http_response_code(400);
     $output["message"] = $this->message;
     return $output;
  }
  try {
    $db = new Database("db/login.sqlite");
    $sql = "SELECT * FROM account";
    $params = array();
 
    if ((filter_has_var(INPUT_GET, 'account_id')) ) {
         throw new BadRequest("Invalid combination of account_id parameters");
    }
 
    foreach ($_GET as $key => $value) {
        if (!in_array($key, array('account_id') )) {
            throw new BadRequest("Invalid parameter " . $key);
        }
    }
 
    if (filter_has_var(INPUT_GET, 'account_id')) {
        $sql .= " WHERE account_id = :account_id";
        $params['account_id'] = $_GET['account_id'];
    } 
 
    $this->data = $db->executeSQL($sql, $params);
 
} catch (BadRequest $e) {
  $this->data = ["message" => $e->badRequestMessage()];
}
}