<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");  //charset=UTF-8"
include_once '../config/database.php';
include_once '../objects/worksheet.php';

$database = new Database();
$db = $database->getConnection();


//initialize object
$wksht = new Worksheet($db);

$wksht->worksheet_id = isset($_GET['worksheet_id']) ? $_GET['worksheet_id'] : die();

$wksht->readOne($wksht->worksheet_id);
if($wksht->product_code!= NULL){
    //create array
    $worksheet_arr = array("product_code" => $wksht->product_code,
                       "worksheet_id" => $wksht->worksheet_id,
                       "weight" => $wksht->weight,
                       "customer" => $wksht->customer,
                       "desired_pen" => $wksht->desired_pen,
                       "notes" => $wksht->notes
);
    //set http response code 200 OK
    http_response_code(200);

    //make it json format
    echo json_encode($worksheet_arr);
    
}
else{
     //set response 404 not found
     http_response_code(404);
     //tell the user product does not exist
     echo json_encode(array("message" => "Batch does not exist"));
}




?>