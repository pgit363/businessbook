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
    
        include_once '../../class/users.php';
    
        $database = new Database();
        
        $db = $database->getConnection();
    
        $item = new Users($db);
    
        //acceptiong json encoded data from user
        $data = json_decode(file_get_contents("php://input"));
    
        $item->password = $data->password; 

        $item->email = $data->email; 
      
        $item->loginUser();
    
        if($item->name != null)
        {
            // create array
            $userLogin_arr = array("id" => $item->id,
                                    "name" => $item->name,
                                    "email" => $item->email,
                                    "password" => $item->password,
                                    "dob" => $item->dob,
                                    "address1" => $item->address1,
                                    "address2" => $item->address2,
                                    "address3" => $item->address3,
                                    "state" => $item->state,
                                    "city" => $item->city,
                                    "zip" => $item->zip,
                                    "department" => $item->department,
                                    "type" => $item->type,
                                    "gov_regi" => $item->gov_regi,
                                    "working_hour" => $item->working_hour,
                                    "starttime" => $item->starttime,
                                    "endtime" => $item->endtime,
                                    "timestamp" => $item->timestamp
                                );
          
            return $userLogin_arr = array("flag"=>true,
                                        "user" => $userLogin_arr);
        }
          
        else
        {
            return $userLogin_arr = array("flag"=>false,
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