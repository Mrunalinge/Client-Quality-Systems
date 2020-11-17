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

//$keywords =json_decode(file_get_contents("php://input"));
//get keywords


$data = json_decode(file_get_contents("php://input"));
//echo $data->option;
//echo $data->search;
//$keywords = isset($_GET["s"]) ? $_GET["s"] : "";

//query batch
//$stmt = $batch->search($keywords);
//$num = $stmt->rowCount();

$worksheet_arr = array();
$worksheet_arr["records"] = array();
//$batch_arr = $batch->search($keywords);
$keyword = $data->search;
$option = "product_code";
//$option = $data->option;
// if($option == "Code No."){
//     $option = "product_code";
// }else if($option == "Date of Manufacture"){
//     $option = "created_date";
// }else if($option == "Batch Number"){
//     $option = "batch_num";
// }
$worksheet_arr = $wksht->search_option($option, $keyword);
//echo $batch_arr;

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