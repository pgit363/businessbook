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
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));
    
    //state id required for finfding state
    $item->state_id = $data->state_id; 

    //dist id required for checking for whether it is state or district if dist id is 0 then it is state else district
    $item->dist_id = 0; 
  
    $item->getSingleState();
    
    if($item->name != null)
    {
        $item->state_id = $data->state_id; 

        $item->dist_id = $data->state_id; 
  
        //if available then delete
        if($item->deleteState())
        {
            return $stateArr = array("message" => "state deleted with there existing districts.");
        } 
        else
        {
            return $stateArr = array("message" => "state and there districts could not be deleted.");
        }
    }
    else
    {
        return $stateArr = array("message" => "No record found. $data->state_id    hyat ny");
    }
?>