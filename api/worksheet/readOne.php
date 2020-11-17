<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and batch object
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/worksheet.php';

$database =new Database();
$db = $database->getConnection();

$wksht = new Worksheet($db);

$data = json_decode(file_get_contents("php://input"));

$worksheet_arr = array();
$worksheet_arr["records"] = array();

$worksheet_id = $data->worksheet_id;

$worksheet_arr = $wksht->readOne($worksheet_id);

// check if more than 0 records found
if(!empty($wksht)){
    //set response
    http_response_code(200);

    echo json_encode($worksheet_arr);
    

} else{
    //set response code
    http_response_code(404);
    echo json_encode(array("message" => "No worksheet found"));
   
}

?>