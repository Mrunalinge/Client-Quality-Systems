<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow_Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Header: Content-Type, Access-Content-Allow-Headers, Authorization, X-Requested-With");


//get database connection
include_once '../config/database.php';

//instantiate product object
include_once '../objects/worksheet.php';

$database =new Database();
$db = $database->getConnection();

$wksht = new Worksheet($db);
//get posted data
$data = json_decode(file_get_contents("php://input"));
//echo $_POST['product_code'];
echo $data->product_code;
//make sure data is not empty
if( //$data->batch_id != NULL
    !empty($data->product_code) 
   
){
   // $wksht->worksheet_id = 7;//$data->worksheet_id;
    $wksht->product_code = $data->product_code;
    $wksht->min_pen = $data->min_pen;
	$wksht->max_pen = $data->max_pen;
    $wksht->customer = $data->customer;
    $wksht->weight = $data->weight;
    $wksht->notes = $data->notes;

    if($wksht->create()){

        //set response code 201
        http_response_code(201);
        //return success message to user
        echo json_encode(array("message" => "Worksheet created successfully"));
     }else{
    
        //set response 503
        http_response_code(503);
    
        //tell the user that batch creation was unsuccessful
        echo json_encode(array("message" => "Worksheet create unsuccessful"));
    
    
    
     }
    
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Worksheet create unsuccessful data incomplete"));
         
}



//echo $send_step;
//echo $send_ingredient;

//ingridients insertion
$send_ingredient = json_encode($data->ingredients);
$url_ingredient = "http://localhost/api/ingredients/create.php";
$curl = curl_init($url_ingredient);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POST,true);
curl_setopt($curl, CURLOPT_POSTFIELDS,$send_ingredient);
//curl_setopt($curl, CURLOPT_URL, $url);

curl_setopt($curl, CURLOPT_HTTPHEADER,['Content-Type: application/json']);
$result= curl_exec($curl);
echo $result;
curl_close($curl);

//Steps insertion
$send_step= json_encode($data->steps);
$url = "http://localhost/api/steps/create.php";   
$curl = curl_init($url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POST,true);

curl_setopt($curl, CURLOPT_POSTFIELDS,$send_step);
//curl_setopt($curl, CURLOPT_URL, $url);

curl_setopt($curl, CURLOPT_HTTPHEADER,['Content-Type: application/json']);
$result= curl_exec($curl);
//echo $result;
curl_close($curl);

 

?>


