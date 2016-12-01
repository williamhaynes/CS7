<!--Functional Requirement: Will have a number of popup overlays to display additional information as required in
System Requirements.-->

<?php
include ("scripts/header.php");

echo "
    <head>
        <title>Map</title>
        <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE' type='text/JavaScript'></script> 
        <script type=\"text/JavaScript\">
            function load() {
              var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(57.063408, -2.1455154),
                zoom: 13,
                mapTypeId: 'roadmap'
              });
            }
        </script>

    </head>
    <main>
        <body onload='load()'>
             <div id='map' style='width: 100%; height: auto'></div>
        </body>
    </main>
    ";

include ("scripts/footer.php");
?>