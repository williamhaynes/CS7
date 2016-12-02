<!--Allows details to be added to an existing map - required by System Requirements.-->
<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__ . "/../scripts/header.php");
        include(__DIR__ . "/../scripts/dbconnect.php");
        ?>
        <head>
            <title>Map</title>
            <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE'
                    type='text/JavaScript'></script>
            <script type='text/JavaScript'>
                var count = 0;
                var map;
                var marker;
                var portlethenLatLng = new google.maps.LatLng(57.062661319658496, -2.1295508919433814);
                function load() {
                    map = new google.maps.Map(document.getElementById('map'), {center: portlethenLatLng, zoom: 13, mapTypeId: 'roadmap'});
                    marker = new google.maps.Marker({position: portlethenLatLng, map: map, title: 'Marker', draggable: true});

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


                }
                function checkType() {
                    //If statements work
                    //If its a Landmark
                    if (document.getElementById('1').selected) {

                    }
                    //If its a Viewpoint
                    if (document.getElementById('2').selected) {

                    }
                    //If its a Area
                    if (document.getElementById('3').selected) {
                        var markersLatLng=[];
                        //['{lat: '+marker.getPosition().lat()+', lng: '+marker.getPosition().lat()+'}']
                        var path;
                        google.maps.event.addListener(map, 'click', function(event) {
                            if(markersLatLng.length==0){
                                markersLatLng.push(new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng()));
                            }
                            addMarker(event.latLng);
                        });

                        function addMarker(pos) {
                            var marker = new google.maps.Marker({map: map, position: pos, draggable: false});
                            var markerLatLng = new google.maps.LatLng(pos.lat(), pos.lng());
                            markersLatLng.push(markerLatLng);
                            drawPath();
                        }
                        function drawPath() {
//                           markers.length;
//                           var coords=[];
//                           for (var i = 0; i < markers.length; i++) {
//                               coords.push()
//                              coords.push('{lat: ' + markers[i].getPosition().lat() + ', lng: ' + markers[i].getPosition().lat() + '}');
//                           }
                            alert(markersLatLng);

                            area = new google.maps.Polygon({
                                paths: markersLatLng,
                                strokeColor: '#78d2ff',
                                strokeOpacity: 0.8,
                                strokeWeight: 2,
                                fillColor: '#aff3ff',
                                fillOpacity: 0.35
                            });

                            area.setMap(map);
                        }
                    }
                    //If its a route
                    if (document.getElementById('4').selected) {
                        var markersLatLng=[];
                         //['{lat: '+marker.getPosition().lat()+', lng: '+marker.getPosition().lat()+'}']
                        var path;
                        google.maps.event.addListener(map, 'click', function(event) {
                            if(markersLatLng.length==0){
                                markersLatLng.push(new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng()));
                            }
                            addMarker(event.latLng);
                        });

                        function addMarker(pos) {
                            var marker = new google.maps.Marker({map: map, position: pos, draggable: false});
                            var markerLatLng = new google.maps.LatLng(pos.lat(), pos.lng());
                            markersLatLng.push(markerLatLng);
                            drawPath();
                        }
                        function drawPath() {
//                           markers.length;
//                           var coords=[];
//                           for (var i = 0; i < markers.length; i++) {
//                               coords.push()
//                              coords.push('{lat: ' + markers[i].getPosition().lat() + ', lng: ' + markers[i].getPosition().lat() + '}');
//                           }
                           alert(markersLatLng);

                            path = new google.maps.Polyline({
                                path: markersLatLng,
                                geodesic: true,
                                strokeColor: '#444444',
                                strokeOpacity: 1.0,
                                strokeWeight: 2
                            });

                            path.setMap(map);
                        }
                   }
                }

            </script>
        </head>
        <main>
            <body onload='load()'>
            <div id='map' style='width: 1000px; height: 600px'></div>
            <form action='' method='post' id='mapForm'>
                <p>Place Name: <input size='20' type='text' name='name' placeholder='Place Name'></p>
                <p>Address: <input size='20' type='text' name='address' placeholder='Place Name'></p>
                <p>Latitude: <input size='20' type='text' id='latbox' name='lat' value='57.062661319658496'></p>
                <p>Longitude: <input size='20' type='text' id='lngbox' name='lng' value='-2.1295508919433814'></p>
                <p>Type:
                <select name='typeID' id='typeID' onclick="checkType()">";
                    <?
                    //Takes all database information from the Genre TABLE.
                    $sql_query = 'SELECT * FROM Type';

                    //Process the query
                    $result = $db->query($sql_query);

                    // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
                    while ($row = $result->fetch_array()) {
                        $typeID = $row['typeID'];
                        $typeName = $row['typeName'];
                        echo "<option id='{$typeID}' value='{$typeID}'>$typeName</option>";
                    }
                    ?>
                </select></p>
                <p><input type='submit' value='Submit'></p>
            </form>
            </body>
        <?
        include("scripts/footer.php");
    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include (__DIR__ . "/../scripts/dbconnect.php");
            $name = $_POST["name"];
            $address = $_POST["address"];
            $lat = $_POST["lat"];
            $lng = $_POST["lng"];
            $typeID = $_POST["typeID"];

            $sql = "INSERT INTO location (name, address, lat, lng, typeID) VALUES ('" . $name . "', '" . $address . "', " . $lat . ", " . $lng . ", " . $typeID . ")";
            if (mysqli_query($db, $sql)) {
                header("location:../mapPage");
            } else {
                echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
            }
        }
        //test
        } else {
            header("location:404");
        }
        ?>
