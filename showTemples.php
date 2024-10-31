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

// Query to get temple data
$sql = "SELECT name, location, email, address, latitude, longitude FROM temples;";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$temples = array();

if ($result->num_rows > 0) {
    // Fetch data into array
    while ($row = $result->fetch_assoc()) {
        $temples[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($temples);

// Close the connection
$conn->close();
?>



<!-- SELECT name, location, contact_number, email, types_of_treatments, latitude, longitude,visiting_hours from hospitals; -->
