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

    $itemCheck = new Marketing($db);
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));

    if($data->name != null && $data->marketing_banner != null)
    {
        //this if used only to update image url
        //getting employee for checking is emp available
        $itemCheck->id = $data->id;
        
        $itemCheck->getSingleMarketing();

        if($itemCheck->name == $data->name && $itemCheck->marketing_banner == $data->marketing_banner)
        {
            return $marketingBannerArr = array("message" => "Marketing banner already exist.");
        }
        else
        {
            //if available then update
            $item->id = $data->id;

            $item->name = $data->name;

            $item->marketing_banner = $data->marketing_banner;

            $item->timestamp = date('Y-m-d H:i:s');

            if($item->updateMarketing())
            {
                return $marketingBannerArr = array("message" => "Marketing banner updated.");
            } 
            else
            {
                return $marketingBannerArr = array("message" => "Marketing banner could not updated.");
            }
        }
    }

    
?>