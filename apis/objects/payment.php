<?php
class Payment{
 
    // database connection and table name
    private $conn;
    private $table_name = "payments";
 
    // object properties
    public $id;
    public $user_id;
    public $amount;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // signup user
    function createPayment(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, amount=:amount, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->user_id=number_format($this->user_id);
        $this->amount=htmlspecialchars(strip_tags($this->amount));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }
    function updatePayment() {
        $query = "UPDATE " . $this->table_name . " 
            SET amount='" .$this->amount. "', created='".$this->created."' WHERE id='" . $this->id."'";
        $stmt = $this->conn->prepare($query);

        $this->amount=htmlspecialchars(strip_tags($this->amount));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values

        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":id", $this->id);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    function deletePayment() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id='" . $this->id."'";
        $stmt = $this->conn->prepare($query);
        // bind value
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }
    function fetchPayments (){
        $query ="SELECT * FROM " . $this->table_name .",users";
        $stmt = $this->conn->prepare($query);
            // execute query
        $stmt->execute();
        return $stmt;
    }
    
    
}