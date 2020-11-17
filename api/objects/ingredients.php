<?php

class Ingredients{
    //connection
    private $conn;

    private $table_name = "INGREDIENT";
    private $table_foreign_key = "WORKSHEET";

    //properties of steps table
    public $worksheet_id;
    public $ingredient_id;
    public $ingredient_amt;
    public $ingredient_unit;
    public $ingredient_mtrl;
    public $difference;

  

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
       $query_read = "SELECT * FROM " . $this->table_foreign_key ." ORDER BY worksheet_id DESC LIMIT 1";
       $stmt_read = $this->conn->prepare($query_read);
       $stmt_read->bindParam(1,$this->worksheet_id);
       $stmt_read->execute();
       $row = $stmt_read->fetch(PDO::FETCH_ASSOC);
       $this->worksheet_id = $row['worksheet_id'];
       echo "WKSHT ID";
       echo $this->worksheet_id;
      //  $query = "INSERT INTO " . $this->table_name ." SET ingredient_amount=:ingredient_amount, ingredient_unit=:ingredient_unit, ingredient_material=:ingredient_material";
        $query = "INSERT INTO " . $this->table_name ." SET worksheet_id= :worksheet_id, ingredient_amt= :ingredient_amt, ingredient_unit= :ingredient_unit, ingredient_mtrl= :ingredient_mtrl";
        $stmt = $this->conn->prepare($query);
        //worksheet_id=:worksheet_id,
        //sanitize
        $this->ingredient_amt= htmlspecialchars(strip_tags($this->ingredient_amt));
        $this->ingredient_unit= htmlspecialchars(strip_tags($this->ingredient_unit));
        $this->ingredient_mtrl= htmlspecialchars(strip_tags($this->ingredient_mtrl));
       // $this->worksheet_id= htmlspecialchars(strip_tags($this->worksheet_id));
     
        //bind variables
       // $stmt->bindParam(":worksheet_id", $this->worksheet_id);
        $stmt->bindParam(":ingredient_amt", $this->ingredient_amt);
        $stmt->bindParam(":ingredient_unit", $this->ingredient_unit);
        $stmt->bindParam(":ingredient_mtrl", $this->ingredient_mtrl);
        $stmt->bindParam(":worksheet_id", $this->worksheet_id);
       
        //execute query
        if($stmt->execute()){
           // echo "here inside";
            return true;
        }
        return false;
    }
}
?>