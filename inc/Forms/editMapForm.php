<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include ("scripts/dbconnect.php");
        include ("scripts/header.php");
        $locationID = $params['locationID'];
        ?>
        <head>
            <title>editMapForm</title>
            <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE'
                    type='text/JavaScript'></script>
            <script type='text/JavaScript'>
                var count = 0;
                var map;
                var marker;
                var markerLatLng;
                var portlethenLatLng = new google.maps.LatLng(57.062661319658496, -2.1295508919433814);
                function load() {
                    map = new google.maps.Map(document.getElementById('map'), {center: portlethenLatLng, zoom: 13, mapTypeId: 'roadmap'});
                    <?//Takes all database information from the location TABLE.
                    $sql_queryLatLng = "'SELECT lat,lng FROM location WHERE locationID = '+$locationID";
                    $resultLatLng = $db->query($sql_queryLatLng);
                    while ($rowLatLng = $resultLatLng->fetch_array()) {?>
                            markerLatLng = new google.maps.LatLng(<?php print $rowLatLng['lat'];?>, <?php print $rowLatLng['lng'];?>);
                            marker = new google.maps.Marker({position: markerLatLng, map: map, title: 'Marker', draggable: true});
                        <?}?>
                }



            </script>
        </head>
        <main>
        <body onload='load()'>
        <div id='map' style='width: 1000px; height: 600px'></div>
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>tinymce.init({selector: 'textarea'});</script>
        <?//Takes all database information from the location TABLE.
        $sql_query = "'SELECT * FROM location WHERE locationID = '+$locationID";
        $result = $db->query($sql_query);
        while ($row = $result->fetch_array()) {?>
        <form action='' method='post' id='mapForm'>
            <p>Place Name: <input size='20' type='text' name='name' value="<?php print $row['name'];?>" placeholder='Place Name'></p>
            <p>Address: <input size='20' type='text' name='address' value="<?php print $row['address'];?>" placeholder='Address'></p>
            <p>Description: <textarea name="description" id="description"><?php print $row['description'];?></textarea></p>
            <p>Latitude: <input size='20' type='text' id='latbox' name='lat' value='<?php print $row['lat'];?>'></p>
            <p>Longitude: <input size='20' type='text' id='lngbox' name='lng' value='<?php print $row['lng'];?>'></p>
            <script>if (<?php print $row['typeID'];?>==4){
                <?
                $sql_queryRoute = "'SELECT * FROM route WHERE locationID = '+$locationID";
                $resultRoute = $db->query($sql_queryRoute);
                while ($rowRoute = $resultRoute->fetch_array()) {?>
                    <p>latlngString: <input size='20' type='text' id='latlngString' name='latlngString' value='<?php print $rowRoute['array'];?>'></p>
                    <p>Type: Route</p>
                <?}?>
            }elseif(<?php print $row['typeID'];?>==3){
                    <?
                    $sql_queryArea = "'SELECT * FROM area WHERE locationID = '+$locationID";
                    $resultArea = $db->query($sql_queryArea);
                    while ($rowArea = $resultArea->fetch_array()) {?>
                        <p>latlngString: <input size='20' type='text' id='latlngString' name='latlngString' value='<?php print $rowArea['array'];?>'></p>
                        <p>Type: Area</p>
                    <?}?>
                } elseif(<?php print $row['typeID'];?>==2){
                    <p>Type: Viewpoint </p>
                }else{
                    <p>Type: Landmark </p>
                }
            </script>
            <p><input type='submit' value='Submit'></p>
            <?}?>
        </form>
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
        //IF TYPEID = ROUTE
        if ($typeID==4){
            $sql = "INSERT INTO location (name, address, description, lat, lng, typeID) VALUES ('" . $name . "', '" . $address . "', '" . $description . "', " . $lat . ", " . $lng . ", " . $typeID . ")";
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
            $sql = "INSERT INTO location (name, address, description, lat, lng, typeID) VALUES ('" . $name . "', '" . $address . "', '" . $description . "', " . $lat . ", " . $lng . ", " . $typeID . ")";
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
            $sql = "INSERT INTO location (name, address, description, lat, lng, typeID) VALUES ('" . $name . "', '" . $address . "', '" . $description . "', " . $lat . ", " . $lng . ", " . $typeID . ")";
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