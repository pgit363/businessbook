<?php
    
    include_once '../../config/cors.php';

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
        
        include_once '../../class/cart.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new Cart($db);
        
        $data = json_decode(file_get_contents("php://input"));
    
        $items->sp_id = $data->sp_id; 

        $stmt = $items->getSingleSpCart();
        
        $cartCount = $stmt->rowCount();

        if($cartCount > 0)
        {    
            $cartArr = array();
            $cartArr["message"] =  true;
            $cartArr["cartCount"] =  array($cartCount);
            $cartArr["cart"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("id" => $id,
                            "sp_id" => $sp_id,
                            "u_id" => $u_id,
                            "service_product_name" => $service_product_name,
                            "price" => $price,
                            "type" => $type,
                            "description" => $description,
                            "status" => $status,
                            "time_fixed" => $time_fixed,
                            "time_updated_by" => $time_updated_by,
                            "timestamp" => $timestamp
                        );

                array_push($cartArr["cart"], $e);
            }
            return $cartArr;
        }
        else
        {
            return $cartArr = array("message" => "No record found.");
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