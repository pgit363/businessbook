<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    
    include_once '../../class/type.php';
    
    $database = new Database();
    
    $db = $database->getConnection();
    
    $item = new Type($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;

    $item->getSingleType();
    
    if($item->type != null)
    {
        //if available then delete
        if($item->deleteType())
        {
            return $typeArr = array("message" => "type deleted.");
        } 
        else
        {
            return $typeArr = array("message" => "type could not be deleted.");
        }
    }
    else
    {
        return $typeArr = array("message" => "No record found.");
    }
?>