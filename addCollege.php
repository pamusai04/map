<?php 
include("./home.php");

$db_server = "localhost";
$db_user = "root";
$db_pass = ""; // Correct variable name for password
$db_name = "store_data";
$conn = ""; // Initialize the connection
$message = ""; // Initialize the message variable

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_SPECIAL_CHARS);
    $contact_number = filter_input(INPUT_POST, "contact_number", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_input(INPUT_POST, "latitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $longitude = filter_input(INPUT_POST, "longitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Initialize an array to store error messages
    $errors = [];

    // Validate required fields
    if (empty($name)) {
        $errors[] = "Please enter the college name.";
    }
    if (empty($location)) {
        $errors[] = "Please enter the location.";
    }
    if (empty($contact_number)) {
        $errors[] = "Please enter the contact number.";
    }
    if (empty($email)) {
        $errors[] = "Please enter the email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($latitude)) {
        $errors[] = "Please enter the latitude.";
    } elseif (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
        $errors[] = "Latitude should be a number between -90 and 90.";
    }
    if (empty($longitude)) {
        $errors[] = "Please enter the longitude.";
    } elseif (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
        $errors[] = "Longitude should be a number between -180 and 180.";
    }

    // If no errors, insert into the database
    if (empty($errors)) {
        $sql_q = "SELECT * FROM colleges WHERE name = '$name' AND latitude = '$latitude' AND longitude = '$longitude'";
        $result = mysqli_query($conn, $sql_q);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="message">College location already exists!</div>';
        } else {
            $sql = "INSERT INTO colleges (name, location, contact_number, email, address, latitude, longitude) 
                    VALUES ('$name', '$location', '$contact_number', '$email', '$address', '$latitude', '$longitude')";
            try {
                mysqli_query($conn, $sql);
                echo '<script>window.location.href="index.php";</script>';
                exit();
            } catch (mysqli_sql_exception $e) {
                echo '<div class="message">Error: Unable to add location. Please try again.</div>';
            }
        }
    } else {
        // Display errors if any
        foreach ($errors as $error) {
            echo '<div class="message">' . $error . '</div>';
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Location Details Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .parent {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(244, 33, 223, 10);
            width: 80%;
            max-width: 350px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }
        .form_group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"], input[type="submit"], input[type="button"] {
            width: 100%;
            padding: 5px;
            border: 2px solid #6a11cb;
            border-radius: 5px;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #ff4d4d;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: green;
        }
        .greens  {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            color: green;
            font-weight: bold;
            font-size: 18px;
            height: 50px;
        }
        .message {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            color: red;
            font-weight: bold;
            font-size: 18px;
            height: 50px;
        }
        .back {
            margin-top: 10px;
        }
        .small-heading {
            font-size: 1.2rem;
        }
        #map {
            height: 97vh;
            width: 100%;
            border: 1px solid #ccc;
            
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
</head>
<body>

    <div id="map"></div> <!-- Map container -->

    <!-- Display the connection message outside the form at the top -->
    <div class="message" id="message"><?php echo $message; ?></div>

    <div class="parent">
        <div class="container">
            <h2 class="small-heading">Enter College Location Details</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form_group">
                    <label for="name">College Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form_group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="form_group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" required>
                </div>
                <div class="form_group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" required>
                </div>
                <div class="form_group">
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" class="form-control" id="lat" required>
                </div>
                <div class="form_group">
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" class="form-control" id="lng" required>
                </div>
                <div class="form_group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
                <input type="submit" name="add_data" value="Add Data" class="btn">
            </form>

            <div class="back">
                <input type="button" value="Go to Home " id="goToIndex" class="btn">
            </div>
        </div>
    </div>



    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <!-- <script src="index.js"></script> -->
    <script src="./index.js"></script>

</body>
</html>

<script>
    // Button click navigation
    document.getElementById('goToIndex').onclick = function() {
        window.location.href = 'index.php'; // Navigate to index.php
    };
    

     // Check the message content and change color accordingly
     let message = document.getElementById("message");

    // Check the text content for success or failure message
    if (message.textContent === "You are connected to the database") {
        message.classList.remove("message"); // Remove the default 'message' class
        message.classList.add("greens"); // Add the 'greens' class
    } else if (message.textContent === "Could not connect to the database.") {
        message.classList.remove("greens"); // Remove 'greens' class if exists
        message.classList.add("message"); // Ensure the 'message' class is added
    }

</script>
