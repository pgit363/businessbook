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
                response(getSingle());
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

    function getSingle()
    {
        include_once '../../config/database.php';
    
        include_once '../../class/clientUsers.php';
    
        $database = new Database();
        
        $db = $database->getConnection();
    
        $item = new ClientUsers($db);
    
        //acceptiong json encoded data from user
        $data = json_decode(file_get_contents("php://input"));
    
        $item->email = $data->email; 

        $item->password = $data->password; 
      
        $item->loginClientUsers();
    
        if($item->name != null && $item->email != null)
        {
            // create array
            $clientUsersLogin_arr = array("id" => $item->id,
                                            "name" => $item->name,
                                            "email" => $item->email,
                                            "mobile" => $item->mobile,
                                            "longitude" => $item->longitude,
                                            "latitude" => $item->latitude,
                                            "password" => $item->password,
                                            "timestamp" => $item->timestamp
                                            );
          
            return $clientUsersLogin_arr = array("flag"=> true,
                                                "clientUsers" => $clientUsersLogin_arr);
        }
          
        else
        {
            return $clientUsersLogin_arr = array("false"=>false,
                                                "message" => "login failed.");
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