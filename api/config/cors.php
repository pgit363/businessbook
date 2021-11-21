<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");

    header("Access-Control-Allow-Credentials: true");
    
    header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    header("HTTP/1.1 200 OK");

?>