<!-- Map Administration Page-->
<?php
//Allow access to session Cookies
session_start();
//Security check to ensure site administrator
if($_SESSION['accessLevel'] == '31'||$_SESSION['accessLevel'] == '11') {
    //Include Header
    include(__DIR__ . "/../scripts/header.php");
    function translateVerified($verified){
        switch ($verified) {
            case 0:
                return "False";
            case 1:
                return "True";
            default:
                return "False";
        }
    }
    ?>
    <main>
        <script>
            /*
             * Funcion inspired by code from http://www.w3schools.com/howto/howto_js_filter_table.asp
             */
            function searchArticle() {
                //Get Which section to search
                var searchCriteria;
                var section;
                searchCriteria = document.getElementById("filterByOptions").value;
                //switch to determine section
                switch(searchCriteria) {
                    case "locationID":
                        section = 0;
                        break;
                    case "name":
                        section = 1;
                        break;
                    case "description":
                        section = 2;
                        break;
                    case "address":
                        section = 3;
                        break;
                    case "verified":
                        section = 4;
                        break;
                    default:
                        section = 0; //defaults to itemID
                }

                // Declare variables
                var input, filter, table, tr, td, i;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("mapTable");
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
        <div id="divForMapAdminPage">
            <h2 class='pageHeaderText'>Map Administration</h2>
            <p>To alter information select it from the below table</p>
            <table id="mapTable">
                <input type="text" id="searchInput" onkeyup="searchArticle()" placeholder="Search by Keyword..">
                <select id="filterByOptions" onchange="searchArticle()">
                    <option value="locationID">Location ID</option>
                    <option value="name">Name</option>
                    <option value="address">Address</option>
                    <option value="description">Description</option>
                    <option value="verified">Verified</option>
                </select>
                <tr>
                    <th>Location ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Description</th>
                    <th>Verified</th>
                </tr>
                <?
                include(__DIR__ . "/../scripts/dbconnect.php");

                //Takes all database information from the healthnews for a chosen article.
                $sql = "SELECT * FROM location";
                //Process the query
                $result = $db->query($sql);
                // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
                while ($row = $result->fetch_array()) {
                    $locationID = $row['locationID'];
                    echo "<tr class='hoverableRowsAndColumns' onclick=\"location.href='" . "editMapForm/{$locationID}'\"><td class='hoverableSpecificRowAndColumn'>" . $row['locationID'] . "</td>";
                    echo "<td class='hoverableSpecificRowAndColumn'>" . $row['name'] . "</td>";
                    echo "<td class='hoverableSpecificRowAndColumn'>" . $row['address'] . "</td>";
                    echo "<td class='hoverableSpecificRowAndColumn'>". $row['description']."</td>";
                    echo "<td class='hoverableSpecificRowAndColumn'>" . translateVerified($row['verified']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </main>
    <?
    include(__DIR__ . "/../scripts/footer.php");
}
/*
  * If user isn't administrator kick them to page not found
  */
else{
    header("location:../404");
}
?>