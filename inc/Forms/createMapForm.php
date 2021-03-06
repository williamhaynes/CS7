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
                        load();
                    }
                    //If its a Viewpoint
                    if (document.getElementById('2').selected) {
                        load();
                    }
                    //If its a Area
                    if (document.getElementById('3').selected) {
                        load();
                        var markersLatLng=[];
                        //['{lat: '+marker.getPosition().lat()+', lng: '+marker.getPosition().lat()+'}']
                        var path;
                        var area =  new google.maps.Polygon({});
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
                            //alert(markersLatLng);
                            var string="";
                            //alert(markersLatLng.length)
                            for(i=0;i<markersLatLng.length;i++){
                                //alert(markersLatLng[i].toString());
                                string+=markersLatLng[i].lat()+','+markersLatLng[i].lng()+',';
                            }
                            document.getElementById('latlngString').value = string;
                            area.setMap(null);
                            area = new google.maps.Polygon({
                                paths: markersLatLng,
                                strokeColor: '#FF0000',
                                strokeOpacity: 0.8,
                                strokeWeight: 2,
                                fillColor: '#aff3ff',
                                fillOpacity: 0.35,
                                clickable: false
                            });

                            area.setMap(map);
                        }
                    }
                    //If its a route
                    if (document.getElementById('4').selected) {
                        load();
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
                           //alert(markersLatLng);
                           var string="";
                           //alert(markersLatLng.length)
                           for(i=0;i<markersLatLng.length;i++){
                               //alert(markersLatLng[i].toString());
                               string+=markersLatLng[i].lat()+','+markersLatLng[i].lng()+',';
                           }
                            document.getElementById('latlngString').value = string;

                            path = new google.maps.Polyline({
                                path: markersLatLng,
                                geodesic: true,
                                strokeColor: '#ff4d46',
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
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>tinymce.init({selector: 'textarea'});</script>
            <div id="divForCreateMapForm">
                <form action='' method='post' id='mapForm'>
                    <p>Place Name: <input size='20' type='text' name='name' placeholder='Place Name'></p>
                    <p>Address: <input size='20' type='text' name='address' placeholder='Address'></p>
                    <p>Description: <textarea name="description" id="description"></textarea></p>
                    <input size='20' type='hidden' id='latbox' name='lat' value='57.062661319658496'>
                    <input size='20' type='hidden' id='lngbox' name='lng' value='-2.1295508919433814'>
                    <input size='20' type='hidden' id='latlngString' name='latlngString'>
                    <input type="hidden" name="verified" id="verified" value='0'>
                    <p>Type:
                    <select name='typeID' id='typeID' onclick="checkType()">";
                        <?
                        if($_SESSION['accessLevel']==11||$_SESSION['accessLevel']==31){?>
                            <script>document.getElementById('verified').value = '1';</script>
                        <?}
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
            </div>
            </body>
        <?
        include("scripts/footer.php");
    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include (__DIR__ . "/../scripts/dbconnect.php");
            $name = $_POST["name"];
            $address = $_POST["address"];
            $description = $_POST["description"];
            $lat = $_POST["lat"];
            $lng = $_POST["lng"];
            $typeID = $_POST["typeID"];
            $latlngString = $_POST["latlngString"];
            $verified = $_POST["verified"];
            //IF TYPEID = ROUTE
            if ($typeID==4){
                $sql = "INSERT INTO location (name, address, description, lat, lng, typeID, verified) VALUES ('" . $name . "', '" . $address . "', '" . $description . "', " . $lat . ", " . $lng . ", " . $typeID . ", " . $verified . ")";
                if (mysqli_query($db, $sql)) {
                    $sqlGetLocationID = "SELECT locationID FROM location WHERE name ='" . $name . "' AND address = '" . $address ."'";
                    $result = $db->query($sqlGetLocationID);
                    while($row = $result->fetch_array()){
                        $resultLocationID = $row['locationID'];
                    }
                    $sql2 = "INSERT INTO route (array, locationID) VALUES ( '" . $latlngString . "', '" . $resultLocationID . "')";
                    if (mysqli_query($db, $sql2)) {
                        header("location:../mapPage");
                    }
                    else {
                        echo "Error: " . $sql2 . "<br>Error Message:" . mysqli_error($db);
                    }
                } else {
                    echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
                }
            }
            //IF TYPEID = AREA
            elseif($typeID==3){
                $sql = "INSERT INTO location (name, address, description, lat, lng, typeID, verified) VALUES ('" . $name . "', '" . $address . "', '" . $description . "', " . $lat . ", " . $lng . ", " . $typeID . ", " . $verified . ")";
                if (mysqli_query($db, $sql)) {
                    $sqlGetLocationID = "SELECT locationID FROM location WHERE name ='" . $name . "' AND address = '" . $address ."'";
                    $result = $db->query($sqlGetLocationID);
                    while($row = $result->fetch_array()){
                        $resultLocationID = $row['locationID'];
                    }
                    $sql2 = "INSERT INTO area (array, locationID) VALUES ( '" . $latlngString . "', '" . $resultLocationID . "')";
                    if (mysqli_query($db, $sql2)) {
                        header("location:../mapPage");
                    }
                    else {
                        echo "Error: " . $sql2 . "<br>Error Message:" . mysqli_error($db);
                    }
                } else {
                    echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
                }
            }
            //IF TYPEID = LANDMARK OR VIEWPOINT
            else {
                $sql = "INSERT INTO location (name, address, description, lat, lng, typeID, verified) VALUES ('" . $name . "', '" . $address . "', '" . $description . "', " . $lat . ", " . $lng . ", " . $typeID . ", " . $verified . ")";
                if (mysqli_query($db, $sql)) {
                    header("location:../mapPage");
                } else {
                    echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
                }
            }
        }
        //test
        } else {
            header("location:404");
        }
        ?>
