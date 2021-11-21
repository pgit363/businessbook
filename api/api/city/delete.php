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
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));
    
    //state id required for finfding state
    // $item->state_id = $data->state_id; 
  
    // $item->getSingleState();
    
    // if($item->name != null)
    // {
        $item->state_id = $data->state_id; 

        $item->dist_id = $data->state_id; 
  
        //if available then delete
        if($item->deleteCity())
        {
            return $stateArr = array("message" => "city deleted.");
        } 
        else
        {
            return $stateArr = array("message" => "city could not be deleted.");
        }
    // }
    // else
    // {
    //     return $stateArr = array("message" => "No record found.");
    // }
?>