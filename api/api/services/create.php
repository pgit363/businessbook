<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    
    include_once '../../class/services.php';

    $database = new Database();
    
    $db = $database->getConnection();

    $item = new services($db);

    $itemCheck = new services($db);

    $data = json_decode(file_get_contents("php://input"));

    if($data->sp_id != null && $data->service_product_name != null && $data->type != null)
    {
        $itemCheck->sp_id = $data->sp_id;

        $itemCheck->service_product_name = $data->service_product_name;

        $itemCheck->type = $data->type;

        $itemCheck->getCheckSingleServices();
        
        if($itemCheck->sp_id != null && $itemCheck->service_product_name != null && $itemCheck->type != null)
        {
            //if type available 
            return $departmentArr = array("message" => "services existed with same type in your service list");
        }
        else
        {
            $item->sp_id = $data->sp_id;
            $item->service_product_name = $data->service_product_name;
            $item->price = $data->price;
            $item->type = $data->type;
            $item->timestamp = date('Y-m-d H:i:s');
            
            if($item->createServices())
            {
                return $servicesArr = array("message" => "new service added.");
            } 
            else
            {
                return $servicesArr = array("message" => "new service could not be added.");
            }
        }
    }
    else
    {
        return $servicesArr = array("message" => "data could not be empty.");
    }
?>