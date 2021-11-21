<?php
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';

    include_once '../../class/city.php';
    
    $database = new Database();

    $db = $database->getConnection();
    
    $item = new City($db);

    $itemCheck = new City($db);
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));
    
    //$itemCheck->state_id = $data->state_id;

    // $itemCheck->dist_id = $data->dist_id;

    // $itemCheck->name = $data->name;
    
    //getting city for checking is city available
    // $itemCheck->getCheckSingleCity();

    // if($itemCheck->name != null)
    // {
        // if($itemCheck->name == $data->name)
        // {
            //if available then update
            $item->state_id = $data->state_id;

            $item->dist_id = $data->dist_id;
            
            $item->name = $data->name;

            $item->timestamp = date('Y-m-d H:i:s');

            if($item->updateCity())
            {
                return $stateArr = array("message" => "city updated.");
            } 
            else
            {
                return $stateArr = array("message" => "city could not updated.");
            }
    //     }
    //     else
    //     {
    //         return $stateArr = array("message" => "city is same as given.");
    //     }
    // }
    // else
    // {
    //     return $stateArr = array("message" => "No record found.");
    // }
?>