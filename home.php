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
        /* Custom Navbar Styles */
        .custom-navbar {
            background-color: #FF9933;
        }
        .custom-navbar .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem; 
        }
        .custom-navbar .nav-link {
            color: #FFFFFF;
            font-weight: 500; 
            text-transform: uppercase; 
        }
        .custom-navbar .nav-link:hover {
            color: #138808;
            font-weight: bold; 
        }
        .custom-navbar .nav-link.active {
            background-color: #138808; 
            font-weight: bold;
        }
     
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
        <a class="navbar-brand" href="#">Map</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./addBank.php" data-initial="B">Add Bank</a>
                </li>
                
                <li class="nav-item ">
                    <a class="nav-link" href="./addTemple.php" >Add Temple</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./addCollege.php" data-initial="C">Add College</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./addSchool.php" >Add School</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./addHospital.php">Add Hospital</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./index.php" >Home </a>
                </li>
                
            </ul>
        </div>
    </nav>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- External JavaScript File -->
    <script src="index.js"></script>

</body>
</html>
