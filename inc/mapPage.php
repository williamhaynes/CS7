<!--Functional Requirement: Will have a number of popup overlays to display additional information as required in
System Requirements.-->

<?php
include ("scripts/header.php");
include(__DIR__ . "/../scripts/dbconnect.php");
?>
    <head>
        <title>Map</title>
        <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE' type='text/JavaScript'></script> 
        <script type='text/JavaScript'>
            function load() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: new google.maps.LatLng(57.063408, -2.1455154),
                    zoom: 13,
                    mapTypeId: 'roadmap'
                });
            }
                function downloadUrl(url,callback) {
                    var request = window.ActiveXObject ?
                        new ActiveXObject('Microsoft.XMLHTTP') :
                        new XMLHttpRequest;

                    request.onreadystatechange = function() {
                        if (request.readyState == 4) {
                            callback(request, request.status);
                        }
                    };

                    request.open('GET', url, true);
                    request.send(null);
                }
                downloadUrl(<?php echo "".__DIR__."";?>"/scripts/xml/locations.php", function(data) {
                    var xml = data.responseXML;
                    alert(xml);
                    var markers = xml.documentElement.getElementsByTagName("marker");
                    for (var i = 0; i < markers.length; i++) {
                        var point = new google.maps.LatLng(
                            parseFloat(markers[i].getAttribute("lat")),
                            parseFloat(markers[i].getAttribute("lng")));
                        var marker = new google.maps.Marker({map: map, position: point});
                    }
                });

        </script>
        <a href='mapForm'>Link to Map Form</a>
    </head>
    <main>
        <body onload='load()'>
             <div id='map' style='width: 1000px; height: 600px'></div>
        <p>
            Some random text
        </p>
        </body>
    </main>


<?

include ("scripts/footer.php");
?>


