<?php
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';

    include_once '../../class/users.php';
    
    $database = new Database();

    $db = $database->getConnection();
    
    $item = new Users($db);

    $itemCheck = new Users($db);
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));
    
    $itemCheck->id = $data->id;
    
    //getting employee for checking is emp available
    $itemCheck->getSingleUser();

    if($itemCheck->name != null)
    {
        //if available then update
        $item->id = $data->id;
        
        // employee values
        $item->name = $data->name;

        $item->email = $data->email;

        $item->password = $data->password;

        $item->dob = $data->dob;

        $item->address1 = $data->address1;

        $item->address2 = $data->address2;

        $item->address3 = $data->address3;

        $item->state = $data->state;

        $item->city = $data->city;

        $item->zip = $data->zip;

        // $item->longitude = $data->longitude;

        // $item->latitude = $data->latitude;

        $item->department = $data->department;

        $item->type = $data->type;

        $item->gov_regi = $data->gov_regi;

        $item->working_hour = $data->working_hour;

        $item->starttime = $data->starttime;

        $item->endtime = $data->endtime;

        $item->timestamp = date('Y-m-d H:i:s');

        if($item->updateUser())
        {
            $users = array("name" => $data->name,
                            "email" => $data->email,
                            "password" => $data->password,
                            "dob" => $data->dob,
                            "address1" => $data->address1,
                            "address2" => $data->address2,
                            "address3" => $data->address3,
                            "state" => $data->state,
                            "city" => $data->city,
                            "zip" => $data->zip,
                            "latitude" => $data->latitude,
                            "longitude" => $data->longitude,
                            "department" => $data->department,
                            "type" => $data->type,
                            "gov_regi" => $data->gov_regi,
                            "working_hour" => $data->working_hour,
                            "starttime" => $data->starttime,
                            "endtime" => $data->endtime);

                return $userArr = array("flag" => true,
                                        "message" => "user data updated.",
                                        "updatedUser" => $users);
        } 
        else
        {
            return $userArr = array("message" => "user data could not updated.");
        }
    }
    else
    {
        return $userArr = array("message" => "No record found.");
    }
?>