<?php
include "header.php";
?>

<br><br>
<br><br>
<br><br>
<br><br>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <style>
        /* Style the map container */
        #map {
            width: 100%;
            height: 500px;
        }
    </style>

    <div style="background:#f7f7f7;text-align:center;font-size:1.2em;color:#555;padding:9px;font-weight:bold;">الخريطة والمسار والوقت</div>
    <div id="map"></div>


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script>
    function get_distance_and_time(){
    
        var map = L.map('map').setView([51.505, -0.09], 13); // Initial coordinates and zoom level

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);




        // Get current location's coordinates
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var currentLat = position.coords.latitude;
                var currentLng = position.coords.longitude;
                
                //alert("Current Latitude: " + currentLat);
                //alert("Current Longitude: " + currentLng);
                
                var control = L.Routing.control({
                    waypoints: [
                        L.latLng(currentLat, currentLng), // Starting point
                        L.latLng(<?php echo mysqli_fetch_array(mysqli_query($connect,"SELECT latitude FROM villas WHERE 1 AND id=".$_GET['villa_id']))['latitude']; ?>, <?php echo mysqli_fetch_array(mysqli_query($connect,"SELECT longitude FROM villas WHERE 1 AND id=".$_GET['villa_id']))['longitude']; ?>)    // Ending point
                    ],
                    routeWhileDragging: true // Allow route recalculation while dragging waypoints
                }).addTo(map);
                
                // Listen for route events
                control.on('routesfound', function(e) {
                    var routes = e.routes;
                    if (routes.length > 0) {
                        var route = routes[0]; // Assuming one route is found
                        var distance = route.summary.totalDistance; // Total distance in meters
                        var time = route.summary.totalTime; // Total time in seconds
                        var directions = route.instructions; // Turn-by-turn directions
                        
                        
                        
                        //"Turn-by-Turn Directions with Road Names:"
                        var direction_text="";
                        for (var i = 0; i < directions.length; i++) {
                            var step = directions[i];
                            //alert(step.text, step.road);
                            direction_text+=step.text+step.road+" ->";
                        }
                        
                        
                        //alert("Directions: " + direction_text);//------------------------Directions
                        
                        alert("المسافة بالامتار: " + distance);
                        alert("الوقت اللازم بالدقائق: " + time/60);
                        
                        
                    }
                });
                
                
            });
        } else {
            console.log("Geolocation is not available in this browser.");
        }
        
      }  
      get_distance_and_time();       
    </script>
    

    
</body>
</html>

