<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");  //charset=UTF-8"
include_once '../config/database.php';
include_once '../objects/batch.php';

$database = new Database();
$db = $database->getConnection();


//initialize object
$adjust = new Adjustment($db);

$adjust->adjust_id = isset($_GET['adjust_id']) ? $_GET['adjust_id'] : die();

$adjust->readOne($adjust->adjust_id);
if($adjust->adjust_id!= NULL){
    //create array
    $adjust_arr = array("adjustID" => $adjust->adjust_id,
                       "batchID" => $adjust->batch_id,
                       "adjust_type" => $adjust->adjust_type,
                       "adjust_text" => $adjust->adjust_text,
                       "chronology" => $adjust->chronology
                       
);
    //set http response code 200 OK
    http_response_code(200);

    //make it json format
    echo json_encode($adjust_arr);
    
}
else{
     //set response 404 not found
     http_response_code(404);
     //tell the user product does not exist
     echo json_encode(array("message" => "Adjustment does not exist"));
}




?>