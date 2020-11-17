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

if( //$data->batch_id != NULL
   // !empty($data->batch_id) //&&
     !empty($data->batch_id) //&&
    // !empty($data->worksheet_id) &&
    // !empty($data->date) &&
    // !empty($data->batch_size) &&
    // !empty($data->sponge_wt) &&
    // !empty($data->initial_ph) &&
    // !empty($data->am_pen) &&
    // !empty($data->dp) &&
    // !empty($data->deleted) &&
    // !empty($data->last_modified)
){
	$batch->batch_id = $data->batch_id;
    $batch->product_code = $data->product_code;
    $batch->worksheet_id = $data->worksheet_id;
    $batch->created_date = date('Y-m-d'); // $data->date;
    $batch->batch_size = $data->batch_size;
    $batch->batch_num = $data->batch_num;
    $batch->sponge_wt = $data->sponge_wt;
    $batch->initial_ph = $data->initial_ph;
    $batch->am_pen = $data->am_pen;
    $batch->dp = $data->dp;
    $batch->notes = $data->notes;
    $batch->deleted = $data->deleted;
    $batch->last_modified =  date('Y-m-d H:i:s');

    if($batch->update()){

        //set response code 201
        http_response_code(201);
        //return success message to user
        echo json_encode(array("message" => "Batch updated successfully"));
     }else{
    
        //set response 503
        http_response_code(503);
    
        //tell the user that batch creation was unsuccessful
        echo json_encode(array("message" => "Batch update unsuccessful"));
    
     }
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Batch create unsuccessful data incomplete"));
}

if(!$data->adjustments){
	return;
}

$send_adjustments = json_encode($data->adjustments);

$url_adjustments = "https://localhost/api/adjustment/update.php";
$curl = curl_init($url_adjustments);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POST,true);
curl_setopt($curl, CURLOPT_POSTFIELDS,$send_adjustments);

curl_setopt($curl, CURLOPT_HTTPHEADER,['Content-Type: application/json']);
$result= curl_exec($curl);
echo $result;
curl_close($curl);

?>
