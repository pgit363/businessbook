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
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;

    $item->getSingleEmployee();
    
    if($item->name != null)
    {
        //if available then delete
        if($item->deleteEmployee())
        {
            return $employeeArr = array("message" => "Employee deleted.");
        } 
        else
        {
            return $employeeArr = array("message" => "Employee data could not be deleted.");
        }
    }
    else
    {
        return $employeeArr = array("message" => "No record found.");
    }
?>