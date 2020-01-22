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

    // Attempt to create To Do
    if ($todo->create()) {
        $result['message'] = "To Do added successfully!";
    }   
    // If unable to create To Do, tell the user
    else {
        $result['message'] = "Failed to add To Do!";
    }
    
    // Return result as json
    echo json_encode($result);
?>