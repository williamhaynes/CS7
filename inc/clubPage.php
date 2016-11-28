<!--Will display all the stored information on each club as single web pages-->


<?php
    include ("scripts/dbconnect.php");
    include ("scripts/header.php");
    $clubID = $params['clubID'];
    echo "<main>";
        //Takes all database information from the Club Table for a chosen club.
        $sql = "SELECT * FROM club where clubID = '/clubPage/{$clubID}'";
        //Process the query
        $result = $db->query($sql);
        // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
        while($row = $result->fetch_array())
        {
            $clubID = $row['clubID'];
            $clubName = $row['clubName'];
            $clubDescription = $row['clubDescription'];
            $contactInformation = $row['contactInformation'];
            $adminID = $row['adminID'];
            echo "
            <atricle>
                 <h2>{$clubName}</h2>
                 <p>{$clubDescription}</p>
                 <p>{$contactInformation}</p>
             </atricle>";
        }
        echo "</main>";
    include ("scripts/footer.php");
?>
