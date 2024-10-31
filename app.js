// Initialize the map
var map = L.map('map').setView([22.9074872, 79.07306671], 7); // Set initial view based on your region

// Add OpenStreetMap tile layer
var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// Array to keep track of current markers
var currentMarkers = [];

// Function to clear markers from the map
function clearMarkers() {
    currentMarkers.forEach(function(marker) {
        map.removeLayer(marker);
    });
    currentMarkers = []; // Reset the marker array
}

// Function to fetch and display hospital markers
function showHospitalMarkers() {
    clearMarkers(); // Clear previous markers
    fetch('./showHospital.php') // Change to your PHP endpoint for hospitals
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            data.forEach(function(hospital) {
                if (hospital.latitude && hospital.longitude) {
                    var marker = L.marker([parseFloat(hospital.latitude), parseFloat(hospital.longitude)]).addTo(map); // Convert to numbers
                    var popupContent = `
                        <strong>${hospital.name}</strong><br>
                        Location: ${hospital.location}<br>
                        Email: ${hospital.email}<br>
                        Treatments: ${hospital.types_of_treatments}<br>
                        Visiting Hours: ${hospital.visiting_hours}
                    `;
                    marker.bindPopup(popupContent);
                    currentMarkers.push(marker); // Store marker
                } else {
                    console.error('Invalid lat/lng for hospital:', hospital);
                }
            });
        })
        .catch(error => console.error('Error fetching hospital data:', error));
}

// Function to show temple markers on the map
function showTempleMarkers() {
    clearMarkers(); // Clear previous markers
    fetch('showTemples.php') // Fetch data from your PHP endpoint
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            data.forEach(function(temple) {
                if (temple.latitude && temple.longitude) {
                    // Create a marker for each temple
                    var marker = L.marker([parseFloat(temple.latitude), parseFloat(temple.longitude)]).addTo(map);
                    var popupContent = `
                        <strong>${temple.name}</strong><br>
                        Location: ${temple.location}<br>
                        Email: ${temple.email}<br>
                        Address: ${temple.address}
                    `;
                    marker.bindPopup(popupContent); // Bind popup to marker
                    currentMarkers.push(marker); // Store marker
                } else {
                    console.error('Invalid lat/lng for temple:', temple);
                }
            });
        })
        .catch(error => console.error('Error fetching temple data:', error));
}

// Function to fetch and display bank markers
function showBankMarkers() {
    clearMarkers(); // Clear previous markers
    fetch('showBanks.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        data.forEach(function(bank) {
            if (bank.latitude && bank.longitude) {
                var marker = L.marker([parseFloat(bank.latitude), parseFloat(bank.longitude)]).addTo(map); // Convert to numbers
                var popupContent = `
                    <strong>${bank.name}</strong><br>
                    Branch: ${bank.branch}<br>
                    Email: ${bank.email}<br>
                    Working Hours: ${bank.working_hours}
                `;
                marker.bindPopup(popupContent);
                currentMarkers.push(marker); // Store marker
            } else {
                console.error('Invalid lat/lng for bank:', bank);
            }
        });
    })
    .catch(error => console.error('Error fetching bank data:', error));
}

// Function to fetch and display college markers
function showCollegeMarkers() {
    clearMarkers(); // Clear previous markers

    fetch('showColleges.php') // Fetch college data
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        data.forEach(function(college) {
            if (college.latitude && college.longitude) {
                // Create a marker at the college's latitude and longitude
                var marker = L.marker([parseFloat(college.latitude), parseFloat(college.longitude)]).addTo(map);

                // Prepare the popup content, including the new 'location' field
                var popupContent = `
                    <strong>${college.name}</strong><br>
                    Location: ${college.location}<br>
                    Contact Number: ${college.contact_number}<br>
                    Email: ${college.email}<br>
                `;

                // Bind the popup to the marker
                marker.bindPopup(popupContent);

                // Store the marker for later management (e.g., clearing markers)
                currentMarkers.push(marker);
            } else {
                console.error('Invalid latitude/longitude for college:', college);
            }
        });
    })
    .catch(error => console.error('Error fetching college data:', error));
}

// Function to fetch and display school markers
function showSchoolMarkers() {
    clearMarkers(); // Clear previous markers
    fetch('showSchools.php') // Fetch school data
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        data.forEach(function(school) {
            if (school.latitude && school.longitude) {
                var marker = L.marker([parseFloat(school.latitude), parseFloat(school.longitude)]).addTo(map); // Convert to numbers
                var popupContent = `
                    <strong>${school.name}</strong><br>
                    Location: ${school.location}<br>
                    Contact Number: ${school.contact_number}<br>
                    Email: ${school.email}<br>
                `;
                marker.bindPopup(popupContent);
                currentMarkers.push(marker); // Store marker
            } else {
                console.error('Invalid lat/lng for school:', school);
            }
        });
    })
    .catch(error => console.error('Error fetching school data:', error));
}

// Add event listener for hospital query button
document.querySelector("#hospitals").addEventListener("click", function(event) { 
    console.log("hello sai");
    event.preventDefault(); // Prevent default navigation
    showHospitalMarkers(); // Display the hospital markers on the map
});



// Event listener for clicking the "Banks" link
document.querySelector("#bankquery").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default navigation
    showBankMarkers();      // Display the bank markers on the map
    console.log("bank...");
});


// Event listener for clicking the "Colleges" link
document.querySelector("#colleges").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default navigation
    showCollegeMarkers();
    console.log("hello");
    
});

// Event listener for clicking the "Schools" link
document.querySelector("#schools").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default navigation
    showSchoolMarkers();   // Display the school markers on the map
});


// Event listener for the "Show Temples" link
document.querySelector("#templequery").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default navigation
    showTempleMarkers(); // Display the temple markers on the map
});



