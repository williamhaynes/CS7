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
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 2,
            center: new google.maps.LatLng(2.8,-187.3),
            mapTypeId: 'terrain'
        });

        // Create a <script> tag and set the USGS URL as the source.
        //var script = document.createElement('script');
        // This example uses a local copy of the GeoJSON stored at
        // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
        //script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';

        var script = document.createElement('script');
        script.innerHTML = eqfeed_callback( +
            {"markers": [
                {
                    "point":new GLatLng(40.266044,-74.718479),
                    "homeTeam":"Lawrence Library",
                    "awayTeam":"LUGip",
                    "markerImage":"images/red.png",
                    "information": "Linux users group meets second Wednesday of each month.",
                    "fixture":"Wednesday 7pm",
                    "capacity":"",
                    "previousScore":""
                },
                {
                    "point":new GLatLng(40.211600,-74.695702),
                    "homeTeam":"Hamilton Library",
                    "awayTeam":"LUGip HW SIG",
                    "markerImage":"images/white.png",
                    "information": "Linux users can meet the first Tuesday of the month to work out harward and configuration issues.",
                    "fixture":"Tuesday 7pm",
                    "capacity":"",
                    "tv":""
                },
                {
                    "point":new GLatLng(40.294535,-74.682012),
                    "homeTeam":"Applebees",
                    "awayTeam":"After LUPip Mtg Spot",
                    "markerImage":"images/newcastle.png",
                    "information": "Some of us go there after the main LUGip meeting, drink brews, and talk.",
                    "fixture":"Wednesday whenever",
                    "capacity":"2 to 4 pints",
                    "tv":""
                },
            ] }
            +);

        document.getElementsByTagName('head')[0].appendChild(script);
    }

    // Loop through the results array and place a marker for each
    // set of coordinates.
    window.eqfeed_callback = function(results) {
        for (var i = 0; i < results.features.length; i++) {
            var coords = results.features[i].geometry.coordinates;
            var latLng = new google.maps.LatLng(coords[1],coords[0]);
            var marker = new google.maps.Marker({
                position: latLng,
                map: map
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


