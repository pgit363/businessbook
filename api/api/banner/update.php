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
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));

    if($data->name != null && $data->banner_url != null && $data->sp_id != null)
    {
        //this if used only to update image url
        //getting employee for checking is emp available
        $itemCheck->id = $data->id;
        
        $itemCheck->getSingleBanner();

        if($itemCheck->name == $data->name && $itemCheck->banner_url == $data->banner_url && $itemCheck->sp_id == $data->sp_id)
        {
            return $bannerArr = array("message" => "same data already exist.");
        }
        else
        {
            //if available then update
            $item->id = $data->id;

            $item->name = $data->name;

            $item->banner_url = $data->banner_url;

            $item->banner_url = $data->banner_url;

            $item->sp_id = $data->sp_id;

            $item->timestamp = date('Y-m-d H:i:s');

            if($item->updateBanner())
            {
                return $bannerArr = array("message" => "Banner data updated.");
            } 
            else
            {
                return $bannerArr = array("message" => "Banner data could not updated.");
            }
        }
    }

    
?>