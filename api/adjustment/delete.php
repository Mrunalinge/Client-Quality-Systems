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
include_once '../objects/adjustment.php';

$database =new Database();
$db = $database->getConnection();

$adjust = new Adjustment($db);

//get posted data
$data = json_decode(file_get_contents("php://input"));

$adjust->adjust_id = $data->adjust_id;

//delete the batch
if($adjust->delete($adjust->adjust_id)){
    //set response code 201
    http_response_code(201);
    //return success message to user
    echo json_encode(array("message" => "Adjustments delete successfull"));
 }else{

    //set response 503
    http_response_code(503);

    //tell the user that batch creation was unsuccessful
    echo json_encode(array("message" => "Adjustments delete unsuccessful"));



 }



?>