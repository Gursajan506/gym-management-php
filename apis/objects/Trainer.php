<?php
class Trainer{
 
    // database connection and table name
    private $conn;
    private $table_name = "trainers";
 
    // object properties
    public $id;
    public $name;
    public $image;
    public $experience;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, image=:image, experience=:experience";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->experience=htmlspecialchars(strip_tags($this->experience));
    
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":experience", $this->experience);
    
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }
    function update() {
        $query = "UPDATE " . $this->table_name . " 
            SET name='".$this->name. "', image='" .$this->image. "', experience='".$this->experience."' WHERE id='" . $this->id."'";
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->experience=htmlspecialchars(strip_tags($this->experience));
    
        // bind values
        
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":experience", $this->experience);
        $stmt->bindParam(":id", $this->id);
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
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id='" . $this->id."'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function fetchOne (){
        $query ="SELECT `id`, `name`, `image` , `experience` FROM " . $this->table_name ." WHERE id=".$this->id;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function fetchAll (){
        $query ="SELECT `id`, `name`, `image`, `experience` FROM " . $this->table_name ."";
        $stmt = $this->conn->prepare($query);
            // execute query
        $stmt->execute();
        return $stmt;
    }
}