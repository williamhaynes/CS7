<!--Functional Requirement: Will have a number of popup overlays to display additional information as required in
System Requirements.-->

<?php
include ("scripts/header.php");
include(__DIR__ . "/../scripts/dbconnect.php");
?>
<head>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="map"></div>
<script>
    var map;
    var arrayOfMarkers = [];
    function initMap() {
        var portlethenLatLng = new google.maps.LatLng(57.062661319658496, -2.1295508919433814);
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            mapTypeId: 'roadmap',
            center: portlethenLatLng
        });

        // Create a <script> tag and set the USGS URL as the source.
        //var script = document.createElement('script');
        // This example uses a local copy of the GeoJSON stored at
        // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
        //script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';

        var script = document.createElement('script');
        script.innerHTML = eqfeed_callback(
            {"markers": [
                {
                    "locationID":"201",
                    "geometry":{"type":"Point","coordinates":[57.052299579818296,-2.169376331396506]},
                    "name":"Road",
                    "address":"Road",
                    "description":"<p>Road</p>"
                    //"markerImage":"images/red.png",
                },
                {
                    "locationID":"301",
                    "geometry":{"type":"Point","coordinates":[57.062299579818400,-2.569376331396506]},
                    "name":"Street",
                    "address":"Street",
                    "description":"<p>Street</p>"
                    //"markerImage":"images/red.png",
                },
            ] });

        document.getElementsByTagName('head')[0].appendChild(script);
    }

    //Trying to add a info window



    // Loop through the results array and place a marker for each
    // set of coordinates.
    window.eqfeed_callback = function(results) {
        //alert(results.markers.length);

        for (var i = 0; i < results.markers.length; i++) {
            var coords = results.markers[i].geometry.coordinates;
            var latLng = new google.maps.LatLng(coords[0],coords[1]);
            arrayOfMarkers.push(new google.maps.Marker({position: latLng, map: map}));
            var text = (results.markers[i].description);
            var infowindow = new google.maps.InfoWindow({
               content:  text
            });
            marker.addListener('click', function(){
                infowindow.open(map, arrayOfMarkers.pop());
            });
        }
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE&callback=initMap">
</script>
</body>
<?

include ("scripts/footer.php");
?>


