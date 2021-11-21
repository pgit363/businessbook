<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    
    include_once '../../class/marketing.php';
    
    $database = new Database();
    
    $db = $database->getConnection();
    
    $item = new Marketing($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;

    $item->getSingleMarketing();
    
    if($item->name != null)
    {
        //if available then delete
        if($item->deleteMarketing())
        {
            return $marketingBannerArr = array("message" => "Marketing banner deleted.");
        } 
        else
        {
            return $marketingBannerArr = array("message" => "Marketing banner could not be deleted.");
        }
    }
    else
    {
        return $marketingBannerArr = array("message" => "No record found.");
    }
?>