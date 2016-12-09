<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include ("/../scripts/dbconnect.php");
        include ("/../scripts/header.php");
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
                    $sql_queryLatLng = "SELECT * FROM location WHERE locationID = '$locationID'";
                    $resultLatLng = $db->query($sql_queryLatLng);
                    while ($rowLatLng = $resultLatLng->fetch_array()) {?>
                        markerLatLng = new google.maps.LatLng(<?php print $rowLatLng['lat'];?>, <?php print $rowLatLng['lng'];?>);
                        marker = new google.maps.Marker({position: markerLatLng, map: map, title: 'Marker', draggable: false});
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
        $sql_query = "SELECT * FROM location WHERE locationID = '$locationID'";
        $result = $db->query($sql_query);
        while ($row = $result->fetch_array()) {?>
        <form action='' method='post' id='mapForm'>
            <input type='hidden' name='locationID' value="<?php print $row['locationID'];?>"><
            <p>Place Name: <input size='20' type='text' name='name' value="<?php print $row['name'];?>" placeholder='Place Name'></p>
            <p>Address: <input size='20' type='text' name='address' value="<?php print $row['address'];?>" placeholder='Address'></p>
            <p>Description: <textarea name="description" id="description"><?php print $row['description'];?></textarea></p>
            <p>Latitude: <input size='20' type='text' id='latbox' name='lat' value='<?php print $row['lat'];?>' readonly></p>
            <p>Longitude: <input size='20' type='text' id='lngbox' name='lng' value='<?php print $row['lng'];?>' readonly></p>
            <p>Type: <input size='20' type='text' id='type' readonly></p>
            <script>if (<?php print $row['typeID'];?>==4){
                document.getElementById('type').value = 'Route';
            }else if(<?php print $row['typeID'];?>==3){
                document.getElementById('type').value = 'Area';
            }else if(<?php print $row['typeID'];?>==2){
                document.getElementById('type').value = 'Viewpoint';
            }else{
                document.getElementById('type').value = 'Landmark';
            }
            </script>
            <p><input type='submit' value='Submit'></p>
            <?}?>
        </form>
        <a href='deleteMapForm/<?$locationID?>' class="button">Delete Marker</a>
        </body>
        <?
        include("/../scripts/footer.php");
    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include (__DIR__ . "/../scripts/dbconnect.php");
        $locationID = $_POST["locationID"];
        $name = $_POST["name"];
        $address = $_POST["address"];
        $description = $_POST["description"];
        $sql = "UPDATE location SET name = '" . $name . "', address =  '" . $address . "', description = '" . $description . "' WHERE locationID = $locationID";
        if (mysqli_query($db, $sql)) {
            header("location:../mapPage");
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
    }
} else {
    header("location:404");
}
?>