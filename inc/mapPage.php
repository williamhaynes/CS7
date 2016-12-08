<!--Functional Requirement: Will have a number of popup overlays to display additional information as required in
System Requirements.-->

<?php
include ("scripts/header.php");
include ("scripts/dbconnect.php");
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
<div id="legend"><h3>Legend</h3></div>
<script>
    var map;
    var arrayOfLandmarks = [];
    var arrayOfViewpoints = [];
    var arrayOfAreas = [];
    var arrayOfRoutes = [];
    var arrayOfPolylines = [];
    var directionsService;
    var directionsDisplay;
    var arrayOfClickedPoints = [];

    function initMap() {
        var portlethenLatLng = new google.maps.LatLng(57.062661319658496, -2.1295508919433814);
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            mapTypeId: 'roadmap',
            center: portlethenLatLng
        });

        arrayOfClickedPoints.push(portlethenLatLng);
        arrayOfClickedPoints.push(portlethenLatLng);

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
            div.innerHTML = '<img src="' + icon + '"> ' + name + '<input type="checkbox" id ='+checkboxID+' onclick="legendCheck()" checked>';
            legend.appendChild(div);
        }

        var directions = document.createElement('div');
        directions.id = directions;

        directions.innerHTML = '<p>Directions'+'<input type="checkbox" id ="directionsCheckbox" onclick="directionsCheck()"></p>'
            +'<p><input type="text" id ="firstPoint" placeholder="Click 1st icon" style="display: none" value="" readonly><input type="hidden" id ="firstPointLatLng"></p>'
            +'<p><input type="text" id ="secondPoint" placeholder="Click 2nd icon" style="display: none" value="" readonly><input type="hidden" id ="secondPointLatLng"></p>'
            +'<p><input type="button" value="Calculate Route" id ="calcRoute" style="display: none" onclick="calcRoute()"></p>';

        legend.appendChild(directions);

        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);

        var mapFormButton = document.createElement('div');
        <? if($_SESSION['accessLevel'] == 31||$_SESSION['accessLevel'] == 11){?>
            mapFormButton.innerHTML="<a href='/mapForm' class='button'>Map Form</a>";
        <?}?>

        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(mapFormButton);

        // Create a <script> tag and set the USGS URL as the source.
        //var script = document.createElement('script');
        // This example uses a local copy of the GeoJSON stored at
        // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
        //script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';

        var script = document.createElement('script');
        script.innerHTML = eqfeed_callback(
            {"landmarks": [
                <?


                $sql_queryLandmarks = 'SELECT * FROM location WHERE typeID = 1';
                $resultLandmarks = $db->query($sql_queryLandmarks);
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
            ],"viewpoints":[
                <?
                $sql_queryViewpoints = 'SELECT * FROM location WHERE typeID = 2';
                $resultViewpoints = $db->query($sql_queryViewpoints);
                while ($row = $resultViewpoints->fetch_array()) {
                ?>
                    {
                        "locationID": "<?php print $row['locationID'];?>",
                        "geometry": {"type": "Viewpoint", "coordinates": [<?php print $row['lat'];?>, <?php print $row['lng'];?>]},
                        "name": "<?php print $row['name'];?>",
                        "address": "<?php print $row['address'];?>",
                        "description": "<?php print $row['description'];?>"
                        //"markerImage":"images/red.png",
                    },
                <?}?>
                    ],"areas":[
                <?
                $sql_queryAreas = 'SELECT * FROM location WHERE typeID = 3';
                $resultAreas = $db->query($sql_queryAreas);
                while ($row = $resultAreas->fetch_array()) {
                ?>                    {
                        "locationID": "<?php print $row['locationID'];?>",
                        "geometry": {"type": "Area", "coordinates": [<?php print $row['lat'];?>, <?php print $row['lng'];?>]},
                        "name": "<?php print $row['name'];?>",
                        "address": "<?php print $row['address'];?>",
                        "description": "<?php print $row['description'];?>"
                        //"markerImage":"images/red.png",
                    },
                <?}?>
                    ],"routes":[
                <?
                $sql_queryRoutes = 'SELECT * FROM location WHERE typeID = 4';
                $resultRoutes = $db->query($sql_queryRoutes);
                while ($row = $resultRoutes->fetch_array()) {
                ?>
                {
                        "locationID": "<?php print $row['locationID'];?>",
                        "geometry": {"type": "Route", "coordinates": [<?php print $row['lat'];?>, <?php print $row['lng'];?>]},
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
        window.eqfeed_callback = function(results) {



            //Trying to add a info window
            var infowindow = new google.maps.InfoWindow({
                content: "loading..."
            });

            // Event that closes the Info Window with a click on the map
            google.maps.event.addListener(map, 'click', function() {
                infowindow.close();
                if(arrayOfPolylines.length>0) {
                    arrayOfPolylines[arrayOfPolylines.length - 1].setVisible(false);
                }
            });


            //Adding landmarks to map
            for (var i = 0; i < results.landmarks.length; i++) {
                var coords = results.landmarks[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0],coords[1]);
                arrayOfLandmarks.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.landmarks[i].name,
                    description: results.landmarks[i].description,
                    address: results.landmarks[i].address,
                    icon: '../style/landmark.png',
                    latlngCoords: coords
                }));

                arrayOfLandmarks[i].addListener('click', function(){
                    infowindow.setContent( '<div id="iw-container">' +
                        '<div class="iw-title">'+this.title+'</div>' +
                            '<div class="iw-outsidecontent">'+
                                '<div class="iw-content">' +
                                    '<div class="iw-subTitle">Description</div>' +
                                    '<img src="http://dreamatico.com/data_images/park/park-2.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                                    this.description+
                                    '<div class="iw-subTitle">Address</div>' +
                                    this.address+
                                '</div>' +
                            '</div>' +
                        '</div>');
                    //$("<div class='iw-outsidecontent'></div>").wrap("<div class='iw-content'></div>");
                    infowindow.open(map, this);
                    if(arrayOfPolylines.length>0) {
                        arrayOfPolylines[arrayOfPolylines.length - 1].setVisible(false);
                    }
                    //Adding to arrayOfClickedPoints
                    arrayOfClickedPoints.push(this.position);
                    //Trying to add point to route
                    addPointToRoute(this.title, this.latlngCoords);
                });
            }

            //Adding viewpoints to map
            for (var i = 0; i < results.viewpoints.length; i++) {
                var coords = results.viewpoints[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0],coords[1]);
                arrayOfViewpoints.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.viewpoints[i].name,
                    description: results.viewpoints[i].description,
                    address: results.viewpoints[i].address,
                    icon: '../style/viewpoint.png'
                }));

                arrayOfViewpoints[i].addListener('click', function(){
                    infowindow.setContent( '<div id="iw-container">' +
                        '<div class="iw-title">'+this.title+'</div>' +
                        '<div class="iw-outsidecontent">'+
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Description</div>' +
                        '<img src="http://dreamatico.com/data_images/park/park-2.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                        this.description+
                        '<div class="iw-subTitle">Address</div>' +
                        this.address+
                        '</div>' +
                        '</div>' +
                        '</div>');
                    //$("<div class='iw-outsidecontent'></div>").wrap("<div class='iw-content'></div>");
                    infowindow.open(map, this);
                    if(arrayOfPolylines.length>0) {
                        arrayOfPolylines[arrayOfPolylines.length - 1].setVisible(false);
                    }
                    //Adding to arrayOfClickedPoints
                    arrayOfClickedPoints.push(this.position);
                });
            }

            //Adding areas to map
            for (var i = 0; i < results.areas.length; i++) {
                var coords = results.areas[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0],coords[1]);
                arrayOfAreas.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.areas[i].name,
                    description: results.areas[i].description,
                    address: results.areas[i].address,
                    icon: '../style/area.png'
                }));

                arrayOfAreas[i].addListener('click', function(){
                    infowindow.setContent( '<div id="iw-container">' +
                        '<div class="iw-title">'+this.title+'</div>' +
                        '<div class="iw-outsidecontent">'+
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Description</div>' +
                        '<img src="http://dreamatico.com/data_images/park/park-2.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                        this.description+
                        '<div class="iw-subTitle">Address</div>' +
                        this.address+
                        '</div>' +
                        '</div>' +
                        '</div>');
                    //$("<div class='iw-outsidecontent'></div>").wrap("<div class='iw-content'></div>");
                    infowindow.open(map, this);
                    if(arrayOfPolylines.length>0) {
                        arrayOfPolylines[arrayOfPolylines.length - 1].setVisible(false);
                    }
                    //Adding to arrayOfClickedPoints
                    arrayOfClickedPoints.push(this.position);
                });
            }

            //Adding routes to map
            for (var i = 0; i < results.routes.length; i++) {
                var coords = results.routes[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0],coords[1]);
                arrayOfRoutes.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.routes[i].name,
                    description: results.routes[i].description,
                    address: results.routes[i].address,
                    array: results.routes[i].array,
                    icon: '../style/route.png'
                }));

                arrayOfRoutes[i].addListener('click', function(){
                    infowindow.setContent( '<div id="iw-container">' +
                        '<div class="iw-title">'+this.title+'</div>' +
                        '<div class="iw-outsidecontent">'+
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Description</div>' +
                        '<img src="http://dreamatico.com/data_images/park/park-2.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                        this.description+
                        '<div class="iw-subTitle">Address</div>' +
                        this.address+
                        '</div>' +
                        '</div>' +
                        '</div>');
                    //$("<div class='iw-outsidecontent'></div>").wrap("<div class='iw-content'></div>");
                    //random comment to hopefully make azure update
                    infowindow.open(map, this);
                    var routeArray = this.array.split(',');
                    var routeLatLng = [];
                    for(i=0;i<routeArray.length/2;i=i+2){
                        routeLatLng.push(new google.maps.LatLng(routeArray[i],routeArray[i+1]));
                    }
                    //Adding to arrayOfClickedPoints
                    arrayOfClickedPoints.push(this.position);


                    arrayOfPolylines.push(new google.maps.Polyline({
                        path: routeLatLng,
                        geodesic: true,
                        strokeColor: '#ff4d46',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    }));
                        if(arrayOfPolylines.length<2){
                            arrayOfPolylines[arrayOfPolylines.length - 1].setMap(map);
                        }else{
                            arrayOfPolylines[arrayOfPolylines.length-2].setVisible(false);
                            arrayOfPolylines[arrayOfPolylines.length - 1].setMap(map);
                        }
                });
            }
        }

    function legendCheck() {
        if (document.getElementById('landmarkCheckbox').checked){
            for (var i = 0; i < arrayOfLandmarks.length; i++) {
                arrayOfLandmarks[i].setVisible(true);
            }
        }else if(!document.getElementById('landmarkCheckbox').checked){
            for (var i = 0; i < arrayOfLandmarks.length; i++) {
                arrayOfLandmarks[i].setVisible(false);
            }
        }
        if (document.getElementById('viewpointCheckbox').checked){
            for (var i = 0; i < arrayOfViewpoints.length; i++) {
                arrayOfViewpoints[i].setVisible(true);
            }
        }else if(!document.getElementById('viewpointCheckbox').checked){
            for (var i = 0; i < arrayOfViewpoints.length; i++) {
                arrayOfViewpoints[i].setVisible(false);
            }
        }
        if (document.getElementById('areaCheckbox').checked){
            for (var i = 0; i < arrayOfAreas.length; i++) {
                arrayOfAreas[i].setVisible(true);
            }
        }else if(!document.getElementById('areaCheckbox').checked){
            for (var i = 0; i < arrayOfAreas.length; i++) {
                arrayOfAreas[i].setVisible(false);
            }
        }
        if (document.getElementById('routeCheckbox').checked){
            for (var i = 0; i < arrayOfRoutes.length; i++) {
                arrayOfRoutes[i].setVisible(true);
            }
        }else if(!document.getElementById('routeCheckbox').checked){
            for (var i = 0; i < arrayOfRoutes.length; i++) {
                arrayOfRoutes[i].setVisible(false);
            }
        }
    }

    function directionsCheck() {
        if (document.getElementById('directionsCheckbox').checked){
            document.getElementById('firstPoint').style.display='';
            document.getElementById('secondPoint').style.display='';
            document.getElementById('calcRoute').style.display='';
        }else{
            document.getElementById('firstPoint').style.display='none';
            document.getElementById('secondPoint').style.display='none';
            document.getElementById('calcRoute').style.display='none';
        }
    }

    function addPointToRoute(name, point) {
        if (document.getElementById('directionsCheckbox').checked){
            if(!document.getElementById('firstPoint').value){
                document.getElementById('firstPoint').value=name;
                document.getElementById('firstPointLatLng').value=point;
            }else if(!document.getElementById('secondPoint').value){
                document.getElementById('secondPoint').value=name;
                document.getElementById('secondPointLatLng').value=point;
            }
        }else{
        }
    }

    function calcRoute() {
        var startString = document.getElementById('firstPointLatLng').value;
        var endString = document.getElementById('secondPointLatLng').value;

        var startArray = startString.split(",");
        var endArray = endString.split(",");


        var start =  new google.maps.LatLng(startArray[0], startArray[1]);
        var end =  new google.maps.LatLng(endArray[0], endArray[1]);
 
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);
            } else {
                alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
            }
        });
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE&callback=initMap">
</script>

<!-- Below this line doesn't have anything to do with map-->

</body>
<?

include ("scripts/footer.php");
?>
