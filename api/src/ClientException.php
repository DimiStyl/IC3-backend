<?php 
  /**
 *this page is for wwhen an exception must be thrown, when invalid parameters are used for example
 * @author: Dimitriana Stylianou
 */
class ClientException extends Exception
{
  public function badRequestMessage()
  {  
     http_response_code(400);
     $output["message"] = $this->message;
     return $output;
  }
}
try {
    $db = new Database("db/login.sqlite");
    $sql = "SELECT * FROM author";
    $params = array();
 
    if ((filter_has_var(INPUT_GET, 'author_id')) && (filter_has_var(INPUT_GET, 'paper_id'))) {
         throw new BadRequest("Invalid combination of author_id and paper_id parameters");
    }
 
    foreach ($_GET as $key => $value) {
        if (!in_array($key, array('author_id', 'paper_id') )) {
            throw new BadRequest("Invalid parameter " . $key);
        }
    }
 
    if (filter_has_var(INPUT_GET, 'author_id')) {
        $sql .= " WHERE author_id = :author_id";
        $params['author_id'] = $_GET['author_id'];
    } 
 
    if (filter_has_var(INPUT_GET, 'paper_id')) {
        $sql .= " WHERE last_name LIKE :paper_id";
        $params[':paper_id'] = '%'.$_GET['paper_id'].'%';
    }
 
    $this->data = $db->executeSQL($sql, $params);
 
} catch (BadRequest $e) {
  $this->data = ["message" => $e->badRequestMessage()];
}