<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "task_management";
$port = 3307;

// mysqli connection
$conn = new mysqli($host, $user, $password, $database, $port);

session_start();
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session
// Destroy database connection
mysqli_close($conn);
header('Location: ../welcome.php'); // Redirect to the login page (or your desired page)
exit();
?>
