<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    
    include_once '../../class/govregi.php';

    $database = new Database();
    
    $db = $database->getConnection();

    $item = new Govregi($db);

    $itemCheck = new Govregi($db);

    $data = json_decode(file_get_contents("php://input"));

    if($data->govregi != null)
    {
        $itemCheck->govregi = $data->govregi;

        $itemCheck->getCheckSingleGovregi();
        
        if($itemCheck->govregi != null)
        {
            //if govregi available 
            return $govregiArr = array("message" => "govregi existed with same email id");
        }
        else
        {
            $item->govregi = $data->govregi;

            $item->timestamp = date('Y-m-d H:i:s');
            
            if($item->createGovregi())
            {
                return $govregiArr = array("message" => "new govregi added.");
            } 
            else
            {
                return $govregiArr = array("message" => "new govregi could not be added.");
            }
        }
    }
    else
    {
        return $govregiArr = array("message" => "govregi could not be Empty.");
    }
?>