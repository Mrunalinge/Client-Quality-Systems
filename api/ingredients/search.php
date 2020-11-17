<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and batch object
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/ingredients.php';

$database =new Database();
$db = $database->getConnection();

$ingredient = new Ingredients($db);

$data = json_decode(file_get_contents("php://input"));

$ingredient_arr = array();
$ingredient_arr["records"] = array();

$worksheet_id = $data->worksheet_id;

$ingredient_arr = $ingredient->search($worksheet_id);

if(!empty($ingredient)){

    http_response_code(200);

    echo json_encode($ingredient_arr);
    
} else{
	
    http_response_code(404);
	
    echo json_encode(array("message" => "No ingredients found"));
   
}

?>