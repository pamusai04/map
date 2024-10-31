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

// Query to get bank data
$sql = "SELECT name, branch, contact_number, email, services, working_hours, latitude, longitude FROM banks;";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$banks = array();

if ($result->num_rows > 0) {
    // Fetch data into array
    while ($row = $result->fetch_assoc()) {
        $banks[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($banks);

// Close the connection
$conn->close();
?>
