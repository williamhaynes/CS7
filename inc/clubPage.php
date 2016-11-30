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
            $clubID = $row['clubID'];
            $_SESSION['clubID'] = $clubID;
            $clubName = $row['clubName'];
            $_SESSION['clubName'] = $clubName;
            $clubDescription = $row['clubDescription'];
            $_SESSION['clubDescription'] = $clubDescription;
            $contactInformation = $row['contactInformation'];
            $_SESSION['contactInformation'] = $contactInformation;
            //Check adminID is not null
            if($row['adminID'] != 'NULL'){
                $adminID = $row['adminID'];
                $_SESSION['adminID'] = $adminID;
            }
            echo "
            <atricle>
                 <h2>{$clubName}</h2>
                 <p>{$clubDescription}</p>
                 <p>{$contactInformation}</p>
             </atricle>";
        }
        echo "</main>";

        if (isset($_SESSION['username'])) {
            echo "<li><a href='{$clubID}/clubAdminForm'>clubAdminForm</a></li>";
        } else {
        }
             
    include ("scripts/footer.php");
?>
