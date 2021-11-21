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

    $itemCheck = new Type($db);
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));
    
    $itemCheck->id = $data->id;
    
    //getting employee for checking is emp available
    $itemCheck->getSingleType();

    if($itemCheck->type != null)
    {
        if($itemCheck->type != $data->type)
        {
            //if available then update
            $item->id = $data->id;

            // employee values
            $item->type = $data->type;

            $item->timestamp = date('Y-m-d H:i:s');

            if($item->updateType())
            {
                return $typeArr = array("message" => "type updated.");
            } 
            else
            {
                return $typeArr = array("message" => "type could not updated.");
            }
        }
        else
        {
            return $typeArr = array("message" => "type is same as given.");
        }
    }
    else
    {
        return $typeArr = array("message" => "No record found.");
    }
?>