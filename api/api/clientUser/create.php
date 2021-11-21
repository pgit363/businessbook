<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    
    include_once '../../class/clientUsers.php';

    $database = new Database();
    
    $db = $database->getConnection();

    $item = new ClientUsers($db);

    $itemCheck = new ClientUsers($db);

    $data = json_decode(file_get_contents("php://input"));

    if ($data->name != null && $data->email != null) 
    {   
        $itemCheck->email = $data->email;

        $itemCheck->getCheckSingleClientUsers();
        
        if($itemCheck->email != null)
        {
            //if email available 
            return $clientUsersArr = array("message" => "user existed with same email");
        }
        else
        {
            $item->name = $data->name;

            $item->email = $data->email;

            $item->mobile = $data->mobile;
            
            $item->longitude = $data->longitude;
            
            $item->latitude = $data->latitude;

            $item->password = $data->password;

            $item->timestamp = date('Y-m-d H:i:s');
            
            if($item->createClientUsers())
            {
                return $clientUsersArr = array("message" => "user created.");
            } 
            else
            {
                return $clientUsersArr = array("message" => "user data could not be created.");
            }
        }
    }
    else
    {
        return $clientUsersArr = array("message" => "user data could not be empty.");
    }
?>