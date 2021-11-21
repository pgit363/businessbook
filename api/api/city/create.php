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

    $data = json_decode(file_get_contents("php://input"));

    if ($data->name != null && $data->state_id != null) 
    {
        $itemCheck->dist_id = $data->state_id;

        $itemCheck->name = $data->name;        

        $itemCheck->getCheckSingleCity();
        
        if($itemCheck->name != null)
        {
            //if name of City available 
            return $cityArr = array("message" => "city already existed");
        }
        else
        {
            $item->dist_id = $data->state_id;

            $item->name = $data->name;

            $item->timestamp = date('Y-m-d H:i:s');
            
            if($item->createCity())
            {
                return $cityArr = array("message" => "new city added.");
            } 
            else
            {
                return $cityArr = array("message" => "new city could not be added.");
            }
        }
    } 
    else 
    {
        return $cityArr = array("message" => "city could not be empty.");
    }
    
?>