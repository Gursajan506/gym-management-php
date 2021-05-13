<?php
class Admin{
 
    // database connection and table name
    private $conn;
    private $table_name = "admins";
 
    // object properties
    public $id;
    public $adminname;
    public $password;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // signup user
    function adminSignup(){
    
        if($this->isAdminAlreadyExist()){
            return false;
        }
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    adminname=:adminname, password=:password";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->adminname=htmlspecialchars(strip_tags($this->adminname));
        $this->password=htmlspecialchars(strip_tags($this->password));
    
        // bind values
        $stmt->bindParam(":adminname", $this->adminname);
        $stmt->bindParam(":password", $this->password);
    
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }
    // login user
    function adminLogin(){
        // select all query
        $query = "SELECT
                    `id`, `adminname`, `password`
                FROM
                    " . $this->table_name . " 
                WHERE
                    adminname='".$this->adminname."' AND password='".$this->password."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    
    function isAdminAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                adminname='".$this->adminname."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
}