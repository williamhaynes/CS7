<!-- Health and Wellbeing Administration Page-->
<?php
//Allow access to session Cookies
session_start();
//Security check to ensure site administrator
if($_SESSION['accessLevel'] == '31') {
    //Include Header
    include(__DIR__ . "/../scripts/header.php");
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
                    case "itemID":
                        section = 0;
                        break;
                    case "title":
                        section = 1;
                        break;
                    case "content":
                        section = 2;
                        break;
                    case "authorName":
                        section = 3;
                        break;
                    default:
                        section = 0; //defaults to itemID
                }

                // Declare variables
                var input, filter, table, tr, td, i;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("healthAndWellbeingTable");
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
        <h2>Health & Wellbeing Article Administration Page</h2>
        <p>To alter an article select it from the below table</p>
        <table id="healthAndWellbeingTable">
            <input type="text" id="searchInput" onkeyup="searchArticle()" placeholder="Search by Keyword..">
            <select id="filterByOptions" onchange="searchArticle()">
                <option value="itemID">Article ID</option>
                <option value="title">Article Title</option>
                <option value="content">Article Content</option>
                <option value="authorName">Author Name</option>
                <option value="verified">Verified</option>
            </select>
            <tr>
                <th>Article ID</th>
                <th>Article Title</th>
                <th>Article Content</th>
                <th>Verified</th>
                <th>Author Name</th>
            </tr>
            <?
            include(__DIR__ . "/../scripts/dbconnect.php");

    //Takes all database information from the healthnews for a chosen article.
    $sql = "SELECT * FROM healthnews";
    //Process the query
    $result = $db->query($sql);
            // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
            while ($row = $result->fetch_array()) {
                $itemID = $row['itemID'];
                echo "<tr class='hoverableRowsAndColumns' onclick=\"location.href='" . "healthAndWellbeingForm/{$itemID}'\"><td class='hoverableSpecificRowAndColumn'>" . $row['itemID'] . "</td>";
                echo "<td class='hoverableSpecificRowAndColumn'>" . $row['title'] . "</td>";
                echo "<td class='hoverableSpecificRowAndColumn'>" . $row['content'] . "</td>";
                echo "<td class='hoverableSpecificRowAndColumn'>" . $row['verified'] . "</td>";
                echo "<td class='hoverableSpecificRowAndColumn'>". $row['authorName']."</td>";
                echo "</tr>";
            }
            ?>
        </table>
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