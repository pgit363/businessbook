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

    $itemCheck = new Banner($db);

    $data = json_decode(file_get_contents("php://input"));

    if($data->name != null && $data->banner_url != null && $data->sp_id != null)
    {
        $itemCheck->name = $data->name;
        
        $itemCheck->banner_url = $data->banner_url;
        
        $itemCheck->sp_id = $data->sp_id;

        $itemCheck->getCheckSingleBanner();
        
        if($itemCheck->name == $data->name && $itemCheck->banner_url == $data->banner_url && $itemCheck->sp_id == $data->sp_id)
        {
            //if type available 
            return $bannerArr = array("message" => "Banner existed with same banner_url, Name & sp_id id");
        }
        else
        {
            $item->name = $data->name;

            $item->banner_url = $data->banner_url;

            $item->sp_id = $data->sp_id;

            $item->timestamp = date('Y-m-d H:i:s');
            
            if($item->createBanner())
            {
                return $bannerArr = array("message" => "new Banner added.");
            } 
            else
            {
                return $bannerArr = array("message" => "new Banner could not be added.");
            }
        }
    }
    else
    {
        return $bannerArr = array("message" => "Banner could not be empty.");
    }
?>