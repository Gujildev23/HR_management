<?php
$tasksFile = 'sales_tasks.json';
$tasks = json_decode(file_get_contents($tasksFile), true);

$id = $_GET['id'];
foreach ($tasks as $task) {
    if ($task['id'] === $id) {
        echo json_encode($task);
        exit();
    }
}
?>
