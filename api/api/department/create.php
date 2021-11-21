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

    $data = json_decode(file_get_contents("php://input"));

    $itemCheck->department = $data->department;

    $itemCheck->getCheckSingleDepartment();
    
    if($itemCheck->department != null)
    {
        //if type available 
        return $departmentArr = array("message" => "department existed with same department id");
    }
    else
    {
        $item->department = $data->department;
        $item->timestamp = date('Y-m-d H:i:s');
        
        if($item->createDepartment())
        {
            return $departmentArr = array("message" => "new department added.");
        } 
        else
        {
            return $departmentArr = array("message" => "new department could not be added.");
        }
    }
?>