<?php

include_once '../../config/cors.php';

$request=$_SERVER['REQUEST_METHOD'];

$token = base64_encode("admin"."admin123");

$authToken = "";

$data = array();

foreach (getallheaders() as $name => $value) 
{
    if($name == "Authorization")
    {
      $authToken = ltrim($value,"Bearer ");
    }
}

if($authToken == "YWRtaW5hZG1pbjEyMw==")
{
    switch ($request) 
    {
        case 'GET':
            response($data[]=array("status"=>http_response_code(401),"message"=>"server request not allowed"));
       	break;
        
        case 'POST':
    	    response(include_once 'create.php');
        break;
        
        case 'PUT':
            response(include_once 'update.php');
     	break;
        
        case 'DELETE':
            response(include_once 'delete.php');
        break;
        
     	default:
            response($data[]=array("status"=>http_response_code(401),"message"=>"server request not allowed"));
        break;
    }
}
else if(empty($authToken))
{
    response($data = array("status"=>http_response_code(404),"message"=>"token Required..!"));
}
else
{
    response($data = array("status"=>http_response_code(401),"message"=>"invalid Token..!"));
}


function response($data)
{
  
    $myObj =new stdClass();
    
    $myObj->status = "ok";
    
    $myObj->code = http_response_code(200);
    
    $myObj->response = $data;
    
    echo  json_encode($myObj);
}

?>
