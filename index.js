

document.addEventListener('DOMContentLoaded', function () {
    // Default to Hyderabad coordinates if no data in localStorage
    var defaultLat = 17.3850;
    var defaultLng = 78.4867;

    // Load last saved lat/lng from localStorage (if exists) and convert to float
    var savedLat = parseFloat(localStorage.getItem('lat')) || defaultLat;
    var savedLng = parseFloat(localStorage.getItem('lng')) || defaultLng;

    // Create the map and set the view
    let map = L.map('map').setView([savedLat, savedLng], 8); // Set map view

    // Set up the OSM tile layer
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    });
    osm.addTo(map);

    // Create a draggable marker
    var marker = L.marker([savedLat, savedLng], { draggable: true }).addTo(map);

    // Update lat/lng input fields with the saved coordinates
    document.getElementById('lat').value = savedLat;
    document.getElementById('lng').value = savedLng;

    // Listen for 'drag' event to continuously update lat/lng during dragging
    marker.on('drag', function () {
        var position = marker.getLatLng();
        document.getElementById('lat').value = position.lat;
        document.getElementById('lng').value = position.lng;
    });

    // Listen for click events on the map to update marker position and show the popup
    // Handle single click on the map
    map.on('click', function (e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        // Set the marker's position to the clicked location
        marker.setLatLng([lat, lng]);

        // Update the input fields with the new coordinates
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
    });

    // Handle single click on the marker
    marker.on('click', function () {
        // Update the input fields with the marker's current position
        var latLng = marker.getLatLng();
        document.getElementById('lat').value = latLng.lat;
        document.getElementById('lng').value = latLng.lng;
        

    });
    marker.on('mouseover', function () {
        // Show the tooltip
        // marker.openTooltip();
        marker.bindPopup("double-click to add data").openPopup();
    });
    // Handle double-click on the marker to navigate to the form
    marker.on('dblclick', function () {
        // Automatically navigate to the form
        document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
    });

    
document.addEventListener('DOMContentLoaded', (event) => {
    // Check if map is already initialized
    if (!map) {
        var map = L.map('map').setView([18.106653, 79.426682], 5);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        var marker = L.marker([18.106653, 79.426682], {
            draggable: true
        }).addTo(map);

        marker.on('move', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);
            document.getElementById("lat").value = lat;
            document.getElementById("lng").value = lng;
        });

        marker.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);
            document.getElementById("lat").value = lat;
            document.getElementById("lng").value = lng;
        });
    }
});



    
});

