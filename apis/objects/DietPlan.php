<?php
class DietPlan{
 
    // database connection and table name
    private $conn;
    private $table_name = "diet_plans";
 
    // object properties
    public $id;
    public $title;
    public $image;
    public $description;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    title=:title, image=:image, description=:description";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->description=htmlspecialchars(strip_tags($this->description));
    
        // bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":description", $this->description);
    
        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
    
        return false;
        
    }
    function update() {
        $query = "UPDATE " . $this->table_name . " 
            SET title='".$this->title. "', image='" .$this->image. "', description='".$this->description."' WHERE id='" . $this->id."'";
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->description=htmlspecialchars(strip_tags($this->description));
    
        // bind values
        
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id='" . $this->id."'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }
    function fetchOne (){
        $query ="SELECT `id`, `title`, `image` , `description` FROM " . $this->table_name ." WHERE id=".$this->id;
        $stmt = $this->conn->prepare($query);
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
    function fetchAll (){
        $query ="SELECT `id`, `title`, `image`, `description` FROM " . $this->table_name ."";
        $stmt = $this->conn->prepare($query);
            // execute query
        $stmt->execute();
        return $stmt;
    }
}