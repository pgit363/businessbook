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
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;

    $item->getSingleGovregi();
    
    if($item->govregi != null)
    {
        //if available then delete
        if($item->deleteGovregi())
        {
            return $govregiArr = array("message" => "government registration deleted.");
        } 
        else
        {
            return $govregiArr = array("message" => "government registration could not be deleted.");
        }
    }
    else
    {
        return $govregiArr = array("message" => "No record found.");
    }
?>