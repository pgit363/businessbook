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
    
        include_once '../../class/city.php';
    
        $database = new Database();
        
        $db = $database->getConnection();
    
        $item = new City($db);
    
        //acceptiong json encoded data from user
        $data = json_decode(file_get_contents("php://input"));
    
        //state id required for finfding state
        $item->state_id = $data->state_id; 

        //dist id required for checking for whether it is state or district if dist id is 0 then it is state else district
        //$item->dist_id = 0; 
      
        $item->getSingleState();
    
        if($item->name != null)
        {
            // create array
            $state_arr = array(
                                "state_id" => $item->state_id,
                                "dist_id" => $item->dist_id,
                                "name" => $item->name,
                                "timestamp" => $item->timestamp
                            );
          
            return $state_arr = array("state" => $state_arr);
        }
          
        else
        {
            return $state_arr = array("message" => "No record found.");
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