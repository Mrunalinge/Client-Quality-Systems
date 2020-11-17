<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow_Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Header: Content-Type, Access-Content-Allow-Headers, Authorization, X-Requested-With");


//get database connection
include_once '../config/database.php';

//instantiate product object
include_once '../objects/adjustment.php';

$database =new Database();
$db = $database->getConnection();

$adjust = new Adjustment($db);
//get posted data
$data = json_decode(file_get_contents("php://input"));
//echo $_POST['product_code'];
//echo $data->product_code;
//echo $data->batch_id;
//make sure data is not empty
if( //$data->batch_id != NULL
    !empty($data)
   
){
   // $wksht->worksheet_id = 7;//$data->worksheet_id;
    //$adjust->adjust_id = $data->adjust_id; 
	foreach($data as $obj){
	  $adjust->adjust_type = $obj->adjust_type;
	  $adjust->adjust_text = $obj->adjust_text;
	  $adjust->chronology = $obj->chronology;

	  if($adjust->create()){

        //set response code 201
        http_response_code(201);
        //return success message to user
        echo json_encode(array("message" => "Adjustment created successfully"));
      }else{
    
        //set response 503
        http_response_code(503);
    
        //tell the user that batch creation was unsuccessful
        echo json_encode(array("message" => "Adjustment create unsuccessful"));
    
    
	  }
    }
    
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Adjustment create unsuccessful data incomplete"));
         
}


 

?>


