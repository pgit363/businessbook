<?php
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';

    include_once '../../class/state.php';
    
    $database = new Database();

    $db = $database->getConnection();
    
    $item = new State($db);

    $itemCheck = new State($db);
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));
    
    $itemCheck->state_id = $data->state_id;

    $itemCheck->dist_id = 0;
    
    //getting employee for checking is emp available
    $itemCheck->getSingleState();

    if($itemCheck->name != null)
    {
        if($itemCheck->name != $data->name)
        {
            //if available then update
            $item->state_id = $data->state_id;

            $item->dist_id = 0;
            
            // employee values
            $item->name = $data->name;

            $item->timestamp = date('Y-m-d H:i:s');

            if($item->updateState())
            {
                return $stateArr = array("message" => "state updated.");
            } 
            else
            {
                return $stateArr = array("message" => "state could not updated.");
            }
        }
        else
        {
            return $stateArr = array("message" => "state is same as given.");
        }
    }
    else
    {
        return $stateArr = array("message" => "No record found.");
    }
?>