<?php 
$db_server = "localhost";
$db_user = "root";
$db_pass = ""; 
$db_name = "store_data";
$conn = ""; 
$message = ""; 

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    // Check if the connection is successful
    if ($conn) {
        $message = "You are connected to the database"; // Store success message
    } else {
        $message = "Could not connect to the database."; // Store failure message
    }
} catch (Exception $e) { 
    $message = "Error: " . $e->getMessage(); // Store error message
}
?>
