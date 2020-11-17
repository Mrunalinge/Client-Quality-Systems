<?php
//get database connection
include_once '../config/database.php';
class Batch{
    //db connection variable and table name
    private $conn;
    //private $table_name ="batches";
    private $table_name ="BATCH";
    //properties of batches table

    public $batch_id;  //Unique ID of the batch, hidden from the user
    public $product_code; //identifies the type of product being created
    public $worksheet_id; //Unique ID of the corresponding manufacturing worksheet
    public $created_date; //Date that the batch was created
    public $batch_size; //The size of the batch in pounds
    public $sponge_wt; //Another size value
    public $initial_ph; //The initial Ph value of the product
    public $am_pen;  //Penetration value of the product after cooling
    public $dp;  //Result of the dropping point test
    public $deleted; //Whether or not this record is marked as “deleted.” If marked as deleted, it will
    public $last_modified; //DATETIME - Date and time that this record was last modified. This field will be used to determine when to remove a deleted record
    public $batch_num;
    public $notes;
    
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
        $this->batch_id = $row['batch_id'];
        $this->product_code = $row['product_code'];
        $this->worksheet_id = $row['worksheet_id'];
        $this->created_date = $row['created_date'];
        $this->batch_size= $row['batch_size'];
        $this->sponge_wt = $row['sponge_wt'];
        $this->initial_ph = $row['initial_ph'];
        $this->am_pen = $row['am_pen'];
        $this->dp = $row['dp'];
        $this->deleted= $row['deleted'];
        $this->last_modified= $row['last_modified'];
    }

    function create(){
      //  echo $this->product_code;
        //query to insert
        // $query = "INSERT INTO " .$this->table_name ." SET 
        //  product_code=:product_code, batch_num=:batch_num ,created_date=:created_date,batch_size=:batch_size, sponge_wt=:sponge_wt, initial_ph=:initial_ph, am_pen=:am_pen, dp=:dp,last_modified=:last_modified ,notes=:notes"; 
        $query = "INSERT INTO ". $this->table_name ." SET product_code=:product_code, worksheet_id=:worksheet_id, created_date=:created_date, batch_num=:batch_num, batch_size=:batch_size, sponge_wt=:sponge_wt, initial_ph=:initial_ph, am_pen=:am_pen, dp=:dp, notes=:notes, deleted=:deleted, last_modified=:last_modified"; 
        echo $query;
         //, worksheet_id=:worksheet_id 
        // $query= "INSERT INTO " .$this->table_name ." (batch_id, product_code, worksheet_id, date, batch_size, sponge_wt, initial_ph, am_pen, , deleted=:deleted
        // dp, deleted, last_modified)
        // VALUES ('$this->batch_id', ' $this->product_code', '$this->worksheet_id', '$this->date', '$this->batch_size', '$this->sponge_wt',
        // '$this->initial_ph', '$this->am_pen', '$this->dp', '$this->deleted', '$this->last_modified')";
         $stmt= $this->conn->prepare($query);
         

        //sanitize
       // $this->batch_id= htmlspecialchars(strip_tags($this->batch_id));
        $this->product_code= htmlspecialchars(strip_tags($this->product_code));
        $this->worksheet_id= htmlspecialchars(strip_tags($this->worksheet_id));
        $this->created_date= htmlspecialchars(strip_tags($this->created_date));
        $this->batch_size= htmlspecialchars(strip_tags($this->batch_size));
        $this->sponge_wt= htmlspecialchars(strip_tags($this->sponge_wt));
        $this->initial_ph= htmlspecialchars(strip_tags($this->initial_ph));
        $this->am_pen= htmlspecialchars(strip_tags($this->am_pen));
        $this->dp= htmlspecialchars(strip_tags($this->dp));
        $this->deleted= htmlspecialchars(strip_tags($this->deleted));
        $this->last_modified= htmlspecialchars(strip_tags($this->last_modified));
        $this->batch_num= htmlspecialchars(strip_tags($this->batch_num));
        $this->notes= htmlspecialchars(strip_tags($this->notes));

        //bind value
       // $stmt->bindParam(":batch_id", $this->batch_id);
        $stmt->bindParam(":product_code", $this->product_code);
        $stmt->bindParam(":worksheet_id", $this->worksheet_id);
        $stmt->bindParam(":batch_size", $this->batch_size);
        $stmt->bindParam(":created_date", $this->created_date);
        $stmt->bindParam(":sponge_wt", $this->sponge_wt);
        $stmt->bindParam(":initial_ph", $this->initial_ph);
        $stmt->bindParam(":am_pen", $this->am_pen);
        $stmt->bindParam(":dp", $this->dp);
        $stmt->bindParam(":deleted", $this->deleted);
        $stmt->bindParam(":last_modified", $this->last_modified);
        $stmt->bindParam(":batch_num", $this->batch_num);
        $stmt->bindParam(":notes", $this->notes);

        //execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function update(){

        
        //query to update
        $query_ = "UPDATE " .$this->table_name ." SET 
         product_code=:product_code, worksheet_id=:worksheet_id, created_date=:created_date,batch_size=:batch_size, batch_num=:batch_num, sponge_wt=:sponge_wt, initial_ph=:initial_ph, am_pen=:am_pen, dp=:dp, notes=:notes, deleted=:deleted, last_modified=:last_modified WHERE batch_id=:batch_id"; 

        $stmt= $this->conn->prepare($query_);

        $this->batch_id= htmlspecialchars(strip_tags($this->batch_id));
        $this->product_code= htmlspecialchars(strip_tags($this->product_code));
        $this->worksheet_id= htmlspecialchars(strip_tags($this->worksheet_id));
        $this->created_date= htmlspecialchars(strip_tags($this->created_date));
        $this->batch_size= htmlspecialchars(strip_tags($this->batch_size));
		$this->batch_num= htmlspecialchars(strip_tags($this->batch_num));
        $this->sponge_wt= htmlspecialchars(strip_tags($this->sponge_wt));
        $this->initial_ph= htmlspecialchars(strip_tags($this->initial_ph));
        $this->am_pen= htmlspecialchars(strip_tags($this->am_pen));
        $this->dp= htmlspecialchars(strip_tags($this->dp));
		$this->notes= htmlspecialchars(strip_tags($this->notes));
        $this->deleted= htmlspecialchars(strip_tags($this->deleted));
        $this->last_modified= htmlspecialchars(strip_tags($this->last_modified));

         //bind value
         $stmt->bindParam(":batch_id", $this->batch_id);
         $stmt->bindParam(":product_code", $this->product_code);
         $stmt->bindParam(":worksheet_id", $this->worksheet_id);
         $stmt->bindParam(":batch_size", $this->batch_size);
         $stmt->bindParam(":created_date", $this->created_date);
		 $stmt->bindParam(":batch_num", $this->batch_num);
         $stmt->bindParam(":sponge_wt", $this->sponge_wt);
         $stmt->bindParam(":initial_ph", $this->initial_ph);
         $stmt->bindParam(":am_pen", $this->am_pen);
         $stmt->bindParam(":dp", $this->dp);
		 $stmt->bindParam(":notes", $this->notes);
         $stmt->bindParam(":deleted", $this->deleted);
         $stmt->bindParam(":last_modified", $this->last_modified);

        //execute query
        if($stmt->execute()){
            return true;
        }
        return false;
        

    }

    function delete($batch_id_){
        //delete query
        $query = "DELETE FROM " . $this->table_name ." WHERE batch_id=$batch_id_";
        //prepare query
        $stmt = $this->conn->prepare($query);
       
        //sanitize
        $this->batch_id= htmlspecialchars(strip_tags($this->batch_id));

        //bind params
        $stmt->bindParam(":batch_id", $this->batch_id);

        //execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function search($keywords){

        $batch_arr = array();
        $batch_arr["records"] = array();

        //echo $keywords;

        //query
        // $query = "SELECT * FROM " . $this->table_name . " WHERE batch_id LIKE " . $keywords . " OR product_code LIKE " . $keywords . " OR
        //  worksheet_id LIKE " . $keywords . " OR batch_size LIKE " . $keywords . " OR created_date LIKE " . $keywords . " OR sponge_wt LIKE " . $keywords . " 
        //  OR initial_ph LIKE " . $keywords . " OR am_pen LIKE " . $keywords . " OR dp LIKE " . $keywords . " OR deleted LIKE " . $keywords . "";
        $query = "SELECT * FROM " . $this->table_name . " WHERE batch_id LIKE '%$keywords%' OR product_code LIKE  '%$keywords%' OR
         worksheet_id LIKE '%$keywords%' OR batch_size LIKE '%$keywords%' OR created_date LIKE '%$keywords%' OR sponge_wt LIKE '%$keywords%' 
         OR initial_ph LIKE '%$keywords%' OR am_pen LIKE '%$keywords%' OR dp LIKE '%$keywords%' OR deleted LIKE '%$keywords%'";

         echo $query; 
        //prepare query
        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        //sanitize
        //$keywords = htmlspecialchars(strip_tags($keywords));
        //$keywords = "%{$keywords}%";

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $this->batch_id = $row['batch_id'];
            $this->product_code = $row['product_code'];
            $this->worksheet_id = $row['worksheet_id'];
            $this->created_date = $row['created_date'];
            $this->batch_size= $row['batch_size'];
            $this->sponge_wt = $row['sponge_wt'];
            $this->initial_ph = $row['initial_ph'];
            $this->am_pen = $row['am_pen'];
            $this->dp = $row['dp'];
            $this->deleted= $row['deleted'];
            $this->last_modified= $row['last_modified'];    

        $batch_item = array("batch_id" => $this->batch_id,
        "product_code" => $this->product_code,
        "worksheet_id" => $this->worksheet_id,
        "created_date" => $this->created_date,
        "batch_size" => $this->batch_size,
        "sponge_wt" => $this->sponge_wt,
        "initial_ph" => $this->initial_ph,
        "am_pen" => $this->am_pen,
        "dp" => $this->dp,
        "deleted" => $this->deleted,
        "last_modified" => $this->last_modified);

        array_push($batch_arr["records"], $batch_item);
        }
       
        echo $this->batch_id;

        //bind
        //  $stmt->bindParam(":batch_id", $this->batch_id);
        //  $stmt->bindParam(":product_code", $this->product_code);
        //  $stmt->bindParam(":worksheet_id", $this->worksheet_id);
        //  $stmt->bindParam(":batch_size", $this->batch_size);
        //  $stmt->bindParam(":created_date", $this->created_date);
        //  $stmt->bindParam(":sponge_wt", $this->sponge_wt);
        //  $stmt->bindParam(":initial_ph", $this->initial_ph);
        //  $stmt->bindParam(":am_pen", $this->am_pen);
        //  $stmt->bindParam(":dp", $this->dp);
        //  $stmt->bindParam(":deleted", $this->deleted);
        //  $stmt->bindParam(":last_modified", $this->last_modified);

        // $stmt->bindParam(1, $keywords);
        // $stmt->bindParam(2, $keywords);
        // $stmt->bindParam(3, $keywords);
        // $stmt->bindParam(4, $keywords);
        // $stmt->bindParam(5, $keywords);
        // $stmt->bindParam(6, $keywords);
        // $stmt->bindParam(7, $keywords);
        // $stmt->bindParam(8, $keywords);
        // $stmt->bindParam(9, $keywords);
        // $stmt->bindParam(10, $keywords);
        // $stmt->bindParam(11, $keywords);


       // return $stmt;
       return $batch_arr;

    }
    function search_option($option, $keyword){

        $batch_arr = array();
        $batch_arr["records"] = array();

        $query = "SELECT * FROM " . $this->table_name . " WHERE $option LIKE '$keyword'";
        //echo $query;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();


        //sanitize
        //$keywords = htmlspecialchars(strip_tags($keywords));
        //$keywords = "%{$keywords}%";

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $this->batch_id = $row['batch_id'];
            $this->batch_num = $row['batch_num'];
            $this->product_code = $row['product_code'];
            $this->worksheet_id = $row['worksheet_id'];
            $this->created_date = $row['created_date'];
            $this->batch_size= $row['batch_size'];
            $this->sponge_wt = $row['sponge_wt'];
            $this->initial_ph = $row['initial_ph'];
            $this->am_pen = $row['am_pen'];
            $this->dp = $row['dp'];
			$this->notes = $row['notes'];
            $this->deleted= $row['deleted'];
            $this->last_modified= $row['last_modified'];   
            if($this->batch_id!= NULL){
        $batch_item = array("batch_id" => $this->batch_id,
        "product_code" => $this->product_code,
        "batch_num" => $this->batch_num,
        "worksheet_id" => $this->worksheet_id,
        "created_date" => $this->created_date,
        "batch_size" => $this->batch_size,
        "sponge_wt" => $this->sponge_wt,
        "initial_ph" => $this->initial_ph,
        "am_pen" => $this->am_pen,
        "dp" => $this->dp,
		"notes" => $this->notes,
        "deleted" => $this->deleted,
        "last_modified" => $this->last_modified);

        array_push($batch_arr["records"], $batch_item);
        }
        }
       
        //echo $this->batch_id;
       return $batch_arr;

    }

}

?>
