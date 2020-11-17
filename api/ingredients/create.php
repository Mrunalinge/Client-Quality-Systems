<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow_Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Header: Content-Type, Access-Content-Allow-Headers, Authorization, X-Requested-With");


//get database connection
include_once '../config/database.php';

//instantiate product object
include_once '../objects/ingredients.php';

$database =new Database();
$db = $database->getConnection();

$ingredient = new Ingredients($db);
//get posted data
$data = json_decode(file_get_contents("php://input"));
//echo $_POST['product_code'];
echo $data[0]->material_;

//$len = count($data);
//echo $len;
//echo $data->batch_id;
//make sure data is not empty
if( //$data->batch_id != NULL
    !empty($data) 
){
    foreach($data as $obj){
        $ingredient_amount = $obj->amount_;
        echo $ingredient_amount;
        $ingredient_unit =  $obj->unit_;
        echo $ingredient_unit;
        $ingredient_material = $obj->material_; 
        echo $ingredient_material;
        $ingredient->ingredient_amt = $ingredient_amount;
        $ingredient->ingredient_unit = $ingredient_unit;
        $ingredient->ingredient_mtrl = $ingredient_material; 
		$ingredient->difference = 0;
      if($ingredient->create()){

        //set response code 201
        http_response_code(201);
        //return success message to user
        echo json_encode(array("message" => "Ingredient created successfully"));
     }else{
    
        //set response 503
        http_response_code(503);
    
        //tell the user that batch creation was unsuccessful
        echo json_encode(array("message" => "Ingredient create unsuccessful"));   
     } 
    }  
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Ingredient create unsuccessful data incomplete"));
         
}
 

?>


