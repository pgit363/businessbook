<?php
    
    header("Access-Control-Allow-Origin: *");
    
    header("Content-Type: application/json; charset=UTF-8");
    
    header("Access-Control-Allow-Methods: POST");
    
    header("Access-Control-Max-Age: 3600");
    
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $request = $_SERVER['REQUEST_METHOD'];

    $token = base64_encode("admin"."admin123");

    include_once '../../config/database.php';
        
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
                response(get());
            break;
            
            case 'PUT':
                response($data[]=array("status"=>http_response_code(401),"message"=>"server request not allowed"));
            break;
            
            case 'DELETE':
                response($data[]=array("status"=>http_response_code(401),"message"=>"server request not allowed"));
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

    function get()
    {
        $landingPageArr = array();
       
        $landingPageArr["adBanner"] = getBanner();
       
        $landingPageArr["department"] = getDepartment();

        $landingPageArr["marketingBanner"] = getMarketingBanner();

        $landingPageArr["type"] = getAllTypes();

        return $landingPageArr;
        
    }

    function getBanner()
    {
        include_once '../../class/banner.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new Banner($db);

        $stmt = $items->getBanner();
        
        $bannerCount = $stmt->rowCount();

        if($bannerCount > 0)
        {    
            $bannerArr = array();
            $bannerArr["message"] =  true;
            $bannerArr["bannerCount"] =  array($bannerCount);
            $bannerArr["banner"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("id" => $id,
                            "name" => $name,
                            "banner_url" => $banner_url,
                            "sp_id" => $sp_id,
                            "timestamp" => $timestamp
                        );

                array_push($bannerArr["banner"], $e);
            }
            return $bannerArr;
        }
        else
        {
            return $bannerArr = array("message" => "No record found.");
        }
    }

    function getDepartment()
    {
        include_once '../../class/department.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new Department($db);

        $stmt = $items->getDepartment();
        
        $departmentCount = $stmt->rowCount();

        if($departmentCount > 0)
        {    
            $departmentArr = array();
            $departmentArr["message"] =  true;
            $departmentArr["departmentCount"] =  array($departmentCount);
            $departmentArr["allDepartments"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("id" => $id,
                            "department" => $department,
                            "image_url" => $image_url,
                            "timestamp" => $timestamp
                        );

                array_push($departmentArr["allDepartments"], $e);
            }
            return $departmentArr;
        }
        else
        {
            return $departmentArr = array("message" => "No record found.");
        }
    } 
    
    function getMarketingBanner()
    {       
        include_once '../../class/marketing.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new Marketing($db);

        $stmt = $items->getMarketing();
        
        $marketingbannerCount = $stmt->rowCount();

        if($marketingbannerCount > 0)
        {    
            $marketingBannerArr = array();
            $marketingBannerArr["message"] =  true;
            $marketingBannerArr["marketingbannerCount"] =  array($marketingbannerCount);
            $marketingBannerArr["marketingbanner"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("id" => $id,
                            "name" => $name,
                            "marketing_banner" => $marketing_banner,
                            "timestamp" => $timestamp
                        );

                array_push($marketingBannerArr["marketingbanner"], $e);
            }
            return $marketingBannerArr;
        }
        else
        {
            return $marketingBannerArr = array("message" => "No record found.");
        }
    }  

    function getAllTypes()
    {
        include_once '../../class/type.php';
        
        $database = new Database();
        
        $db = $database->getConnection();

        $items = new Type($db);

        $stmt = $items->getType();
        
        $typeCount = $stmt->rowCount();

        if($typeCount > 0)
        {    
            $typeArr = array();
            $typeArr["message"] =  true;
            $typeArr["typeCount"] =  array($typeCount);
            $typeArr["type"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array("id" => $id,
                            "type" => $type,
                            "timestamp" => $timestamp
                        );

                array_push($typeArr["type"], $e);
            }
            return $typeArr;
        }
        else
        {
            return $typeArr = array("message" => "No record found.");
        }
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