<?php

class Database{

    //specifying creds
    // private $host= "127.0.0.1";
    // private $db_name= "cqs";
    // private $username= "root";
    // private $password="root";
    // private $port = "3306";
    // public $conn;

    private $host= "cqs-db.ck482epzmvng.us-east-1.rds.amazonaws.com";
    private $db_name= "cqs_db";
    private $username= "admin";
    private $password="cqs-2020";
    private $port = "3306";
    public $conn;
    //get database function
    public function getConnection(){
        $this->conn=null;
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try{
           // $dsn = "mysql:host=$host;dbname=$db_name;port=$port";
            //$this->conn = new PDO($dsn,$username,$password,$options);
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";port=" . $this->port, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

}

?>