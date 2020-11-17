<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and batch object
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/steps.php';

$database =new Database();
$db = $database->getConnection();

$step = new Steps($db);

$data = json_decode(file_get_contents("php://input"));

$step_arr = array();
$step_arr["records"] = array();

$worksheet_id = $data->worksheet_id;

$step_arr = $step->search($worksheet_id);

if(!empty($step)){

    http_response_code(200);

    echo json_encode($step_arr);
    
} else{
	
    http_response_code(404);
	
    echo json_encode(array("message" => "No steps found"));
   
}

?>