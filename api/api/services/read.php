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
        
        include_once '../../class/services.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new Services($db);
        
        $data = json_decode(file_get_contents("php://input"));
    
        $items->sp_id = $data->sp_id;

        $stmt = $items->getServices();
        
        $servicesCount = $stmt->rowCount();

        if($servicesCount > 0)
        {    
            $servicesArr = array();
            $servicesArr["message"] =  true;
            $servicesArr["servicesCount"] =  array($servicesCount);
            $servicesArr["services"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("sid" => $id,
                            "sp_id" => $sp_id,
                            "service_product_name" => $service_product_name,
                            "price" => $price,
                            "type" => $type,
                            "timestamp" => $timestamp
                        );

                array_push($servicesArr["services"], $e);
            }
            return $servicesArr;
        }
        else
        {
            return $servicesArr = array("message" => "No record found.");
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