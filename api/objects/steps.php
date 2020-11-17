<?php

class Steps{
    //connection
    private $conn;

    private $table_name = "STEP";
    private $table_foreign_key = "WORKSHEET";


    //properties of steps table
    public $worksheet_id;
    public $step_id;
    public $step_index;
    public $step_text;
  

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

        $query = "INSERT INTO " . $this->table_name ." SET worksheet_id= :worksheet_id, step_index=:step_index, step_text=:step_text";
        $stmt = $this->conn->prepare($query);
        //worksheet_id=:worksheet_id,
        //sanitize
        $this->step_index= htmlspecialchars(strip_tags($this->step_index));
        $this->step_text= htmlspecialchars(strip_tags($this->step_text));
        
        //bind variables
        $stmt->bindParam(":worksheet_id", $this->worksheet_id);
        $stmt->bindParam(":step_index", $this->step_index);
        $stmt->bindParam(":step_text", $this->step_text);

        //execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>