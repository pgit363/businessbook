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

    $data = json_decode(file_get_contents("php://input"));

    if($data->name != null)
    {
        $itemCheck->name = $data->name;
        
        $itemCheck->getCheckSingleState();
    
        if($itemCheck->name != null)
        {
            //if name of state available 
            return $userArr = array("message" => "state already existed");
        }
        else
        {
            $item->dist_id = 0;
            
            $item->name = $data->name;
    
            $item->timestamp = date('Y-m-d H:i:s');
            
            if($item->createState())
            {
                return $stateArr = array("message" => "new state added.");
            } 
            else
            {
                return $stateArr = array("message" => "new state could not be added.");
            }
        }
    }
    else
    {
        return $stateArr = array("message" => "state could not be blank.");
    }
?>