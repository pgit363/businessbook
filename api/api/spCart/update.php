<?php
    include_once '../../config/cors.php';
    
    include_once '../../config/database.php';

    include_once '../../class/cart.php';
    
    $database = new Database();

    $db = $database->getConnection();
    
    $item = new Cart($db);

    $itemCheck = new Cart($db);
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));

    if($data->description != null && $data->status != null && $data->time_fixed != null && $data->time_updated_by != null)
    {
        //this if used only to update image url
        //getting employee for checking is emp available
        $itemCheck->id = $data->id;

        $itemCheck->getCheckSingleInCart();

        if($itemCheck->description != null && $itemCheck->service_product_name != null)
        {
            //if available then update
            $item->id = $data->id;

            $item->description = $data->description;

            $item->status = $data->status;

            $item->time_fixed = $data->time_fixed;

            $item->time_updated_by = $data->time_updated_by;

            $item->timestamp = date('Y-m-d H:i:s');

            if($item->updateCartByClientSp())
            {
                return $cartArr = array("message" => "cart data updated successfully.");
            } 
            else
            {
                return $cartArr = array("message" => "cart data could not updated.");
            }
        }
        else
        {
            return $cartArr = array("message" => "No record found.");
        }
    }
    else
    {
        //this else part is only for update the deaprtment name
        //here we reqiured image_url must be null
        //getting employee for checking is emp available
        $itemCheck->getSingleDepartment();

        if($itemCheck->department != null)
        {
            if($itemCheck->department != $data->department)
            {
                //if available then update
                $item->id = $data->id;

                // employee values
                $item->department = $data->department;

                $item->timestamp = date('Y-m-d H:i:s');

                if($item->updateDepartment())
                {
                    return $departmentArr = array("message" => "department updated.");
                } 
                else
                {
                    return $departmentArr = array("message" => "department could not updated.");
                }
            }
            else
            {
                return $departmentArr = array("message" => "department is same as given.");
            }
        }
        else
        {
            return $departmentArr = array("message" => "No record found.");
        }
    }

    
?>