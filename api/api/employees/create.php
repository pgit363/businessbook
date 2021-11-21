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

    $data = json_decode(file_get_contents("php://input"));

    if($data->email != null && $data->name != null)
    {
        $itemCheck->email = $data->email;

        $itemCheck->getCheckSingleEmployee();
        
        if($itemCheck->name != null)
        {
            //if email available 
            return $employeeArr = array("message" => "Employee existed with same email id");
        }
        else
        {
            $item->name = $data->name;
            $item->email = $data->email;
            $item->age = $data->age;
            $item->designation = $data->designation;
            $item->password = $data->password;
            $item->timestamp = date('Y-m-d H:i:s');
            
            if($item->createEmployee())
            {
                return $employeeArr = array("message" => "Employee created.");
            } 
            else
            {
                return $employeeArr = array("message" => "Employee data could not be creaated.");
            }
        }
    }
    else
    {
        return $employeeArr = array("message" => "Employee data could not be empty.");
    }
?>