<!--Allows details to be added to an existing map - required by System Requirements.-->

<?php
include ("scripts/header.php");

echo "
    <head>
        <title>Map</title>
        <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE' type='text/JavaScript'></script> 
        <script type='text/JavaScript'>
        var count = 0;
        var map;
            function load() {
                var portlethenLatLng = new google.maps.LatLng(57.062661319658496,-2.1295508919433814);
                map = new google.maps.Map(document.getElementById('map'), {
                center: portlethenLatLng,
                zoom: 13,
                mapTypeId: 'roadmap'
              });
                
                var marker = new google.maps.Marker({
                   position: portlethenLatLng,
                   map: map,
                   title: 'Marker',
                   draggable: true
                });
                
                //This event listener should update values of text
                google.maps.event.addListener(marker, 'click', function (event) {
                    document.getElementById('latbox').value = event.latLng.lat();
                    document.getElementById('lngbox').value = event.latLng.lng();
                });

                google.maps.event.addListener(marker, 'dragend', function (event) {
                    document.getElementById('latbox').value = this.getPosition().lat();
                    document.getElementById('lngbox').value = this.getPosition().lng();
                });
                // This event listener calls addMarker() when the map is clicked.
                //google.maps.event.addListener(map, 'click', function(e) {
                    //if(count<1){
                        
                            //count+=1;
                        
                    //}
                //);

            }
              
        </script>

    </head>
    <main>
        <body onload='load()'>
             <div id='map' style='width: 1000px; height: 600px'></div>
             <div id='latlong'>
                <p>Latitude: <input size='20' type='text' id='latbox' name='lat' value='57.062661319658496'></p>
                <p>Longitude: <input size='20' type='text' id='lngbox' name='lng' value='-2.1295508919433814'></p>
             </div>
        </body>
    </main>
    ";

include ("scripts/footer.php");
?>