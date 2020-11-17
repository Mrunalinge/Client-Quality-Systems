<?php

//get database connection
include_once '../config/database.php';

class Users{
    //connection
    private $conn;

    private $table_name = "USER";

    //properties of batches table
    public $user_name; //user name from the table
    public $user_id;    // user id autoincremented id
    public $rank;
    public $disabled;

    public function __construct($db){
        $this->conn = $db;
    }

    function readUser(){
        $user_arr = array();
        $user_arr["records"] = array();
        $query = "SELECT user_name FROM " . $this->table_name . "";
        

        //prepare query statment
        $stmt = $this->conn->prepare($query);

        // //binding not necessary as only the username is fetched.
        // $stmt->bindParam(1,$this->id);

        //execute query
        $stmt->execute();

        //get the retrieved row
      //  $row = $stmt->fetch(PDO::FETCH_ASSOC);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $this->user_name = $row['user_name'];
            //echo $this->user_name;
            if($this->user_name!=NULL){
                $user_item = array("user_name" => $this->user_name);
                array_push($user_arr["records"], $user_item);
            }
        }

        //set values in variables
        // if($this->stmt!= NULL){
        //    // $userName_List = array("user_name" => $this->user_name);
        //     array_push($users_arr["records"], $userName);
        // }  
        return $user_arr;    
    }
}?>