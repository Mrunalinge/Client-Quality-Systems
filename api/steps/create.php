<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow_Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Header: Content-Type, Access-Content-Allow-Headers, Authorization, X-Requested-With");


//get database connection
include_once '../config/database.php';

//instantiate product object
include_once '../objects/steps.php';

$database =new Database();
$db = $database->getConnection();

$step = new Steps($db);
//get posted data
$data = json_decode(file_get_contents("php://input"));
//echo $_POST['product_code'];
echo $data[0]->key_;

$len = count($data);
echo $len;
//echo $data->batch_id;
//make sure data is not empty
if( //$data->batch_id != NULL
    !empty($data) 
){
    foreach($data as $obj){
      $step_index = $obj->key_;  
      echo $step_index;
      $step_text = $obj->value_;
      echo $step_text;
      $step->step_index = $step_index;
      $step->step_text = $step_text; 
      if($step->create()){

        //set response code 201
        http_response_code(201);
        //return success message to user
        echo json_encode(array("message" => "step created successfully"));
     }else{
    
        //set response 503
        http_response_code(503);
    
        //tell the user that batch creation was unsuccessful
        echo json_encode(array("message" => "step create unsuccessful"));   
     } 
    }  
}else{
    http_response_code(400);
    echo json_encode(array("message" => "step create unsuccessful data incomplete"));
         
}
 

?>


