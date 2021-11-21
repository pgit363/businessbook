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
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));
    
    $itemCheck->id = $data->id;
    
    //getting employee for checking is emp available
    $itemCheck->getSingleGovregi();

    if($itemCheck->govregi != null)
    {
        if($itemCheck->govregi != $data->govregi)
        {
            //if available then update
            $item->id = $data->id;

            // employee values
            $item->govregi = $data->govregi;

            $item->timestamp = date('Y-m-d H:i:s');

            if($item->updategovregi())
            {
                return $govregiArr = array("message" => "government registration updated.");
            } 
            else
            {
                return $govregiArr = array("message" => "government registration could not updated.");
            }
        }
        else
        {
            return $govregiArr = array("message" => "government registration is same as given.");
        }
    }
    else
    {
        return $typeArr = array("message" => "No record found.");
    }
?>