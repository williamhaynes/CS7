<!-- Canother Comment-->
<?php
include(__DIR__."/../scripts/header.php");
?>
<main>
    <h2>Users Admin Page</h2>
    <p>Below is a list of all Members</p>
    <table>
        <tr>
            <th>Username</th>
            <th>Email Address</th>
            <th>Display Name</th>
            <th>Level Code</th>
        </tr>
        <?
        include (__DIR__ . "/../scripts/dbconnect.php");
        //Takes all database information from the Users Table.
        $sql_query = "SELECT * FROM User;";
        //Process the query
        if (mysqli_query($db, $sql_query)) {
        } else {
            echo "Error: " . $sql_query . "<br>Error Message:" . mysqli_error($db);
        }
        $result = $db->query($sql_query);
        // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
        while($row = $result->fetch_array()){
            echo "<tr><th>" . $row['userName'] . "</th>";
            echo "<th>" . $row['emailAddress'] . "</th>";
            echo "<th>" . $row['displayName'] . "</th>";
            echo "<th>" . translateLevelCode($row['levelCode']) . "</th>";
            //If the user is a club administrator
            if ($row['levelCode'] === 21){
                $sql_query2 = "SELECT clubName FROM Club WHERE adminID = '" . $row['userID'] ."';";
                if (mysqli_query($db, $sql_query2)) {
                } else {
                    echo "Error: " . $sql_query2 . "<br>Error Message:" . mysqli_error($db);
                }
                $result2 = $db->query($sql_query2);
                $listOfClubs = "";
                while($row = $result->fetch_array()) {
                    $listOfClubs .= $row['clubName'] . "<br>";
                }
                echo "<th>" . $listOfClubs . "</th>";
            }
            echo "</tr>";
        }
        /*
         * Function to translate the level code in to a string which makes more sense to a site administrator
         * @param - $levelCode is the numerical value returned from the database
         */
        function translateLevelCode($levelCode){
            switch ($levelCode) {
                case 1:
                    return "Contributor";
                case 11:
                    return "NKPAG";
                case 21:
                    return "Club Administrator";
                case 31:
                    return "Site Administrator";
                default:
                    return "Unknown User";
            }
        }
        ?>
    </table>
</main>
<?
echo "<p>Got to end of file before footer</p>";
include(__DIR__."/../scripts/footer.php");
?>