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
        
        include_once '../../class/clientUsers.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new ClientUsers($db);
        
        $data = json_decode(file_get_contents("php://input"));
    
        $items->page = $data->page; 

        $items->rows = 10; 

        $stmt = $items->getClientUsers();
        
        $clientUsersCount = $stmt->rowCount();

        if($clientUsersCount > 0)
        {    
            $clientUsersArr = array();
            $clientUsersArr["message"] =  true;
            $clientUsersArr["clientUsersCount"] =  array($clientUsersCount);
            $clientUsersArr["clientUsers"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("id" => $id,
                            "name" => $name,
                            "email" => $email,
                            "mobile" => $mobile,
                            "longitude" => $longitude,
                            "latitude" => $latitude,
                            "password" => $password,
                            "timestamp" => $timestamp
                        );

                array_push($clientUsersArr["clientUsers"], $e);
            }
            return $clientUsersArr;
        }
        else
        {
            return $clientUsersArr = array("message" => "No record found.");
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