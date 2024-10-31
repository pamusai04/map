<?php
$host = "localhost"; // Database host
$user = "root";      // Database username
$pass = "";          // Database password
$dbname = "store_data"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get college data
$sql = "SELECT name, location, contact_number, email, address, latitude, longitude FROM colleges;";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$colleges = array();

if ($result->num_rows > 0) {
    // Fetch data into array
    while ($row = $result->fetch_assoc()) {
        $colleges[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($colleges);

// Close the connection
$conn->close();
?>
