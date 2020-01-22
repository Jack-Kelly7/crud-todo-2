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
    $todo->todo = $_POST['todo'];
    $todo->description = $_POST['description'];
    $todo->id = $_POST['id'];

    // Attempt to update To Do
    if ($todo->update()) {
        $result['message'] = "To Do updated successfully!";
    } 
    // If unable to update To Do, tell the user
    else {
        $result['message'] = "To Do NOT updated!";
    }
    
    // Return result as json
    echo json_encode($result);
?>