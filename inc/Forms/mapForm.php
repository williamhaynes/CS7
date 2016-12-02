<!--Allows details to be added to an existing map - required by System Requirements.-->

<?php
include ("scripts/header.php");

echo "
    <head>
        <title>Map</title>
        <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE' type='text/JavaScript'></script> 
        <script type='text/JavaScript'>
        var marker;
        var count = 0;
            function load() {
                var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(57.063408, -2.1455154),
                zoom: 13,
                mapTypeId: 'roadmap'
              });
            
                // This event listener calls addMarker() when the map is clicked.
                google.maps.event.addListener(map, 'click', function(e) {
                    if(count<1){
                        placeMarkerOnce(e.latLng, map);
                        document.getElementById('markerCoord').innerHTML = marker;
                        count+=1;
                    }
                });
            }
              function placeMarkerOnce(position, map) {
                marker = new google.maps.Marker({
                  position: position,
                  map: map,
                  title: 'Marker',
                  draggable: true
                });  
                map.panTo(position);
              }
              
        </script>

    </head>
    <main>
        <body onload='load()'>
             <div id='map' style='width: 1000px; height: 600px'></div>
             <p id='markerCoord'></p>
        </body>
    </main>
    ";

include ("scripts/footer.php");
?>