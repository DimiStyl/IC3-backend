<?php

/** 
 * Update project
 * 
 * Update the properties of a specified project. A valid JWT
 * is required.
 * 
 * @param int    $id        The ID of the project to update
 * @param string $title     The updated title of the project
 * @param string $abstract  The updated abstract of the project
 * @param string $mainText  The updated main text of the project
 * @param string $partners  The updated partners of the project
 * @param string $img       The updated image of the project
 * @param string $status    The updated status of the project
 * 
 * @return array An array with a success message
 * 
 * @author W20015975 Andreas Christodoulou
 */

class UpdateDemonstratorsProject extends Endpoint 
{
    public function __construct() {
        $this->validateRequestMethod("POST");
       
        $this->validateUpdateParams();
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

    private function validateRequestMethod($method) {
        if ($_SERVER['REQUEST_METHOD'] != $method) {
            throw new ClientError("Invalid Request Method", 405);
        }
    }

    private function validateUpdateParams() {
        // 1. Look for all required parameters
        if (!filter_has_var(INPUT_POST, 'id')) {
            throw new ClientError("Project ID parameter required", 400);
        }
  if (!filter_has_var(INPUT_POST,'Title') || !filter_has_var(INPUT_POST,'Main_Text')  || !filter_has_var(INPUT_POST,'img') ) {
          throw new ClientError("All parameters are required", 400);
        }
                 
        // 2. Check to see if a valid project ID is supplied 
        // (this can be done by checking if the ID exists in the Projects table)

    }

    protected function initialiseSQL() {
        $id = $_POST['id'];
        $title = $_POST['Title'];
       
        $mainText = $_POST['Main_Text'];
   
        $img = $_POST['img'];
     

        $sql = "UPDATE Demonstrators_Projects SET Title = :title, Main_Text = :mainText, img = :img WHERE id = :id";
        $this->setSQL($sql);
        $this->setSQLParams([
            'id' => $id,
            'title' => $title,
            
            'mainText' => $mainText,
        
            'img'=>$img
            
        ]);
        }

}
