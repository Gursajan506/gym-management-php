<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $username;
    public $password;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function adminCreateUser(){
    
        if($this->isAlreadyExist()){
            return false;
        }
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, password=:password, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }
    // login user
    function login(){
        // select all query
        $query = "SELECT
                    `id`, `username`, `password`, `created`
                FROM
                    " . $this->table_name . " 
                WHERE
                    username='".$this->username."' AND password='".$this->password."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    function count (){
        $query ="SELECT COUNT(id) AS count FROM ".$this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                return $row["count"];
            }

        }
        return 0;
    }
    function updateUser() {
        $query = "UPDATE " . $this->table_name . " 
            SET username='".$this->username. "', password='" .$this->password. "', created='".$this->created."' WHERE id='" . $this->id."'";
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":id", $this->id);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    function deleteUser() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id='" . $this->id."'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function fetchUser (){
        $query ="SELECT `id`, `username`, `created` FROM " . $this->table_name ." WHERE id=".$this->id;
        $stmt = $this->conn->prepare($query);
            // execute query
        $stmt->execute();
        return $stmt;
    }
    function fetchUsers (){
        $query ="SELECT `id`, `username`, `created` FROM " . $this->table_name ."";
        $stmt = $this->conn->prepare($query);
            // execute query
        $stmt->execute();
        return $stmt;
    }
    function getUser() {
        //get user by username
            
        $query = "SELECT `id`, `username`, `created` FROM " . $this->table_name . " WHERE username='".$this->username."' ";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;

    }
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                username='".$this->username."'";
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
    function  isIdAlreadyExist(){

        $query = "SELECT * FROM " . $this->table_name . " WHERE id=" .$this->id. "";

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