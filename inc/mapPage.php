<!-- MAP PAGE -->
<!-- MAP ICONS FROM https://mapicons.mapsmarker.com/ -->


<?php
session_start();
include("scripts/header.php");
include("scripts/dbconnect.php");
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
            height: 96.5%;
            margin-bottom: 200px;
            padding: 0;
        }
    </style>
</head>
<body>

<div id="map"></div>
<div id="legend"><h3>Legend</h3></div>
<div id="directions-panel"><h3>Directions</h3></div>
<div id="printButton"></div>

<script>
    var map;
    var arrayOfLandmarks = [];
    var arrayOfViewpoints = [];
    var arrayOfAreas = [];
    var arrayOfRoutes = [];
    var arrayOfPolylines = [];
    var arrayOfPolygons = [];
    var directionsService;
    var directionsDisplay;
    //Hiding route div
    document.getElementById('directions-panel').style.visibility = 'hidden';


    function initMap() {
        var portlethenLatLng = new google.maps.LatLng(57.062661319658496, -2.1295508919433814);
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            mapTypeId: 'roadmap',
            center: portlethenLatLng
        });

        var icons = {
            landmark: {
                name: 'Landmark',
                icon: '../style/landmark.png',
                id: 'landmarkCheckbox'
            },
            viewpoint: {
                name: 'Viewpoint',
                icon: '../style/viewpoint.png',
                id: 'viewpointCheckbox'
            },
            area: {
                name: 'Area',
                icon: '../style/area.png',
                id: 'areaCheckbox'
            },
            route: {
                name: 'Route',
                icon: '../style/route.png',
                id: 'routeCheckbox'
            }
        };

        //Creating the legend with icons
        var legend = document.getElementById('legend');
        for (var key in icons) {
            var type = icons[key];
            var name = type.name;
            var icon = type.icon;
            var checkboxID = type.id;
            var div = document.createElement('div');
            div.innerHTML = '<img src="' + icon + '"> ' + name + '<input type="checkbox" id =' + checkboxID + ' onclick="legendCheck()" checked>';
            legend.appendChild(div);
        }

        // mode of travel


        //

        var directions = document.createElement('div');
        directions.id = directions;

        directions.innerHTML = '<p>Directions' + '<input type="checkbox" id ="directionsCheckbox" onclick="directionsCheck()"></p>'
            + '<p><input type="text" id ="firstPoint" placeholder="Click 1st icon" style="display: none" value="" readonly><input type="hidden" id ="firstPointLatLng"></p>'
            + '<p><input type="text" id ="secondPoint" placeholder="Click 2nd icon" style="display: none" value="" readonly><input type="hidden" id ="secondPointLatLng"></p>'
            + '<p id="modeOfTravelText" style="display: none">Mode of Travel       ' + '<select id="mode" style="display: none"><option value="DRIVING">Driving</option><option value="WALKING">Walking</option><option value="BICYCLING">Bicycling</option><option value="TRANSIT">Transit</option></select>'
            + '<p><input type="button" value="Calculate Route" id ="calcRoute" style="display: none" onclick="calcRoute()"><input type="button" value="Reset" id ="resetRoute" style="display: none" onclick="resetRoute()"></p>';

        legend.appendChild(directions);

        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);

        //Adding print button to map
        var printButton = document.getElementById('printButton');
        var printDiv = document.createElement('div');
        printDiv.innerHTML = '<button onclick="window.print();">CLICK HERE TO PRINT!</button>';
        printButton.appendChild(printDiv);
        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(printButton);

        //Adding listener on to mode drop down
        document.getElementById('mode').addEventListener('change', function () {
            calcRoute();
        });

        //Adding edit button to map
        <?if (isset($_SESSION['username'])) {?>
        var mapFormButton = document . createElement('div');
        mapFormButton . innerHTML = "<a href='/createMapForm' class='button'>Map Form</a>";

        map . controls[google . maps . ControlPosition . RIGHT_BOTTOM] . push(mapFormButton);
        <?}?>

        // Create a <script> tag and set the USGS URL as the source.
        //var script = document.createElement('script');
        // This example uses a local copy of the GeoJSON stored at
        // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
        //script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';

        var script = document.createElement('script');
        script.innerHTML = eqfeed_callback(
            {
                "landmarks": [
                    <?


                    $sql_queryLandmarks = "SELECT * FROM location WHERE typeID = 1 AND verified = 1";
                    $resultLandmarks = $db->query($sql_queryLandmarks);
                    while ($row = $resultLandmarks->fetch_array()) {
                    ?>
                    {
                        "locationID": "<?php print $row['locationID'];?>",
                        "geometry": {
                            "type": "Landmark",
                            "coordinates": [<?php print $row['lat'];?>, <?php print $row['lng'];?>]
                        },
                        "name": "<?php print $row['name'];?>",
                        "address": "<?php print $row['address'];?>",
                        "description": "<?php print $row['description'];?>"
                        //"markerImage":"images/red.png",
                    },
                    <?}?>
                ], "viewpoints": [
                <?
                $sql_queryViewpoints = "SELECT * FROM location WHERE typeID = 2 AND verified = 1";
                $resultViewpoints = $db->query($sql_queryViewpoints);
                while ($row = $resultViewpoints->fetch_array()) {
                ?>
                {
                    "locationID": "<?php print $row['locationID'];?>",
                    "geometry": {
                        "type": "Viewpoint",
                        "coordinates": [<?php print $row['lat'];?>, <?php print $row['lng'];?>]
                    },
                    "name": "<?php print $row['name'];?>",
                    "address": "<?php print $row['address'];?>",
                    "description": "<?php print $row['description'];?>"
                    //"markerImage":"images/red.png",
                },
                <?}?>
            ], "areas": [
                <?
                $sql_queryAreas = "SELECT * FROM location WHERE typeID = 3 AND verified = 1";
                $resultAreas = $db->query($sql_queryAreas);
                while ($row = $resultAreas->fetch_array()) {
                ?>
                {
                    "locationID": "<?php print $row['locationID'];?>",
                    "geometry": {
                        "type": "Area",
                        "coordinates": [<?php print $row['lat'];?>, <?php print $row['lng'];?>]
                    },
                    "name": "<?php print $row['name'];?>",
                    "address": "<?php print $row['address'];?>",
                    "description": "<?php print $row['description'];?>",
                    <?
                    $locationID = $row['locationID'];
                    $sql_querySpecificRoute = "SELECT * FROM area WHERE locationID = $locationID";
                    $resultSpecificRoute = $db->query($sql_querySpecificRoute);
                    while ($rowRoute = $resultSpecificRoute->fetch_array()) {
                    ?>
                    "array": "<?php print $rowRoute['array'];?>"
                    //"markerImage":"images/red.png",
                },
                <?}
                }?>
            ], "routes": [
                <?
                $sql_queryRoutes = "SELECT * FROM location WHERE typeID = 4 AND verified = 1";
                $resultRoutes = $db->query($sql_queryRoutes);
                while ($row = $resultRoutes->fetch_array()) {
                ?>
                {
                    "locationID": "<?php print $row['locationID'];?>",
                    "geometry": {
                        "type": "Route",
                        "coordinates": [<?php print $row['lat'];?>, <?php print $row['lng'];?>]
                    },
                    "name": "<?php print $row['name'];?>",
                    "address": "<?php print $row['address'];?>",
                    "description": "<?php print $row['description'];?>",
                    <?
                    $locationID = $row['locationID'];
                    $sql_querySpecificRoute = "SELECT * FROM route WHERE locationID = $locationID";
                    $resultSpecificRoute = $db->query($sql_querySpecificRoute);
                    while ($rowRoute = $resultSpecificRoute->fetch_array()) {
                    ?>
                    "array": "<?php print $rowRoute['array'];?>"
                    //"markerImage":"images/red.png",
                },
                <?}
                }?>
            ]
            });
        document.getElementsByTagName('head')[0].appendChild(script);
        directionsService = new google.maps.DirectionsService;
        directionsDisplay = new google.maps.DirectionsRenderer;
    }


    // Loop through the results array and place a marker for each
    // set of coordinates.
    window.eqfeed_callback = function (results) {



        //Trying to add a info window
        var infowindow = new google.maps.InfoWindow({
            content: "loading..."
        });

        // Event that closes the Info Window with a click on the map
        google.maps.event.addListener(map, 'click', function () {
            infowindow.close();
            //If click remove routes and areas
            if (arrayOfPolylines.length > 0) {
                arrayOfPolylines[arrayOfPolylines.length - 1].setVisible(false);
            }
            if (arrayOfPolygons.length > 0) {
                arrayOfPolygons[arrayOfPolygons.length - 1].setVisible(false);
            }
        });

        //Adding landmarks to map
        for (var i = 0; i < results.landmarks.length; i++) {
                var coords = results.landmarks[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0], coords[1]);
                arrayOfLandmarks.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.landmarks[i].name,
                    description: results.landmarks[i].description,
                    address: results.landmarks[i].address,
                    icon: '../style/landmark.png',
                    latlngCoords: coords,
                    locationID: results.landmarks[i].locationID
                }));

                arrayOfLandmarks[arrayOfLandmarks.length-1].addListener('click', function () {
                    infowindow.setContent('<div id="iw-container">' +
                        '<div class="iw-title">' + this.title + '</div>' +
                        '<div class="iw-outsidecontent">' +
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Description</div>' +
                        '<img src="http://dreamatico.com/data_images/park/park-2.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                        this.description +
                        '<div class="iw-subTitle">Address</div>' +
                        this.address +
                        '<div class="iw-edit" id="iw-edit" style="visibility: hidden"><a href="/editMapForm/' + this.locationID + '" class="button">Edit</a></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');

                    infowindow.open(map, this);

                    //If signed in as NKPAG or SiteAdmin show edit button
                    <?if($_SESSION['accessLevel']==31||$_SESSION['accessLevel']==11){?>
                      document.getElementById("iw-edit").style.visibility = 'visible';
                    <?}?>

                    //If click remove routes and areas
                    if (arrayOfPolylines.length > 0) {
                        arrayOfPolylines[arrayOfPolylines.length - 1].setVisible(false);
                    }
                    if (arrayOfPolygons.length > 0) {
                        arrayOfPolygons[arrayOfPolygons.length - 1].setVisible(false);
                    }
                    //Trying to add point to route
                    addPointToRoute(this.title, this.latlngCoords);
                });

        }

        //Adding viewpoints to map
        for (var i = 0; i < results.viewpoints.length; i++) {
                var coords = results.viewpoints[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0], coords[1]);
                arrayOfViewpoints.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.viewpoints[i].name,
                    description: results.viewpoints[i].description,
                    address: results.viewpoints[i].address,
                    icon: '../style/viewpoint.png',
                    latlngCoords: coords,
                    locationID: results.viewpoints[i].locationID
                }));

                arrayOfViewpoints[arrayOfViewpoints.length-1].addListener('click', function () {
                    infowindow.setContent('<div id="iw-container">' +
                        '<div class="iw-title">' + this.title + '</div>' +
                        '<div class="iw-outsidecontent">' +
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Description</div>' +
                        '<img src="http://dreamatico.com/data_images/park/park-2.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                        this.description +
                        '<div class="iw-subTitle">Address</div>' +
                        this.address +
                        '<div class="iw-edit" id="iw-edit" style="visibility: hidden"><a href="/editMapForm/' + this.locationID + '" class="button">Edit</a></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');

                    infowindow.open(map, this);
                    //If signed in as NKPAG or SiteAdmin show edit button
                    <?if($_SESSION['accessLevel']==31||$_SESSION['accessLevel']==11){?>
                        document.getElementById("iw-edit").style.visibility = 'visible';
                    <?}?>

                    //If click remove routes and areas
                    if (arrayOfPolylines.length > 0) {
                        arrayOfPolylines[arrayOfPolylines.length - 1].setVisible(false);
                    }
                    if (arrayOfPolygons.length > 0) {
                        arrayOfPolygons[arrayOfPolygons.length - 1].setVisible(false);
                    }
                    //Trying to add point to route
                    addPointToRoute(this.title, this.latlngCoords);
                });
        }

        //Adding areas to map
        for (var i = 0; i < results.areas.length; i++) {
                var coords = results.areas[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0], coords[1]);
                arrayOfAreas.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.areas[i].name,
                    description: results.areas[i].description,
                    address: results.areas[i].address,
                    array: results.areas[i].array,
                    icon: '../style/area.png',
                    latlngCoords: coords,
                    locationID: results.areas[i].locationID
                }));

                arrayOfAreas[arrayOfAreas.length-1].addListener('click', function () {
                    infowindow.setContent('<div id="iw-container">' +
                        '<div class="iw-title">' + this.title + '</div>' +
                        '<div class="iw-outsidecontent">' +
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Description</div>' +
                        '<img src="http://dreamatico.com/data_images/park/park-2.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                        this.description +
                        '<div class="iw-subTitle">Address</div>' +
                        this.address +
                        '<div class="iw-edit" id="iw-edit" style="visibility: hidden"><a href="/editMapForm/' + this.locationID + '" class="button">Edit</a></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');

                    infowindow.open(map, this);

                    //If signed in as NKPAG or SiteAdmin show edit button
                    <?if($_SESSION['accessLevel']==31||$_SESSION['accessLevel']==11){?>
                    document.getElementById("iw-edit").style.visibility = 'visible';
                    <?}?>

                    var areaArray = this.array.split(',');
                    var areaLatLng = [];
                    for (var j = 0; j < areaArray.length - 1; j = j + 2) {
                        areaLatLng.push(new google.maps.LatLng(areaArray[j], areaArray[j + 1]));
                    }

                    arrayOfPolygons.push(new google.maps.Polygon({
                        path: areaLatLng,
                        strokeColor: '#FF0000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#aff3ff',
                        fillOpacity: 0.35,
                        clickable: false
                    }));
                    if (arrayOfPolygons.length < 2) {
                        arrayOfPolygons[arrayOfPolygons.length - 1].setMap(map);
                    } else {
                        arrayOfPolygons[arrayOfPolygons.length - 2].setVisible(false);
                        arrayOfPolygons[arrayOfPolygons.length - 1].setMap(map);
                    }
                    //If click remove routes
                    if (arrayOfPolylines.length > 0) {
                        arrayOfPolylines[arrayOfPolylines.length - 1].setVisible(false);
                    }
                    //Trying to add point to route
                    addPointToRoute(this.title, this.latlngCoords);
                });
        }


        //Adding routes to map
        for (var i = 0; i < results.routes.length; i++) {
                var coords = results.routes[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0], coords[1]);
                arrayOfRoutes.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.routes[i].name,
                    description: results.routes[i].description,
                    address: results.routes[i].address,
                    array: results.routes[i].array,
                    icon: '../style/route.png',
                    latlngCoords: coords,
                    locationID: results.routes[i].locationID
                }));

                arrayOfRoutes[arrayOfRoutes.length-1].addListener('click', function () {
                    infowindow.setContent('<div id="iw-container">' +
                        '<div class="iw-title">' + this.title + '</div>' +
                        '<div class="iw-outsidecontent">' +
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Description</div>' +
                        '<img src="http://dreamatico.com/data_images/park/park-2.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                        this.description +
                        '<div class="iw-subTitle">Address</div>' +
                        this.address +
                        '<div class="iw-edit" id="iw-edit" style="visibility: hidden"><a href="/editMapForm/' + this.locationID + '" class="button">Edit</a></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');

                    infowindow.open(map, this);

                    //If signed in as NKPAG or SiteAdmin show edit button
                    <?if($_SESSION['accessLevel']==31||$_SESSION['accessLevel']==11){?>
                    document.getElementById("iw-edit").style.visibility = 'visible';
                    <?}?>

                    var routeArray = this.array.split(',');
                    var routeLatLng = [];
                    for (var j = 0; j < routeArray.length - 1; j = j + 2) {
                        routeLatLng.push(new google.maps.LatLng(routeArray[j], routeArray[j + 1]));
                    }

                    //Trying to add point to route
                    addPointToRoute(this.title, this.latlngCoords);

                    arrayOfPolylines.push(new google.maps.Polyline({
                        path: routeLatLng,
                        geodesic: true,
                        strokeColor: '#ff4d46',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    }));
                    if (arrayOfPolylines.length < 2) {
                        arrayOfPolylines[arrayOfPolylines.length - 1].setMap(map);
                    } else {
                        arrayOfPolylines[arrayOfPolylines.length - 2].setVisible(false);
                        arrayOfPolylines[arrayOfPolylines.length - 1].setMap(map);
                    }
                    //If clicked remove polygons
                    if (arrayOfPolygons.length > 0) {
                        arrayOfPolygons[arrayOfPolygons.length - 1].setVisible(false);
                    }
                });
        }
    }

    function legendCheck() {
        if (document.getElementById('landmarkCheckbox').checked) {
            for (var i = 0; i < arrayOfLandmarks.length; i++) {
                arrayOfLandmarks[i].setVisible(true);
            }
        } else if (!document.getElementById('landmarkCheckbox').checked) {
            for (var i = 0; i < arrayOfLandmarks.length; i++) {
                arrayOfLandmarks[i].setVisible(false);
            }
        }
        if (document.getElementById('viewpointCheckbox').checked) {
            for (var i = 0; i < arrayOfViewpoints.length; i++) {
                arrayOfViewpoints[i].setVisible(true);
            }
        } else if (!document.getElementById('viewpointCheckbox').checked) {
            for (var i = 0; i < arrayOfViewpoints.length; i++) {
                arrayOfViewpoints[i].setVisible(false);
            }
        }
        if (document.getElementById('areaCheckbox').checked) {
            for (var i = 0; i < arrayOfAreas.length; i++) {
                arrayOfAreas[i].setVisible(true);
            }
        } else if (!document.getElementById('areaCheckbox').checked) {
            for (var i = 0; i < arrayOfAreas.length; i++) {
                arrayOfAreas[i].setVisible(false);
            }
        }
        if (document.getElementById('routeCheckbox').checked) {
            for (var i = 0; i < arrayOfRoutes.length; i++) {
                arrayOfRoutes[i].setVisible(true);
            }
        } else if (!document.getElementById('routeCheckbox').checked) {
            for (var i = 0; i < arrayOfRoutes.length; i++) {
                arrayOfRoutes[i].setVisible(false);
            }
        }
    }

    function directionsCheck() {
        if (document.getElementById('directionsCheckbox').checked) {
            document.getElementById('firstPoint').style.display = '';
            document.getElementById('secondPoint').style.display = '';
            document.getElementById('calcRoute').style.display = '';
            document.getElementById('resetRoute').style.display = '';
            document.getElementById('modeOfTravelText').style.display = '';
            document.getElementById('mode').style.display = '';
        } else {
            document.getElementById('firstPoint').style.display = 'none';
            document.getElementById('secondPoint').style.display = 'none';
            document.getElementById('calcRoute').style.display = 'none';
            document.getElementById('resetRoute').style.display = 'none';
            document.getElementById('modeOfTravelText').style.display = 'none';
            document.getElementById('mode').style.display = 'none';
            directionsDisplay.setMap(null);
            document.getElementById('directions-panel').style.visibility = 'hidden';
        }
    }

    function resetRoute() {
        document.getElementById('firstPoint').value = '';
        document.getElementById('secondPoint').value = '';
        document.getElementById('firstPointLatLng').value = '';
        document.getElementById('secondPointLatLng').value = '';
        directionsDisplay.setMap(null);
        document.getElementById('directions-panel').style.visibility = 'hidden';
    }

    function addPointToRoute(name, point) {
        if (document.getElementById('directionsCheckbox').checked) {
            if (!document.getElementById('firstPoint').value) {
                document.getElementById('firstPoint').value = name;
                document.getElementById('firstPointLatLng').value = point;
            } else if (!document.getElementById('secondPoint').value) {
                document.getElementById('secondPoint').value = name;
                document.getElementById('secondPointLatLng').value = point;
            }
        } else {
        }
    }

    function calcRoute() {
        var startString = document.getElementById('firstPointLatLng').value;
        var endString = document.getElementById('secondPointLatLng').value;

        if (!startString == "" || !startString == null, !endString == "" || !endString == null) {
            var selectedMode = document.getElementById('mode').value;
            var startArray = startString.split(",");
            var endArray = endString.split(",");


            var start = new google.maps.LatLng(startArray[0], startArray[1]);
            var end = new google.maps.LatLng(endArray[0], endArray[1]);
            var bounds = new google.maps.LatLngBounds();
            bounds.extend(start);
            bounds.extend(end);
            map.fitBounds(bounds);
            var request = {
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode[selectedMode]
            };
            directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                    directionsDisplay.setMap(map);
                    directionsDisplay.setPanel(document.getElementById('directions-panel'));
                    document.getElementById('directions-panel').style.visibility = 'visible';
                } else {
                    alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
                }
            });
        } else {
            alert("Please Fill All Required Fields");
        }
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE&callback=initMap">
</script>

<!-- Below this line doesn't have anything to do with map-->

</body>
<?

include("scripts/footer.php");
?>
