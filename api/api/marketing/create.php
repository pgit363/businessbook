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

    $data = json_decode(file_get_contents("php://input"));

    if($data->name != null && $data->marketing_banner != null)
    {
        $itemCheck->name = $data->name;
        
        $itemCheck->marketing_banner = $data->marketing_banner;
        
        $itemCheck->getCheckSingleMarketing();
        
        if($itemCheck->name == $data->name && $itemCheck->marketing_banner == $data->marketing_banner)
        {
            //if type available 
            return $marketingArr = array("message" => "Marketing banner already existed.");
        }
        else
        {
            $item->name = $data->name;

            $item->marketing_banner = $data->marketing_banner;

            $item->timestamp = date('Y-m-d H:i:s');
            
            if($item->createMarketing())
            {
                return $marketingArr = array("message" => "Marketing banner added.");
            } 
            else
            {
                return $marketingArr = array("message" => "Marketing banner could not be added.");
            }
        }
    }
    else
    {
        return $marketingArr = array("message" => "Marketing banner could not be empty.");
    }
?>