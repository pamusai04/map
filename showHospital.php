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

// Query to get hospital data
$sql = "SELECT name, location, contact_number, email, types_of_treatments, latitude, longitude, visiting_hours FROM hospitals;";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$hospitals = array();

if ($result->num_rows > 0) {
    // Fetch data into array
    while ($row = $result->fetch_assoc()) {
        $hospitals[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($hospitals);

// Close the connection
$conn->close();
?>
