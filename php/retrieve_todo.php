<?php
    include_once '../config/database.php';
    include_once '../objects/todo.php';
    // instantiate database
    $database = new Database();
    $db = $database->getConnection();
    // pass connection to objects
    $todo = new Todo($db);

    $result = array('error'=>false);
    if ($stmt = $todo->retrieve()) {
        $todos = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($todos, $row);
        }
        $result['todos'] = $todos;
    }
    echo json_encode($result);
?>