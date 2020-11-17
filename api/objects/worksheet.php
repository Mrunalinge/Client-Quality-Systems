<?php

class Worksheet{
    //connection
    private $conn;

    private $table_name = "WORKSHEET";

    //properties of batches table
    public $worksheet_id;
    public $product_code;
    public $weight;
    public $customer;
    public $desired_pen;
    public $notes;

    public function __construct($db){
        $this->conn = $db;
    }

    function readOne($worksheet_id_){
       
        $query = "SELECT * FROM " . $this->table_name . " WHERE worksheet_id=$worksheet_id_";
        //prepare query statment
        $stmt = $this->conn->prepare($query);

        //bind the id of the product to be read
        $stmt->bindParam(1,$this->id);

        //execute query
        $stmt->execute();

        //get the retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values in variables
        $this->worksheet_id = $row['worksheet_id'];
        $this->product_code = $row['product_code'];
        $this->weight = $row['weight'];
        $this->customer = $row['customer'];
        $this->desired_pen= $row['desired_pen'];
        $this->notes = $row['notes'];
        
    }

    function readAll(){
        $query = "SELECT s.step_text, s.step_index, a.ingredient_amt, a.ingredient_unit, a.ingredient_material, w.worksheet_id, w.product_code,w.weight,w.customer, w.desired_pen, 
        w.notes FROM " . $this->table_name ." w LEFT JOIN INGREDIENTS a ON a.worksheet_id = w.worksheet_id LEFT JOIN STEPS s s.worksheet_id = w.worksheet_id  ";

    }
    function create(){
        $query = "INSERT INTO " . $this->table_name ." SET product_code=:product_code, weight=:weight, customer=:customer, desired_pen=:desired_pen, notes=:notes";
        $stmt = $this->conn->prepare($query);
        //worksheet_id=:worksheet_id,
        //sanitize
       // $this->worksheet_id= htmlspecialchars(strip_tags($this->worksheet_id));
        $this->product_code= htmlspecialchars(strip_tags($this->product_code));
        $this->weight= htmlspecialchars(strip_tags($this->weight));
        $this->customer= htmlspecialchars(strip_tags($this->customer));
        $this->desired_pen= htmlspecialchars(strip_tags($this->desired_pen));
        $this->notes= htmlspecialchars(strip_tags($this->notes));
        

        //bind variables
       // $stmt->bindParam(":worksheet_id", $this->worksheet_id);
        $stmt->bindParam(":product_code", $this->product_code);
        $stmt->bindParam(":weight", $this->weight);
        $stmt->bindParam(":customer", $this->customer);
        $stmt->bindParam(":desired_pen", $this->desired_pen);
        $stmt->bindParam(":notes", $this->notes);

        //execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    function search_option($option,$keyword){

        $worksheet_arr = array();
        $worksheet_arr["records"] = array();

        $query = "SELECT * FROM " . $this->table_name . " WHERE $option LIKE '$keyword'";
       // echo $query;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        //sanitize
        //$keywords = htmlspecialchars(strip_tags($keywords));
        //$keywords = "%{$keywords}%";

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $this->product_code = $row['product_code'];
            $this->worksheet_id = $row['worksheet_id'];
            $this->customer = $row['customer'];
            $this->weight = $row['weight'];
            $this->desired_pen= $row['desired_pen'];
            $this->notes = $row['notes'];
              
            if($this->worksheet_id!= NULL){
        $worksheet_item = array("worksheet_id" => $this->worksheet_id,
        "product_code" => $this->product_code,
        "customer" => $this->customer,
        "weight" => $this->weight,
        "desired_pen" => $this->desired_pen,
        "notes" => $this->notes);

        array_push($worksheet_arr["records"], $worksheet_item);
        }
        }
       
        //echo $this->batch_id;
       return $worksheet_arr;

    }
}
?>