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
                
                //This event listener should update values of text
                google.maps.event.addListener(marker, 'click', function (event) {
                    document.getElementById(\"latbox\").value = event.latLng.lat();
                    document.getElementById(\"lngbox\").value = event.latLng.lng();
                });
                
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    document.getElementById(\"latbox\").value = this.getPosition().lat();
                    document.getElementById(\"lngbox\").value = this.getPosition().lng();
                });    
                
                // This event listener calls addMarker() when the map is clicked.
                google.maps.event.addListener(map, 'click', function(e) {
                    if(count<1){
                        placeMarkerOnce(e.latLng, map); 
                        count+=1;
                    }
                    alert(marker.getPosition());
                });

            
              function placeMarkerOnce(position, map) {
                marker = new google.maps.Marker({
                  position: position,
                  map: map,
                  title: 'Marker',
                  draggable: true
                });  
              }
            }
              
        </script>

    </head>
    <main>
        <body onload='load()'>
             <div id='map' style='width: 1000px; height: 600px'></div>
             <div id=\"latlong\">
                <p>Latitude: <input size=\"20\" type=\"text\" id=\"latbox\" name=\"lat\" ></p>
                <p>Longitude: <input size=\"20\" type=\"text\" id=\"lngbox\" name=\"lng\" ></p>
             </div>
        </body>
    </main>
    ";

include ("scripts/footer.php");
?>