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
    
        include_once '../../class/employees.php';
    
        $database = new Database();
        
        $db = $database->getConnection();
    
        $item = new Employee($db);
    
        //acceptiong json encoded data from user
        $data = json_decode(file_get_contents("php://input"));
    
        $item->email = $data->email; 

        $item->password = $data->password; 
      
        $item->loginEmployee();
    
        if($item->email != null)
        {
            // create array
            $emp_arr = array();
            $emp_arr["flag"] = "true"; 
            $emp_arr["user"] = array(   "id" =>  $item->id,
                                        "name" => $item->name,
                                        "email" => $item->email,
                                        "age" => $item->age,
                                        "designation" => $item->designation,
                                        "password" => $item->password,
                                    );
          
            return $employeeArr = $emp_arr;
        }
          
        else
        {
            $employeeArr = array();
            $employeeArr["flag"] = "false"; 
            $employeeArr["message"] = "login failed.";
            return $employeeArr;
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