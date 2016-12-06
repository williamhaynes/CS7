<!--Functional Requirement: Will have a number of popup overlays to display additional information as required in
System Requirements.-->

<?php
include ("scripts/header.php");
include(__DIR__ . "/../scripts/dbconnect.php");
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
<script>
    var map;
    var arrayOfMarkers = [];
    function initMap() {
        var portlethenLatLng = new google.maps.LatLng(57.062661319658496, -2.1295508919433814);
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            mapTypeId: 'roadmap',
            center: portlethenLatLng
        });




        // Create a <script> tag and set the USGS URL as the source.
        //var script = document.createElement('script');
        // This example uses a local copy of the GeoJSON stored at
        // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
        //script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';

        var script = document.createElement('script');
        script.innerHTML = eqfeed_callback(
            {"markers": [
                {
                    "locationID":"201",
                    "geometry":{"type":"Point","coordinates":[57.052299579818296,-2.169376331396506]},
                    "name":"Road",
                    "address":"Road",
                    "description":"<p>Road</p>"
                    //"markerImage":"images/red.png",
                },
                {
                    "locationID":"301",
                    "geometry":{"type":"Point","coordinates":[57.062299579818400,-2.569376331396506]},
                    "name":"Street",
                    "address":"Street",
                    "description":"<p>Street</p>"
                    //"markerImage":"images/red.png",
                },
            ] });

        document.getElementsByTagName('head')[0].appendChild(script);






        // Loop through the results array and place a marker for each
        // set of coordinates.
        window.eqfeed_callback = function(results) {
            //alert(results.markers.length);

            //Trying to add a info window
            var infowindow = new google.maps.InfoWindow({
                content: "loading...",
                maxWidth: 350
            });

            // *
            // START INFOWINDOW CUSTOMIZE.
            // The google.maps.event.addListener() event expects
            // the creation of the infowindow HTML structure 'domready'
            // and before the opening of the infowindow, defined styles are applied.
            // *
            google.maps.event.addListener(infowindow, 'domready', function() {

                // Reference to the DIV that wraps the bottom of infowindow
                var iwOuter = $('.gm-style-iw');

                /* Since this div is in a position prior to .gm-div style-iw.
                 * We use jQuery and create a iwBackground variable,
                 * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
                 */
                var iwBackground = iwOuter.prev();

                // Removes background shadow DIV
                iwBackground.children(':nth-child(2)').css({'display': 'none'});

                // Removes white background DIV
                iwBackground.children(':nth-child(4)').css({'display': 'none'});

                // Moves the infowindow 115px to the right.
                iwOuter.parent().parent().css({left: '115px'});

                // Moves the shadow of the arrow 76px to the left margin.
                iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                    return s + 'left: 76px !important;'
                });

                // Moves the arrow 76px to the left margin.
                iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                    return s + 'left: 76px !important;'
                });

                // Changes the desired tail shadow color.
                iwBackground.children(':nth-child(3)').find('div').children().css({
                    'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px',
                    'z-index': '1'
                });

                // Reference to the div that groups the close button elements.
                var iwCloseBtn = iwOuter.next();

                // Apply the desired effect to the close button
                iwCloseBtn.css({
                    opacity: '1',
                    right: '38px',
                    top: '3px',
                    border: '7px solid #48b5e9',
                    'border-radius': '13px',
                    'box-shadow': '0 0 5px #3990B9'
                });

                // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
                if ($('.iw-content').height() < 140) {
                    $('.iw-bottom-gradient').css({display: 'none'});
                }

                // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
                iwCloseBtn.mouseout(function () {
                    $(this).css({opacity: '1'});
                });
            });


            // Event that closes the Info Window with a click on the map
            google.maps.event.addListener(map, 'click', function() {
                infowindow.close();
            });

            for (var i = 0; i < results.markers.length; i++) {
                var coords = results.markers[i].geometry.coordinates;
                var latLng = new google.maps.LatLng(coords[0],coords[1]);
                arrayOfMarkers.push(new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: results.markers[i].name,
                    description: results.markers[i].description
                }));

                arrayOfMarkers[i].addListener('click', function(){
                    infowindow.setContent( '<div id="iw-container">' +
                        '<div class="iw-title">'+this.title+'</div>' +
                        '<div class="iw-content">' +
                        '<div class="iw-subTitle">Description</div>' +
                        '<img src="http://maps.marnoto.com/en/5wayscustomizeinfowindow/images/vistalegre.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                        ''+this.description+'' +
                        '<div class="iw-subTitle">Contacts</div>' +
                        '<p>VISTA ALEGRE ATLANTIS, SA<br>3830-292 Ílhavo - Portugal<br>'+
                        '<br>Phone. +351 234 320 600<br>e-mail: geral@vaa.pt<br>www: www.myvistaalegre.com</p>'+
                        '</div>' +
                        '<div class="iw-bottom-gradient"></div>' +
                        '</div>');
                    infowindow.open(map, this);
                });
            }
        }
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEU8Mfp0WPoXcqq8gJdbUTogp-6yDzXcE&callback=initMap">
</script>
</body>
<?

include ("scripts/footer.php");
?>


