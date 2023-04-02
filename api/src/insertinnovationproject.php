<?php
class InsertInnovationProject extends Endpoint 
{
    public function __construct() {
        $this->validateRequestMethod("POST");
        $this->validateInsertParams();
        $db = new Database("db/tpp.db");
        $this->initialiseSQL();
        $queryResult = $db->executeSQL($this->getSQL(), $this->getSQLParams());
        // No need to set status code
        // Return a success message
        $this->setData( array(
          "length" => 0,
           "message" => "Success",
           "data" => null
        ));
      }

      private function validateInsertParams() {
        if (!filter_has_var(INPUT_POST,'Title')  || !filter_has_var(INPUT_POST,'Main_Text') || !filter_has_var(INPUT_POST,'img') ) {
          throw new ClientError("All parameters are required", 400);
        }
        // Add any other validation for required parameters
      }
      private function validateRequestMethod($method) {
        if ($_SERVER['REQUEST_METHOD'] != $method) {
          throw new ClientError("Invalid Request Method", 405);
         }}

      protected function initialiseSQL() {
        $title = $_POST['Title'];
        
        $mainText = $_POST['Main_Text'];
    
        $img = $_POST['img'];
     
        $sql = "INSERT INTO  Innovation_Projects (Title, Main_Text, img) VALUES (:title, :mainText, :img)";
        $this->setSQL($sql);
        $this->setSQLParams([
          'title' => $title,
          'mainText' => $mainText,
          'img' => $img
        ]);
      }
}

