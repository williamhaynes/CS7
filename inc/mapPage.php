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

                <?
                    $sql_query = "SELECT * FROM Location;";

                    //Once all information has been pulled process the SQL query
                    $result = $db->query($sql_query);


                    //Iterate through and sort out all the data
                     while($row = $result->fetch_array()){
                         $locationID = $row['locationID'];
                         $name = $row['name'];
                         $address = $row['address'];
                         $lat = $row['lat'];
                         $lng = $row['lng'];
                         $typeID = $row['typeID'];
                         echo "
                                var marker = new google.maps.LatLng($lat, $lng);
                                var marker = new google.maps.Marker({
                                position: portlethenLatLng,
                                    map: map,
                                    title: '$name',
                                    draggable: false
                                });

                         ";
                     }
                 ?>

            }
        </script>
        <a href='mapForm'>Link to Map Form</a>
    </head>
    <main>
        <body onload='load()'>
             <div id='map' style='width: 1000px; height: 600px'></div>
        </body>
    </main>


<?

include ("scripts/footer.php");
?>


