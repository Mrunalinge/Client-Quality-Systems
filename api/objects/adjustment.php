<?php
//get database connection
include_once '../config/database.php';
class Adjustment{
    //db connection variable and table name
    private $conn;
    //private $table_name ="batches";
    private $table_name ="ADJUSTMENT";
	private $table_foreign_key = "BATCH";
    //properties of batches table

    public $adjust_id;  //Unique ID of the batch, hidden from the user
    public $batch_id; //identifies the type of product being created
    public $adjust_type; //Unique ID of the corresponding manufacturing worksheet
    public $adjust_text; //Date that the batch was created
    public $chronology; //The size of the batch in pounds
 
    
    //constructor with $db as connection
    public function __construct($db){
        $this->conn = $db;
    }

    function readOne($batch_id_){
       
        $query = "SELECT * FROM " . $this->table_name . " WHERE batch_id=$batch_id_";
        //prepare query statment
        $stmt = $this->conn->prepare($query);

        //bind the id of the product to be read
        $stmt->bindParam(1,$this->id);

        //execute query
        $stmt->execute();

        //get the retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values in variables
        $this->adjust_id = $row['adjust_id'];
        $this->batch_id = $row['batch_id'];
        $this->adjust_type = $row['adjust_type'];
        $this->adjust_text = $row['adjust_text'];
        $this->chronology= $row['chronology'];
        
    }

    function create(){
		$query_read = "SELECT * FROM " . $this->table_foreign_key ." ORDER BY batch_id DESC LIMIT 1";
        $stmt_read = $this->conn->prepare($query_read);
        $stmt_read->bindParam(1,$this->batch_id);
        $stmt_read->execute();
        $row = $stmt_read->fetch(PDO::FETCH_ASSOC);
        $this->batch_id = $row['batch_id'];
		
      //  echo $this->product_code;
        //query to insert
        // $query = "INSERT INTO " .$this->table_name ." SET 
        //  product_code=:product_code, batch_num=:batch_num ,created_date=:created_date,batch_size=:batch_size, sponge_wt=:sponge_wt, initial_ph=:initial_ph, am_pen=:am_pen, dp=:dp,last_modified=:last_modified ,notes=:notes"; 
        $query = "INSERT INTO ". $this->table_name ." SET batch_id=:batch_id, adjust_type=:adjust_type, adjust_text=:adjust_text, chronology=:chronology"; 
        echo $query;
         //, worksheet_id=:worksheet_id 
        // $query= "INSERT INTO " .$this->table_name ." (batch_id, product_code, worksheet_id, date, batch_size, sponge_wt, initial_ph, am_pen, , deleted=:deleted
        // dp, deleted, last_modified)
        // VALUES ('$this->batch_id', ' $this->product_code', '$this->worksheet_id', '$this->date', '$this->batch_size', '$this->sponge_wt',
        // '$this->initial_ph', '$this->am_pen', '$this->dp', '$this->deleted', '$this->last_modified')";
         $stmt= $this->conn->prepare($query);
         

        //sanitize
       // $this->batch_id= htmlspecialchars(strip_tags($this->batch_id));
        $this->batch_id= htmlspecialchars(strip_tags($this->batch_id));
        $this->adjust_type= htmlspecialchars(strip_tags($this->adjust_type));
        $this->adjust_text= htmlspecialchars(strip_tags($this->adjust_text));
        $this->chronology= htmlspecialchars(strip_tags($this->chronology));
        

        //bind value
       // $stmt->bindParam(":batch_id", $this->batch_id);
        $stmt->bindParam(":batch_id", $this->batch_id);
        $stmt->bindParam(":adjust_type", $this->adjust_type);
        $stmt->bindParam(":adjust_text", $this->adjust_text);
        $stmt->bindParam(":chronology", $this->chronology);
        

        //execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
	
	function createWithID(){
      //  echo $this->product_code;
        //query to insert
        // $query = "INSERT INTO " .$this->table_name ." SET 
        //  product_code=:product_code, batch_num=:batch_num ,created_date=:created_date,batch_size=:batch_size, sponge_wt=:sponge_wt, initial_ph=:initial_ph, am_pen=:am_pen, dp=:dp,last_modified=:last_modified ,notes=:notes"; 
        $query = "INSERT INTO ". $this->table_name ." SET batch_id=:batch_id, adjust_type=:adjust_type, adjust_text=:adjust_text, chronology=:chronology"; 
        echo $query;
         //, worksheet_id=:worksheet_id 
        // $query= "INSERT INTO " .$this->table_name ." (batch_id, product_code, worksheet_id, date, batch_size, sponge_wt, initial_ph, am_pen, , deleted=:deleted
        // dp, deleted, last_modified)
        // VALUES ('$this->batch_id', ' $this->product_code', '$this->worksheet_id', '$this->date', '$this->batch_size', '$this->sponge_wt',
        // '$this->initial_ph', '$this->am_pen', '$this->dp', '$this->deleted', '$this->last_modified')";
         $stmt= $this->conn->prepare($query);
         

        //sanitize
       // $this->batch_id= htmlspecialchars(strip_tags($this->batch_id));
        $this->batch_id= htmlspecialchars(strip_tags($this->batch_id));
        $this->adjust_type= htmlspecialchars(strip_tags($this->adjust_type));
        $this->adjust_text= htmlspecialchars(strip_tags($this->adjust_text));
        $this->chronology= htmlspecialchars(strip_tags($this->chronology));
        

        //bind value
       // $stmt->bindParam(":batch_id", $this->batch_id);
        $stmt->bindParam(":batch_id", $this->batch_id);
        $stmt->bindParam(":adjust_type", $this->adjust_type);
        $stmt->bindParam(":adjust_text", $this->adjust_text);
        $stmt->bindParam(":chronology", $this->chronology);
        

        //execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function search($keyword){
		$adjust_arr = array();
        $adjust_arr["records"] = array();

        $query = "SELECT * FROM " . $this->table_name . " WHERE batch_id LIKE '$keyword'";
        //echo $query;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        //sanitize
        //$keywords = htmlspecialchars(strip_tags($keywords));
        //$keywords = "%{$keywords}%";

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $this->adjust_id = $row['adjust_id'];
            $this->batch_id = $row['batch_id'];
            $this->adjust_type = $row['adjust_type'];
            $this->adjust_text = $row['adjust_text'];
            $this->chronology = $row['chronology'];   
            if($this->adjust_id != NULL){
				$adjust_item = array("adjust_id" => $this->adjust_id,
				"batch_id" => $this->batch_id,
				"adjust_type" => $this->adjust_type,
				"adjust_text" => $this->adjust_text,
				"chronology" => $this->chronology);

				array_push($adjust_arr["records"], $adjust_item);
	    }
	}
       
        return $adjust_arr;
    }
	
    function clear($batch_id_){
	$query = "DELETE FROM " . $this->table_name . " WHERE batch_id=$batch_id_";
        //prepare query statment
        $stmt = $this->conn->prepare($query);

        //bind the id of the product to be read
        $stmt->bindParam(1,$this->id);

        //execute query
        $stmt->execute();
    }

}

?>
