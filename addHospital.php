<?php 
include("./home.php");

$db_server = "localhost";
$db_user = "root";
$db_pass = ""; // Database password
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
    $types_of_treatments = filter_input(INPUT_POST, "types_of_treatments", FILTER_SANITIZE_SPECIAL_CHARS);
    $latitude = filter_input(INPUT_POST, "latitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $longitude = filter_input(INPUT_POST, "longitude", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $visiting_hours = filter_input(INPUT_POST, "visiting_hours", FILTER_SANITIZE_SPECIAL_CHARS);

    // Initialize an array to store error messages
    $errors = [];

    // Validate hospital name (should not be empty and should contain only letters and spaces)
    if (empty($name)) {
        $errors[] = "Please enter the hospital name.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = "Hospital name should contain only letters and spaces.";
    }

    // Validate location (same as name validation)
    if (empty($location)) {
        $errors[] = "Please enter the location.";
    }

    // Validate contact number (should contain only digits and be of a reasonable length)
    if (empty($contact_number)) {
        $errors[] = "Please enter the contact number.";
    } elseif (!preg_match("/^\d{10}$/", $contact_number)) {
        $errors[] = "Contact number should be a valid 10-digit number.";
    }

    // Validate email address
    if (empty($email)) {
        $errors[] = "Please enter the email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate latitude (should be a valid float number between -90 and 90)
    if (empty($latitude)) {
        $errors[] = "Please enter the latitude.";
    } elseif (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
        $errors[] = "Latitude should be a number between -90 and 90.";
    }

    // Validate longitude (should be a valid float number between -180 and 180)
    if (empty($longitude)) {
        $errors[] = "Please enter the longitude.";
    } elseif (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
        $errors[] = "Longitude should be a number between -180 and 180.";
    }

    // If there are no errors, proceed with the database insertion
    if (empty($errors)) {
        // Check if the hospital location already exists
        $sql_q = "SELECT * FROM hospitals WHERE name = '$name' AND latitude = '$latitude' AND longitude = '$longitude'";
        $result = mysqli_query($conn, $sql_q);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="message">Hospital location already exists!</div>';
        } else {
            // Insert new hospital location into the database
            $sql = "INSERT INTO hospitals (name, location, contact_number, email, types_of_treatments, latitude, longitude, visiting_hours) 
                    VALUES ('$name', '$location', '$contact_number', '$email', '$types_of_treatments', '$latitude', '$longitude', '$visiting_hours')";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Location Details Form</title>
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
        .message {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            color: green;
            font-weight: bold;
            font-size: 18px;
            height: 50px;
        }
        .greens {
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
</head>
<body>

    <div id="map"></div>
    <div class="message" id="message"><?php echo $message; ?></div>

    <div class="parent">
        <div class="container">
            <h2 class="small-heading">Enter Hospital Location Details</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form_group">
                    <label for="name">Name</label>
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
                    <label for="types_of_treatments">Types of Treatments</label>
                    <input type="text" name="types_of_treatments" class="form-control" required>
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
                    <label for="visiting_hours">Visiting Hours</label>
                    <input type="text" name="visiting_hours" class="form-control" required>
                </div>
                <input type="submit" name="add_data" value="Add Data" class="btn">
            </form>

            <div class="back">
                <input type="button" value="Go to Home" onclick="window.location.href='index.php';" class="btn">
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="./index.js"></script>

</body>
</html>
