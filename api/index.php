<?php
 /**
 *this page gived the path url and routes the requests appropriately according to the endpoint used in the url
 * throws exception when path is not found
 * @author: Dimitriana Stylianou
 */
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
    exit(0);
} 
define('SECRETKEY',"Kcdp3ETZ5MD8,Q}jy(RdGsb1E8S(K3");
include 'config/config.php';
include 'src/database.php';
include 'src/Register.php';
include 'src/dashboard.php';
include 'src/authenticate.php';
include 'src/update.php';
include 'src/userinvalidexception.php';
include 'src/users.php';
include 'src/adduser.php';
include 'src/insertuser.php';
//include 'DocumentationPage';

//$request = new Request();

$path = parse_url($_SERVER['REQUEST_URI'])['path'];
$path = str_replace("/group/test/api","",$path);
     
    // Route the request as appropriate
try{
    switch($path) {
        case '/auth/':
        case '/auth':
        case '/auth/':
        case '/auth':
            $endpoint = new Authenticate();
            break;
            case '/dashboard/':
            case '/dashboard':
            case '/dashboard/':
            case '/dashboard':
            $endpoint = new dashboard();
            break;
        default:
            $endpoint = new ClientError("Path not found: " . $path, 404);
    }

} catch (UserInvalidException $e){
    $endpoint = new ClientError($e->getMessage(), $e->getCode());
  }
$response = $endpoint->getData();
echo json_encode($response);