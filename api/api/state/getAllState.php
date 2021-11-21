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
        
        include_once '../../class/state.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new State($db);

        //acceptiong json encoded data from user
        $data = json_decode(file_get_contents("php://input"));
    
        //dist id for getting state only if dist id is 0 then it is state
        $items->dist_id = 0;//$data->dist_id; 

        $stmt = $items->getState();
        
        $stateCount = $stmt->rowCount();

        if($stateCount > 0)
        {    
            $stateArr = array();
            $stateArr["message"] =  true;
            $stateArr["stateCount"] =  array($stateCount);
            $stateArr["state"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("state_id" => $state_id,
                            "dist_id" => $dist_id,            
                            "name" => $name,
                            "timestamp" => $timestamp
                        );

                array_push($stateArr["state"], $e);
            }
            return $stateArr;
        }
        else
        {
            return $stateArr = array("message" => "No record found.");
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