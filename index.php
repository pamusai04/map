<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Navbar with Leaflet Map</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    
    <style>
        /* Set the map height */
        #map {
            height: calc(100vh - 56px); /* 56px is the height of the navbar */
        }
        
        /* Custom Navbar Styles */
        .custom-navbar {
            background-color: #FF9933; /* Saffron color for background */
        }
        .custom-navbar .navbar-brand {
            font-weight: bold; /* Bold font for brand */
            font-size: 1.5rem; /* Larger font size for brand */
        }
        .custom-navbar .nav-link {
            color: #FFFFFF; /* White color for text */
            font-weight: 500; /* Medium weight for nav links */
            text-transform: uppercase; /* Uppercase for nav links */
            position: relative; /* Position for initials */
        }
        .custom-navbar .nav-link::before {
            content: attr(data-initial); /* Display initials */
            font-weight: bold; /* Bold weight for initials */
            font-size: 1.2rem; /* Font size for initials */
            margin-right: 5px; /* Space between initials and text */
            color: #138808; /* Green color for initials */
        }
        .custom-navbar .nav-link:hover {
            color: #138808; /* Green color for hover */
            font-weight: bold; /* Bold weight on hover */
        }
        .custom-navbar .nav-link.active {
            background-color: #138808; /* Green color for active link */
            font-weight: bold; /* Bold weight for active link */
        }
        .dropdown-menu {
            background-color: #FFFFFF; /* White background for dropdown */
            border: none; /* Remove border */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
        }
        .dropdown-item {
            color: #000000; /* Black text for dropdown items */
            font-weight: 500; /* Medium weight for dropdown items */
            position: relative; /* Position for underline */
            padding: 10px 15px; /* Padding for dropdown items */
        }
        .dropdown-item::before {
            content: attr(data-initial); /* Display initials */
            font-weight: bold; /* Bold weight for initials */
            font-size: 1.2rem; /* Font size for initials */
            margin-right: 5px; /* Space between initials and text */
            color: #138808; /* Green color for initials */
        }
        .dropdown-item:hover {
            background-color: #FF9933; /* Saffron background on hover */
            color: #FFFFFF; /* White text on hover */
        }
        .dropdown-item.selected {
            position: relative; /* Required for pseudo-element */
        }
        .dropdown-item.selected::after {
            content: ''; /* Create underline */
            position: absolute; /* Position it below the item */
            left: 0; /* Align to the left */
            right: 0; /* Align to the right */
            bottom: 0; /* Align to the bottom */
            height: 2px; /* Height of underline */
            background-color: #138808; /* Green color for underline */
        }

        
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar"> <!-- Updated to custom class -->
        <a class="navbar-brand" href="#">Map</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-initial="A">
                        Add Locations
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./addBank.php">Add Bank</a>
                        <a class="dropdown-item" href="./addTemple.php" >Add Temple</a>
                        <a class="dropdown-item" href="./addCollege.php">Add College</a>
                        <a class="dropdown-item" href="./addSchool.php" >Add School</a>
                        <a class="dropdown-item" href="./addHospital.php">Add Hospital</a>

                    </div>

                </li>

                
                <li class="nav-item">
                    <a class="nav-link" href="#" id="bankquery" data-initial="B">Show Banks  <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="colleges" data-initial="C">Show Colleges</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" id="schools" data-initial="S">Show Schools</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" id="templequery" data-initial="T">Show Temples</a>
                </li>

                <li class="nav-item ">
                    <a class="nav-link" href="#" id="hospitals" data-initial="H">Show Hospitals</a>
                </li>
            </ul>
            
        </div>
    </nav>

    <main>
        <div id="map"></div>
        <button id="templequery">Show Temples</button>

    </main>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- External JavaScript File -->
    <script src="./app.js"></script>
    

</body>
</html>
