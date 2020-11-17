<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");  //charset=UTF-8"
include_once '../config/database.php';
include_once '../objects/users.php';

$database = new Database();
$db = $database->getConnection();

$users = new Users($db);

$user_arr = array();
$user_arr["records"] = array();
$users_arr = $users->readUser();
if(!empty($user_arr)){
    //create array
    //set http response code 200 OK
    http_response_code(200);

    //make it json format
    echo json_encode($users_arr);
    
}
else{
     //set response 404 not found
     http_response_code(404);
     //tell the user product does not exist
     echo json_encode(array("message" => "Users does not exist"));
}

?>

