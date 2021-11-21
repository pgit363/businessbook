<?php
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';

    include_once '../../class/department.php';
    
    $database = new Database();

    $db = $database->getConnection();
    
    $item = new Department($db);

    $itemCheck = new Department($db);
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));

    $itemCheck->id = $data->id;

    if($data->image_url != null)
    {
        //this if used only to update image url
        //getting employee for checking is emp available
        $itemCheck->getSingleDepartment();

        if($itemCheck->department != null)
        {
            //if available then update
            $item->id = $data->id;

            // employee values
            $item->image_url = $data->image_url;

            if($item->updateDepartmentIcon())
            {
                return $departmentArr = array("message" => "image_url updated.");
            } 
            else
            {
                return $departmentArr = array("message" => "image_url could not updated.");
            }
        }
        else
        {
            return $departmentArr = array("message" => "No record found.");
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