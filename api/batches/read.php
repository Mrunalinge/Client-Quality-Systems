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
$batch = new Batch($db);

$batch->batch_id = isset($_GET['batch_id']) ? $_GET['batch_id'] : die();

$batch->readOne($batch->batch_id);
if($batch->product_code!= NULL){
    //create array
    $batch_arr = array("batchID" => $batch->batch_id,
                       "product_code" => $batch->product_code,
                       "worksheet_id" => $batch->worksheet_id,
                       "created_date" => $batch->created_date,
                       "batch_size" => $batch->batch_size,
                       "sponge_wt" => $batch->sponge_wt,
                       "initial_ph" => $batch->initial_ph,
                       "am_pen" => $batch->am_pen,
                       "dp" => $batch->dp,
                       "deleted" => $batch->deleted,
                       "last_modified" => $batch->last_modified
);
    //set http response code 200 OK
    http_response_code(200);

    //make it json format
    echo json_encode($batch_arr);
    
}
else{
     //set response 404 not found
     http_response_code(404);
     //tell the user product does not exist
     echo json_encode(array("message" => "Batch does not exist"));
}




?>