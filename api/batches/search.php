<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and batch object
include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/batch.php';

$database =new Database();
$db = $database->getConnection();

$batch = new Batch($db);

//$keywords =json_decode(file_get_contents("php://input"));
//get keywords


$data = json_decode(file_get_contents("php://input"));
//echo $data->option;
//echo $data->search;
//$keywords = isset($_GET["s"]) ? $_GET["s"] : "";

//query batch
//$stmt = $batch->search($keywords);
//$num = $stmt->rowCount();

$batch_arr = array();
$batch_arr["records"] = array();
//$batch_arr = $batch->search($keywords);
$keyword = $data->search;
$option = $data->option;
if($option == "0"){
    $option = "product_code";
}else if($option == "1"){
    $option = "created_date";
}else if($option == "2"){
    $option = "batch_num";
}else if($option == "3"){
	$option = "batch_id";
}
$batch_arr = $batch->search_option($option, $keyword);
//echo $batch_arr;

// check if more than 0 records found
if(!empty($batch_arr)){
    //set response
    http_response_code(200);

    echo json_encode($batch_arr);
    

} else{
    //set response code
    http_response_code(404);
    echo json_encode(array("message" => "No batch found"));
   
}

?>
