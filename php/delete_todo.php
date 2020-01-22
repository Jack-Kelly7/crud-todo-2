<?php
    // Link config and objects
    include_once '../config/database.php';
    include_once '../objects/todo.php';

    // Open database
    $database = new Database();
    $db = $database->getConnection();

    // Pass database connection to Todo object
    $todo = new Todo($db);

    // Set $result 'error' to false
    $result = array('error'=>false);

    // Post values
    $todo->id = $_POST["id"];

    // Attempt to delete To Do
    if ($todo->delete()) {
        $result['message'] = "To Do deleted successfully!";
    }   
    // If unable to delete To Do, tell the user
    else {
        $result['message'] = "Failed to delete To Do!";
    }
    
    // Return result as json
    echo json_encode($result);
?>