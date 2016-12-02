<!--Allows details to be added to an existing map - required by System Requirements.-->
<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__ . "/../scripts/header.php");
        include(__DIR__ . "/../scripts/dbconnect.php");
        ?>
        echo "
        <head>
            <title>Map</title>
            <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE'
                    type='text/JavaScript'></script>
            <script type='text/JavaScript'>
                var count = 0;
                var map;
                function load() {
                    var portlethenLatLng = new google.maps.LatLng(57.062661319658496, -2.1295508919433814);
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
            <form action='' method='post' id='mapForm'>
                <p>Place Name: <input size='20' type='text' name='name' placeholder='Place Name'></p>
                <p>Address: <input size='20' type='text' name='name' placeholder='Place Name'></p>
                <p>Latitude: <input size='20' type='text' id='latbox' name='lat' value='57.062661319658496'></p>
                <p>Longitude: <input size='20' type='text' id='lngbox' name='lng' value='-2.1295508919433814'></p>
                <p>Type: </p>
                <select name='typeID' id='typeID'>
                    <?
                    //Takes all database information from the Genre TABLE.
                    $sql_query = 'SELECT * FROM Type';

                    //Process the query
                    $result = $db->query($sql_query);

                    // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
                    while ($row = $result->fetch_array()) {
                        $typeID = $row['typeID'];
                        $typeName = $row['typeName'];
                        echo "<option value='{$typeID}'>$typeName</option>";
                    }
                    ?>
                </select>
                <p><input type=\"submit\" value='Submit'></p>
            </form>
            </body>
        </main>
        ";
        <?
        include("scripts/footer.php");
    }
}
?>