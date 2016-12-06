<!--Functional Requirement: Will have a number of popup overlays to display additional information as required in
System Requirements.-->

<?php
include ("scripts/header.php");

?>
<head>
    <link rel="stylesheet" type="text/css" href="/style/mapStyle.css">
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
                <?
                include(__DIR__ . "/../scripts/dbconnect.php");
                //Takes all database information from the Genre TABLE.
                $sql_queryLandmarks = 'SELECT * FROM location WHERE typeID=1';
                echo "<script>HELLOHELLO</script>;";
                //Process the query
                $resultLandmarks = $db->query($sql_queryLandmarks);
                echo "<script>HELLO</script>;";
                // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
                while ($row = $resultLandmarks->fetch_array()) {

                ?>
                    {
                        "locationID": "<?php print $row['locationID'];?>",
                        "geometry": {"type": "Landmark", "coordinates": [<?php print $row['lat'];?>, <?php print $row['lng'];?>]},
                        "name": "<?php print $row['name'];?>",
                        "address": "<?php print $row['address'];?>",
                        "description": "<?php print $row['description'];?>"
                        //"markerImage":"images/red.png",
                    },
                <?}?>
            ]
            });
        document.getElementsByTagName('head')[0].appendChild(script);
    }





        // Loop through the results array and place a marker for each
        // set of coordinates.
        window.eqfeed_callback = function(results) {
            //alert(results.markers.length);

            //Trying to add a info window
            var infowindow = new google.maps.InfoWindow({
                content: "loading..."
            });

            // Event that closes the Info Window with a click on the map
            google.maps.event.addListener(map, 'click', function() {
                infowindow.close();
            });

            for (var i = 0; i < results.markers.length; i++) {
                var coords = results.markers[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0],coords[1]);
                arrayOfMarkers.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.markers[i].name,
                    description: results.markers[i].description
                }));

                arrayOfMarkers[i].addListener('click', function(){
                    infowindow.setContent( '<div id="iw-container">' +
                        '<div class="iw-title">'+this.title+'</div>' +
                        '<div class="iw-outsidecontent">'+
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Description</div>' +
                        '<img src="http://maps.marnoto.com/en/5wayscustomizeinfowindow/images/vistalegre.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                        this.description+
                        '<div class="iw-subTitle">Contacts</div>' +
                        '<p>VISTA ALEGRE ATLANTIS, SA<br>3830-292 Ílhavo - Portugal<br>'+
                        '<br>Phone. +351 234 320 600<br>e-mail: geral@vaa.pt<br>www: www.myvistaalegre.com</p>'+
                        '</div>' +
                        '</div>' +
                        '</div>');
                    $("<div class='iw-outsidecontent'></div>").wrap("<div class='iw-content'></div>");
                    infowindow.open(map, this);
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


