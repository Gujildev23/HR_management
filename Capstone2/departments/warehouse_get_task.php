<?php
// Get the department parameter from the query string
$department = isset($_GET['department']) ? $_GET['department'] : '';

// Define the path to the tasks JSON file based on the department
$tasksFile = $department . 'warehouse_task.json'; // Example: 'purchasing_tasks.json'

// Check if the file exists
if (file_exists($tasksFile)) {
    $tasks = json_decode(file_get_contents($tasksFile), true);

    // Return the tasks as JSON
    header('Content-Type: application/json');
    echo json_encode($tasks);
} else {
    // Return an error if the file does not exist
    header('HTTP/1.0 404 Not Found');
    echo json_encode(['error' => 'Tasks file not found']);
}
?>
