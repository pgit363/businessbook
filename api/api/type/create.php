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

    $data = json_decode(file_get_contents("php://input"));

    $itemCheck->type = $data->type;

    $itemCheck->getCheckSingleType();
    
    if($itemCheck->type != null)
    {
        //if type available 
        return $typeArr = array("message" => "Type existed with same email id");
    }
    else
    {
        $item->type = $data->type;
        $item->timestamp = date('Y-m-d H:i:s');
        
        if($item->createType())
        {
            return $typeArr = array("message" => "new type added.");
        } 
        else
        {
            return $typeArr = array("message" => "new type could not be added.");
        }
    }
?>