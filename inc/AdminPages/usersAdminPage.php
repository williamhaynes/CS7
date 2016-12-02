<!-- Danother Comment-->
<?php
session_start();
if($_SESSION['accessLevel'] == '31') {
    include(__DIR__ . "/../scripts/header.php");
    ?>
    <main>
        <script>
            /*
             * Funcion inspired by code from http://www.w3schools.com/howto/howto_js_filter_table.asp
             */
            function searchUser() {
                //Get Which section to search
                var searchCriteria;
                var section;
                searchCriteria = document.getElementById("filterByOptions").value;
                //switch to determine section
                switch(searchCriteria) {
                    case "username":
                        section = 0;
                        break;
                    case "emailAddress":
                        section = 1;
                        break;
                    case "displayName":
                        section = 2;
                        break;
                    case "levelCode":
                        section = 3;
                        break;
                    case "clubName":
                        section = 4;
                        break;
                    default:
                        section = 0; //defaults to username
                }

                // Declare variables
                var input, filter, table, tr, td, i;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("usersTable");
                tr = table.getElementsByTagName("tr");

                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[section];
                    if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
        <h2>Users Admin Page</h2>
        <p>To modify a user select them on the table below and change the relevant value</p>
        <table id="usersTable">
            <input type="text" id="searchInput" onkeyup="searchUser()" placeholder="Search by Keyword..">
            <select id="filterByOptions" onchange="searchUser()">
                <option value="username">Username</option>
                <option value="emailAddress">Email Address</option>
                <option value="displayName">Display Name</option>
                <option value="levelCode">Level Code</option>
                <option value="clubName">Club Name</option>
            </select>
            <tr>
                <th>Username</th>
                <th>Email Address</th>
                <th>Display Name</th>
                <th>Level Code</th>
                <th>Club Name</th>
            </tr>
            <?
            include(__DIR__ . "/../scripts/dbconnect.php");
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
                echo "<tr class='hoverableRowsAndColumns'><td class='hoverableSpecificRowAndColumn'>" . $row['userName'] . "</td>";
                echo "<td class='hoverableSpecificRowAndColumn'>" . $row['emailAddress'] . "</td>";
                echo "<td class='hoverableSpecificRowAndColumn'>" . $row['displayName'] . "</td>";
                echo "<td class='hoverableSpecificRowAndColumn'>" . translateLevelCode($row['levelCode']) . "</td>";
                echo "<td class='hoverableSpecificRowAndColumn'>";
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
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </main>
    <?
    include(__DIR__ . "/../scripts/footer.php");
} else{
    header("location:../404");
}
?>