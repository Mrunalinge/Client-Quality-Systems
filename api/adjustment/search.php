<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and batch object
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/adjustment.php';

$database =new Database();
$db = $database->getConnection();

$adjust = new Adjustment($db);

//get keyword
$data = json_decode(file_get_contents("php://input"));
$keyword = $data->batch_id;

//query batch
$adjust_arr = array();
$adjust_arr = $adjust->search($keyword);

if(!empty($adjust_arr)){
    //set response
    http_response_code(200);

    echo json_encode($adjust_arr);

} else{
    //set response code
    http_response_code(404);
    echo json_encode(array("message" => "No adjustment found"));
}

?>