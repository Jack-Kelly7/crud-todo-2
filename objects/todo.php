<?php
class Todo {
    // Pass database connection and define table name
    private $conn;
    private $table_name = "todos"; // TABLE NAME HERE

    // Values posted when Todo object was called
    public $todo;
    public $description;
    public $id;

    public function __construct($db){
        $this->conn = $db;
    }
 
    function create(){
        // Write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    todo=:todo, description=:description";
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind parameters 
        $stmt->bindParam(":todo", $this->todo);
        $stmt->bindParam(":description", $this->description);
        // Attempt to execute statement
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
    
    function retrieve() {
        // Define query
        $query = "SELECT * FROM " . $this->table_name;
        // Prepare statement
        $stmt = $this->conn->prepare( $query );
        // Execute statement
        $stmt->execute();
        // Return statement
        return $stmt;
    }

    function update(){
        // Define query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    todo = :todo,
                    description = :description
                WHERE
                    id = :id";
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind parameters
        $stmt->bindParam(":todo", $this->todo);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);
        // Execute statement
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    function delete(){
        // Define query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind parameters
        $stmt->bindParam(':id', $this->id);
        // Execute statement
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
}
?>