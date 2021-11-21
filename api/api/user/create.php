<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    
    include_once '../../class/users.php';

    include_once '../../class/state.php';

    $database = new Database();
    
    $db = $database->getConnection();

    $item = new Users($db);

    $itemCheck = new Users($db);

    $itemState = new State($db);

    $data = json_decode(file_get_contents("php://input"));

    if ($data->email != null && $data->name != null) 
    {   
        $itemCheck->email = $data->email;

        $itemCheck->getCheckSingleUser();
        
        if($itemCheck->name != null)
        {
            //if email available 
            return $userArr = array("message" => "user existed with same email id");
        }
        else
        {
            $itemState->state_id = $data->state;

            $itemState->dist_id = 0; 
        
            $itemState->getSingleState();
        
            if($itemState->name != null)
            {
                $item->name = $data->name;

                $item->email = $data->email;

                $item->password = $data->password;
                
                $item->dob = $data->dob;
                
                $item->address1 = $data->address1;

                $item->address2 = $data->address2;

                $item->address3 = $data->address3;

                $item->state = $itemState->name;

                $item->city = $data->city;

                $item->zip = $data->zip;

                $item->longitude = $data->longitude;

                $item->latitude = $data->latitude;

                $item->department = $data->department;

                $item->type = $data->type;

                $item->gov_regi = $data->gov_regi;

                $item->working_hour = $data->working_hour;

                $item->starttime = $data->starttime;

                $item->endtime = $data->endtime;

                $item->timestamp = date('Y-m-d H:i:s');
                
                if($item->createUser())
                {
                    return $userArr = array("message" => "user created.");
                } 
                else
                {
                    return $userArr = array("message" => "user data could not be creaated.");
                }
            }
            else
            {
                return $state_arr = array("message" => "No record found.");
            } 
        }
    }
    else
    {
        return $userArr = array("message" => "user data could not be empty.");
    }
?>