<?php
    
    include_once '../../config/cors.php';
    
    include_once '../../config/database.php';
    
    include_once '../../class/cart.php';
    
    $database = new Database();
    
    $db = $database->getConnection();
    
    $item = new Cart($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;

    $item->getCheckSingleInCart();
    
    if($item->service_product_name != null)
    {
        //if available then delete
        if($item->deleteCart())
        {
            return $cartArr = array("message" => "Service removed from cart.");
        } 
        else
        {
            return $cartArr = array("message" => "Service could not removed from cart.");
        }
    }
    else
    {
        return $cartArr = array("message" => "No record found.");
    }
?>