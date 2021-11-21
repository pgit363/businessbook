<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $request = $_SERVER['REQUEST_METHOD'];

    $token = base64_encode("admin"."admin123");

    $authToken = "";

    $data = array();

    foreach (getallheaders() as $name => $value) 
    {
        if($name == "Authorization")
        {
            $authToken = ltrim($value,"Bearer ");
        }
    }

    if($authToken == "YWRtaW5hZG1pbjEyMw==")
    {
        switch ($request) 
        {
            case 'GET':
                response($data[]=array("status"=>http_response_code(401),"message"=>"server request not allowed"));
            break;
            
            case 'POST':
                response(get());
            break;
            
            case 'PUT':
                response($data[]=array("status"=>http_response_code(401),"message"=>"server request not allowed"));
            break;
            
            case 'DELETE':
                response($data[]=array("status"=>http_response_code(401),"message"=>"server request not allowed"));
            break;
            
            default:
                response($data[]=array("status"=>http_response_code(401),"message"=>"server request not allowed"));
            break;
        }
    }
    else if(empty($authToken))
    {
        response($data = array("status"=>http_response_code(404),"message"=>"token Required..!"));
    }
    else
    {
        response($data = array("status"=>http_response_code(401),"message"=>"invalid Token..!"));
    }

    function get()
    {
        include_once '../../config/database.php';
        
        include_once '../../class/users.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new Users($db);

        $stmt = $items->getUsers();
        
        $userCount = $stmt->rowCount();

        if($userCount > 0)
        {    
            $userArr = array();
            $userArr["message"] =  true;
            $userArr["userCount"] =  array($userCount);
            $userArr["users"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("id" => $id,
                            "name" => $name,
                            "email" => $email,
                            "password" => $password,
                            "dob" => $dob,
                            "address1" => $address1,
                            "address2" => $address2,
                            "address3" => $address3,
                            "state" => $state,
                            "city" => $city,
                            "zip" => $zip,
                            "longitude" => $longitude,
                            "latitude" => $latitude,
                            "department" => $department,
                            "type" => $type,
                            "gov_regi" => $gov_regi,
                            "working_hour" => $working_hour,
                            "starttime" => $starttime,
                            "endtime" => $endtime,
                            "timestamp" => $timestamp
                        );

                array_push($userArr["users"], $e);
            }
            return $userArr;
        }
        else
        {
            return $userArr = array("message" => "No record found.");
        }
    }    

    function response($data)
    {
        $myObj =new stdClass();
        
        $myObj->status = "ok";
        
        $myObj->code = http_response_code(200);
        
        $myObj->response = $data;
        
        echo  json_encode($myObj);
    }
?>