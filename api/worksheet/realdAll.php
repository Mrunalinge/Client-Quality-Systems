<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");  //charset=UTF-8"
include_once '../config/database.php';
include_once '../objects/worksheet.php';

$database =new Database();
$db = $database->getConnection();

$wksht = new Worksheet($db);
//get posted data
$data = json_decode(file_get_contents("php://input"));

?>