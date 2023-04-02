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
       case '/activities':
                    $endpoint = new Activities();
                    break;
                    case '/activitiesimg':
                        $endpoint = new Activitiesimg();
                        break;
                    case '/projects':
                        $endpoint = new Projects();
                        break;
                        case '/projects_text':
                            $endpoint = new Projects_Text();
                            break;
                            case '/demonstrators_text':
                             $endpoint = new Demonstrators_Text();
                        break;
                        case '/demonstrators_projects':
                         $endpoint = new  Demonstrators_Projects();
                            break;
                        case'/updateprojectext':
                         $endpoint = new UpdateProjectText();
                         break;
                         case'/updatedemonstratorstext':
                              $endpoint = new UpdateText();
                                 break;
                            case'/insertprojecttext':
                             $endpoint = new InsertProjectText();
                              break;
                                 case'/demonstratorsprojecttext':
                                 $endpoint = new InsertDemonstratorsText();
                                  break;
                                      case'/deleteprojecttext':
                                         $endpoint = new DeleteProjectText();
                                              break;
                                              case'/insertproject':
                                                   $endpoint = new InsertProject();
                                                            break;
                                                            case'/updateproject':
                                                                $endpoint = new UpdateProject();
                                                                break;
                                                                case'/deleteproject':
                                                                    $endpoint = new DeleteProject();
                                                                    break;  
                                                                    case'/deletedemonstratorstext':
                                                                        $endpoint = new DeleteDemonstratorsText();
                                                                        break; 
                                                                        case'/insertdemonstratorsproject':
                                                                            $endpoint = new InsertDemonstratorsProject();
                                                                            break;
                                                                            case'/deletedemonstratorsproject':
                                                                                $endpoint = new DeleteDemonstratorsProject();
                                                                                break;     
                                                                                case'/updatedemonstratorsproject':
                                                                                    $endpoint = new UpdateDemonstratorsProject();
                                                                                    break;
                                                          
                                                                                    
                                                    case'/updateactivitiestext':
                                        $endpoint = new UpdateActivitiesText();
                                     break;
                                     case'/updateactivitiesimg':
                                        $endpoint = new UpdateActivitiesImg();
                                     break;
                                    case'/insertactivitiestext':
                                   $endpoint = new InsertActivitiesText();
                                    break;
                                    case'/deleteactivitiestext':
                                        $endpoint = new DeleteActivitiesText();
                                         break;


                                         case'/deleteinnovationtext':
                                            $endpoint = new DeleteInnovationText();
                                            break; 
                                            case'/insertinnovationproject':
                                                $endpoint = new InsertInnovationProject();
                                                break;
                                                case'/deleteinnovationproject':
                                                    $endpoint = new DeleteInnovationProject();
                                                    break;     
                                                    case'/updateinnovationproject':
                                                        $endpoint = new UpdateInnovationProject();
                                                        break;      
                                                        case '/innovation_text':
                                                            $endpoint = new Innovation_Text();
                                                       break;
                                                       case '/innovation_projects':
                                                        $endpoint = new  Innovation_Projects();
                                                           break;
                                                           case'/innovationprojecttext':
                                                            $endpoint = new InsertInnovationText();
                                                             break;
                                                             case'/updateinnovationtext':
                                                                $endpoint = new UpdateInnovationText();
                                                                   break;
        default:
            $endpoint = new ClientError("Path not found: " . $path, 404);
    }

} catch (UserInvalidException $e){
    $endpoint = new ClientError($e->getMessage(), $e->getCode());
  }
$response = $endpoint->getData();
echo json_encode($response);
