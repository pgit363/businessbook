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
        
        include_once '../../class/nearestPlaces.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new nearestPlaces($db);
        
        // //acceptiong json encoded data from user
        $data = json_decode(file_get_contents("php://input"));
    
        $items->latitude = $data->latitude; 

        $items->longitude = $data->longitude; 

        $items->department = $data->department; 

        $stmt = $items->getNearestPlaces();
        
        $serviceProviderCount = $stmt->rowCount();

        if($serviceProviderCount > 0)
        {    
            $serviceProviderArr = array();
            $serviceProviderArr["flag"] =  true;
            $serviceProviderArr["serviceProviderCount"] =  array($serviceProviderCount);
            $serviceProviderArr["serviceProvider"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("id" => $id,
                            "name" => $name,
                            "latitude" => $latitude,
                            "longitude" => $longitude,
                            "department" => $department,
                            "distance" => $distance
                        );

                array_push($serviceProviderArr["serviceProvider"], $e);
            }
            return $serviceProviderArr;
        }
        else
        {
            return $serviceProviderArr = array("flag" => false,
                                                "message" => "No record found."
                                                );
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