<?php
    
    include_once '../../config/cors.php';

    include_once '../../config/database.php';
    
    include_once '../../class/cart.php';

    $database = new Database();
    
    $db = $database->getConnection();

    $item = new Cart($db);

    $itemCheck = new Cart($db);

    $data = json_decode(file_get_contents("php://input"));

    if($data->sp_id != null && $data->u_id != null && $data->service_product_name != null)
    {
        $itemCheck->sp_id = $data->sp_id;

        $itemCheck->u_id = $data->u_id;

        $itemCheck->service_product_name = $data->service_product_name;

        $itemCheck->price = $data->price;

        $itemCheck->type = $data->type;

        $itemCheck->getCheckSingleCart();
        
        if($itemCheck->service_product_name != null)
        {
            //if type available 
            return $departmentArr = array("flag" => false,
                                            "message" => "service or product already exist");
        }
        else
        {
            $item->sp_id = $data->sp_id;

            $item->u_id = $data->u_id;

            $item->service_product_name = $data->service_product_name;

            $item->price = $data->price;

            $item->type = $data->type;

            $item->description = $data->description;

            $item->status = $data->status;

            $item->time_fixed = $data->time_fixed;

            $item->time_updated_by = $data->time_updated_by;

            $item->timestamp = date('Y-m-d H:i:s');
            
            if($item->createCart())
            {
                return $cartArr = array("flag" => true,
                                        "message" => "service added to cart successfully.");
            } 
            else
            {
                return $cartArr = array("flag" => false,
                                        "message" => "service could not be added.");
            }
        }
    }
    else
    {
        return $cartArr = array("flag" => false,
                                "message" => "service could not be empty.");
    }
?>