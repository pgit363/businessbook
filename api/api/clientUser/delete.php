<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    
    include_once '../../class/clientUsers.php';
    
    $database = new Database();
    
    $db = $database->getConnection();
    
    $item = new ClientUsers($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;

    $item->getSingleClientUsers();
    
    if($item->name != null)
    {
        //if available then delete
        if($item->deleteClientUsers())
        {
            return $clientUsersArr = array("message" => "user deleted.");
        } 
        else
        {
            return $clientUsersArr = array("message" => "user data could not be deleted.");
        }
    }
    else
    {
        return $clientUsersArr = array("message" => "No record found.");
    }
?>