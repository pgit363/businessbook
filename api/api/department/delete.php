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
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;

    $item->getSingleDepartment();
    
    if($item->department != null)
    {
        //if available then delete
        if($item->deleteDepartment())
        {
            return $departmentArr = array("message" => "department deleted.");
        } 
        else
        {
            return $departmentArr = array("message" => "department could not be deleted.");
        }
    }
    else
    {
        return $department = array("message" => "No record found.");
    }
?>