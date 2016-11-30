<!--Will display all the stored information on each club as single web pages-->


<?php
    include ("scripts/dbconnect.php");
    include ("scripts/header.php");
    $clubID = $params['clubID'];
    echo "<main>";
        //Takes all database information from the Club Table for a chosen club.
        $sql = "SELECT * FROM club where clubID = '$clubID'";
        //Process the query
        $result = $db->query($sql);
        // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
        while($row = $result->fetch_array())
        {
            $_SESSION['clubID'] = $row['clubID'];

            $clubName = $row['clubName'];
            $_SESSION['clubName'] = $row['clubName'];

            $activity = $row['activity'];
            $_SESSION['activity'] = $row['activity'];

            $clubDescription = $row['clubDescription'];
            $_SESSION['clubDescription'] = $row['clubDescription'];

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

            $adminID = $row['adminID'];
            $_SESSION['adminID'] = $row['adminID'];

            //fb logo https://facebookbrand.com/wp-content/themes/fb-branding/prj-fb-branding/assets/images/fb-art.png

            echo "
            <atricle>
                 <h2 id='clubName'>{$clubName}</h2>
                 <p id='activity'>{$activity}</p>
                 <p id='clubDescription'>{$clubDescription}</p>
                 <p id='session'>{$session}</p>
                 <p id='contactName'>Contact: $contactName</p>
                 <p id='contactNumber'>Contact Number: $contactNumber</p>
                 <p id='contactEmail'>Email: $contactEmail</p>
                 <p id='websiteUrl'></p>
                 <p id='facebookUrl'></p>
                 <script>
                    var website = $website;
                    var facebook = $facebook;
                    var websiteUrl = '{$websiteUrl}';
                    var facebookUrl = '{$facebookUrl}';
                    
                    if (website==1){
                        document.getElementById('websiteUrl').innerHTML = websiteUrl;
                    }
                    if (facebook==1){
                        document.getElementById('facebookUrl').innerHTML = (<a href= facebookUrl </a>);
                    }
                 </script>
             </atricle>";
        }
        echo "</main>";

        if (($_SESSION['userID']==$_SESSION['adminID'])) {
            echo "<li><a href='{$clubID}/clubAdminForm'>clubAdminForm</a></li>";
        } else {
        }
             
    include ("scripts/footer.php");
?>
