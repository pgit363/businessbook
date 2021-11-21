<?php
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';

    include_once '../../class/employees.php';
    
    $database = new Database();

    $db = $database->getConnection();
    
    $item = new Employee($db);

    $itemCheck = new Employee($db);
    
    //acceptiong json encoded data from user
    $data = json_decode(file_get_contents("php://input"));
    
    $itemCheck->id = $data->id;
    
    //getting employee for checking is emp available
    $itemCheck->getSingleEmployee();

    if($itemCheck->name != null)
    {
        //if available then update
        $item->id = $data->id;
        
        // employee values
        $item->name = $data->name;

        $item->email = $data->email;

        $item->age = $data->age;

        $item->designation = $data->designation;

        $item->password = $data->password;

        if($item->updateEmployee())
        {
            return $employeeArr = array("message" => "Employee data updated.");
        } 
        else
        {
            return $employeeArr = array("message" => "Employee data could not updated.");
        }
    }
    else
    {
        return $employeeArr = array("message" => "No record found.");
    }
?>