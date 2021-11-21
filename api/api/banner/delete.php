<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    
    include_once '../../class/banner.php';
    
    $database = new Database();
    
    $db = $database->getConnection();
    
    $item = new Banner($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;

    $item->getSingleBanner();
    
    if($item->name != null)
    {
        //if available then delete
        if($item->deleteBanner())
        {
            return $BannerArr = array("message" => "Banner deleted.");
        } 
        else
        {
            return $BannerArr = array("message" => "Banner could not be deleted.");
        }
    }
    else
    {
        return $BannerArr = array("message" => "No record found.");
    }
?>