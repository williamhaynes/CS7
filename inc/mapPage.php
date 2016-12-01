<!--Functional Requirement: Will have a number of popup overlays to display additional information as required in
System Requirements.-->

<?php
include ("scripts/header.php");

echo "
    <head>
        <title>Map</title>
        <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE' type='text/JavaScript'></script> 
        <script type='text/JavaScript'>

              var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(57.063408, -2.1455154),
                zoom: 13,
                mapTypeId: 'roadmap'
              });

            // This event listener calls addMarker() when the map is clicked.
              google.maps.event.addListener(map, 'click', function(e) {
                placeMarker(e.latLng, map);
              });
            
              function placeMarker(position, map) {
                var marker = new google.maps.Marker({
                  position: position,
                  map: map
                });  
                map.panTo(position);
              }
        </script>

    </head>
    <main>
        <body>
             <div id='map' style='width: 1000px; height: 600px'></div>
        </body>
    </main>
    ";

include ("scripts/footer.php");
?>