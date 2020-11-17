<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow_Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Header: Content-Type, Access-Content-Allow-Headers, Authorization, X-Requested-With");

//get database connection
include_once '../config/database.php';

//instantiate product object
include_once '../objects/batch.php';

$database =new Database();
$db = $database->getConnection();

$batch = new Batch($db);

//get posted data
$data = json_decode(file_get_contents("php://input"));

$batch->batch_id = $data->batch_id;

//delete the batch
if($batch->delete($batch->batch_id)){
    //set response code 201
    http_response_code(201);
    //return success message to user
    echo json_encode(array("message" => "Batch delete successfully"));
 }else{

    //set response 503
    http_response_code(503);

    //tell the user that batch creation was unsuccessful
    echo json_encode(array("message" => "Batch delete unsuccessful"));



 }



?>