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
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));
    
    $itemCheck->id = $data->id;
    
    //getting employee for checking is emp available
    $itemCheck->getSingleClientUsers();

    if($itemCheck->name != null)
    {
        if($itemCheck->name == $data->name && $itemCheck->mobile == $data->mobile && $itemCheck->longitude == $data->longitude && $itemCheck->latitude == $data->latitude &&  $itemCheck->password == $data->password )
        {
            return $clientUserArr = array("message" => "user data same as stored.");
        }
        else
        {
           //if available then update
            $item->id = $data->id;
        
            // clientUser values
            $item->name = $data->name;

            $item->email = $data->email;

            $item->mobile = $data->mobile;

            $item->longitude = $data->longitude;

            $item->latitude = $data->latitude;

            $item->password = $data->password;

            $item->timestamp = date('Y-m-d H:i:s');

            if($item->updateClientUsers())
            {
                $clientUsers = array("name" => $data->name,
                                    "email" => $data->email,
                                    "mobile" => $data->mobile,
                                    "latitude" => $data->latitude,
                                    "longitude" => $data->longitude,
                                    "password" => $data->password);

                return $clientUserArr = array("flag" => true,
                                                "message" => "user data updated.",
                                            "updatedUser" => $clientUsers);
            } 
            else
            {
                return $clientUserArr = array("flag" => true,
                                                "message" => "user data could not updated.");
            }
        }
    }
    else
    {
        return $clientUserArr = array("message" => "No record found.");
    }
?>