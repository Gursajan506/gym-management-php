<?php
class Admin{
 
    // database connection and table name
    private $conn;
    private $table_name = "admins";
 
    // object properties
    public $id;
    public $username;
    public $password;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // login user
    function adminLogin(){
        // select all query
        $query = "SELECT
                    `id`, `username`, `password`
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

    
}