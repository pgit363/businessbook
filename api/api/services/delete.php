<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    
    include_once '../../class/services.php';
    
    $database = new Database();
    
    $db = $database->getConnection();
    
    $item = new Services($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;

    $item->getSingleServices();
    
    if($item->sp_id != null && $item->service_product_name != null && $item->type != null)
    {
        //if available then delete
        if($item->deleteServices())
        {
            return $servicesArr = array("message" => "service deleted.");
        } 
        else
        {
            return $servicesArr = array("message" => "service could not be deleted.");
        }
    }
    else
    {
        return $servicesArr = array("message" => "No record found.");
    }
?>