<!--Will display all the stored information on each club as single web pages-->


<?php
    include ("scripts/dbconnect.php");
    include ("scripts/header.php");
    $clubID = $params['clubID'];
    echo "<main>

        <!-- Trying to add a facebookfeed -->
                <div id=\"fb-root\"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = \"//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8\";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
";
        /*
         * Access the database information from the Club Table for the chosen club
         * Using the SQL command to select all the information
         */
        $sql = "SELECT * FROM club where clubID = '$clubID'";
        /*
         * Process the result query
         */
        $result = $db->query($sql);
        /*
         * Once information has been accessed iterate through the database and present all the data
         * Show information regarding the club such as clubName, clubDescription etc.
         */
        while($row = $result->fetch_array())
        {
            $clubID = $row['clubID'];
            $_SESSION['clubID'] = $row['clubID'];

            $clubName = $row['clubName'];
            $_SESSION['clubName'] = $row['clubName'];

            $activity = $row['activity'];
            $_SESSION['activity'] = $row['activity'];

            $clubDescription = $row['clubDescription'];
            $_SESSION['clubDescription'] = $row['clubDescription'];

            $sessionTime = $row['sessionTime'];
            $_SESSION['sessionTime'] = $row['sessionTime'];

            $contactName = $row['contactName'];
            $_SESSION['contactName'] = $row['contactName'];

            $contactNumber = $row['contactNumber'];
            $_SESSION['contactNumber'] = $row['contactNumber'];

            $contactEmail = $row['contactEmail'];
            $_SESSION['contactEmail'] = $row['contactEmail'];

            $website = $row['website'];
            $_SESSION['website'] = $row['website'];

            $websiteUrl = $row['websiteUrl'];
            $_SESSION['websiteUrl'] = $row['websiteUrl'];

            $facebook = $row['facebook'];
            $_SESSION['facebook'] = $row['facebook'];

            $facebookUrl = $row['facebookUrl'];
            $_SESSION['facebookUrl'] = $row['facebookUrl'];

            $genreID = $row['genreID'];
            $_SESSION['genreID'] = $row['genreID'];

            $adminID = $row['adminID'];
            $_SESSION['adminID'] = $row['adminID'];

            //fb logo https://facebookbrand.com/wp-content/themes/fb-branding/prj-fb-branding/assets/images/fb-art.png
            //www logo http://www.charlenebower.com/wp-content/uploads/2014/11/website-image.jpg

            echo "
            <atricle>
                 <h2 id='clubName'>{$clubName}</h2>
                 <p id='activity'>{$activity}</p>
                 <p id='clubDescription'>{$clubDescription}</p>
                 <p id='sessionTime'>{$sessionTime}</p>
                 <p id='contactName'>Contact: $contactName</p>
                 <p id='contactNumber'>Contact Number: $contactNumber</p>
                 <p id='contactEmail'>Email: $contactEmail</p>
                 <a id='websiteUrl'><img id='websiteLogo' src='' alt='' style='width:50px;height:50px;'></a>
                 <a id='facebookUrl'><img id='facebookLogo' src='' alt='' style='width:50px;height:50px;'></a>
                 <div id='facebookFeed'></div>
                 <script>
                    var website = $website;
                    var facebook = $facebook;
                    var websiteUrl = '{$websiteUrl}';
                    var facebookUrl = '{$facebookUrl}';
                    /*
                     * If they have a website show the url and website logo according to what it on their website
                     * else set logo to certain size
                     */
                    if (website==1){
                        document.getElementById('websiteUrl').setAttribute ('href', websiteUrl);
                        document.getElementById('websiteLogo').setAttribute('src','http://www.charlenebower.com/wp-content/uploads/2014/11/website-image.jpg');
                    }else{
                        document.getElementById('websiteLogo').setAttribute('style','width:0px;height:0px;')
                    }
                    /*
                     * If they have a facebook page then display the url and and logo on the facebook page
                     * else set logo to certain size
                     */
                    if (facebook==1){
                        document.getElementById('facebookUrl').setAttribute ('href', facebookUrl);
                        document.getElementById('facebookLogo').setAttribute('src','https://facebookbrand.com/wp-content/themes/fb-branding/prj-fb-branding/assets/images/fb-art.png');
                        /*Adding a facebook feed
                         */
                        document.getElementById('facebookFeed').innerHTML('<div class=\"fb-page\" data-href=\"https://www.facebook.com/tarlandtrails/\" data-tabs=\"timeline\" data-small-header=\"false\" data-adapt-container-width=\"true\" data-hide-cover=\"false\" data-show-facepile=\"true\"><blockquote cite=\"https://www.facebook.com/tarlandtrails/\" class=\"fb-xfbml-parse-ignore\"><a href=\"https://www.facebook.com/tarlandtrails/\">Tarland Trails</a></blockquote></div>');
                    }else{
                        document.getElementById('facebookLogo').setAttribute('style','width:0px;height:0px;')
                    }
                 </script>";
            include ("scripts/commentBox.php");
        echo "</atricle>";
        }
        echo "</main>";
        /*
         * If the current user is an admin i.e is logged into the page as a admin or has level 31 which is
         * the access level of an admin user
         */
        if (($_SESSION['userID']!=NULL&&$_SESSION['userID']==$_SESSION['adminID']||$_SESSION['accessLevel']==31)) {
            echo "<a id='clubAdminFormEditLink' href='{$clubID}/clubAdminForm'>Club Admin Form</a>";
        } else {
        }
             
    include ("scripts/footer.php");
?>
