<!-- Danother Comment-->
<?php
session_start();
if($_SESSION['accessLevel'] == '31') {
    include(__DIR__ . "/../scripts/header.php");
    ?>
    <main>
        <h2>Users Admin Page</h2>
        <p>To modify a user select them on the table below and change the relevant value</p>
        <table>
            <tr>
                <th>Username</th>
                <th>Email Address</th>
                <th>Display Name</th>
                <th>Level Code</th>
                <th>Club Name</th>
            </tr>
            <?
            include(__DIR__ . "/../scripts/dbconnect.php");
            //Takes all database information from the Users Table.
            $sql_query = "SELECT * FROM User;";
            //Process the query
            if (mysqli_query($db, $sql_query)) {
            } else {
                echo "Error: " . $sql_query . "<br>Error Message:" . mysqli_error($db);
            }
            $result = $db->query($sql_query);
            // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
            while ($row = $result->fetch_array()) {
                echo "<tr class='hoverableRowsAndColumns'><th>" . $row['userName'] . "</th>";
                echo "<th>" . $row['emailAddress'] . "</th>";
                echo "<th>" . $row['displayName'] . "</th>";
                echo "<th>" . translateLevelCode($row['levelCode']) . "</th>";
                echo "<th>";
                //If the user is a club administrator or site administrator
                if ($row['levelCode'] == 21 || $row['levelCode'] == 31) {
                    //Generate SQL query to get club name if club admin or site admin
                    $sql_query2 = "SELECT clubName FROM Club WHERE adminID = '" . $row['userID'] . "';";
                    if (mysqli_query($db, $sql_query2)) {
                    } else {
                        echo "Error: " . $sql_query2 . "<br>Error Message:" . mysqli_error($db);
                    }
                    $result2 = $db->query($sql_query2);

                    //store all results as a string
                    $listOfClubs = "";
                    while ($row2 = $result2->fetch_array()) {
                        $listOfClubs .= $row2['clubName'] . "<br>";
                    }
                    //return the string
                    echo "$listOfClubs";
                }
                echo "</th>";
                echo "</tr>";
            }

            /*
             * Function to translate the level code in to a string which makes more sense to a site administrator
             * @param - $levelCode is the numerical value returned from the database
             */
            function translateLevelCode($levelCode)
            {
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
    include(__DIR__ . "/../scripts/footer.php");
} else{
    //header("location:../404");
}
?>