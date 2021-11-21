<?php
   
   header("Access-Control-Allow-Origin: *");
    
   header("Content-Type: application/json; charset=UTF-8");
   
   header("Access-Control-Allow-Methods: POST");
   
   header("Access-Control-Max-Age: 3600");
   
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

   $request = $_SERVER['REQUEST_METHOD'];

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
               response(upload());
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

   
   function upload()
   {
        $departmentIconArr = array();
        $upload_dir = 'bannerImages/';
        $server_url = 'https://businessbook.co.in/api/api/banner';

        //echo $_POST['id'];

        if($_FILES['banner'])
        {
            $avatar_name = $_FILES["banner"]["name"];
            $avatar_tmp_name = $_FILES["banner"]["tmp_name"];
            $error = $_FILES["banner"]["error"];

            if($error > 0)
            {
                return $departmentIconArr = array("status" => "error",
                                                    "error" => true,
                                                    "message" => "Error uploading the file!"
                                                );
            }
            else 
            {
                $random_name = rand(1000,1000000)."-".$avatar_name;
                $upload_name = $upload_dir.strtolower($random_name);
                $upload_name = preg_replace('/\s+/', '-', $upload_name);

                if(move_uploaded_file($avatar_tmp_name , $upload_name)) 
                {
                    return $departmentIconArr = array("status" => "success",
                                                        "error" => false,
                                                        "message" => "File uploaded successfully",
                                                        "image_url" => $server_url."/".$upload_name
                                                    );
                }
                else
                {
                    return $departmentIconArr = array("status" => "error",
                                                        "error" => true,
                                                        "message" => "Error uploading the file!"
                                                    );
                }
            }    
        }
        else
        {
            return $departmentIconArr = array(  "status" => "error",
                                                "error" => true,
                                                "message" => "No file was sent!"
                                            );
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