<!-- Displays all Club and Societies as a list, which can be searched and filtered by the user. Will include information
about the clubs like events and descriptions of each club. It will also include an events overview calender to show
when the latest events are for each club and society.-->

<!--Allows user to view all verified health and wellbeing blog posts as per system requirements. Site Admin will have
overlay to authorise/reject blog posts. As per System Requirements.-->

<?php
include ("scripts/dbconnect.php");
include ("scripts/header.php");
if ($_SESSION['accessLevel']==21||$_SESSION['accessLevel']==31){
            echo "<a id='createClubFormLink' href='/Forms/createClubForm'>Create Club Form</a>";
        }
?>
<main>
    <script>
        /*
         * Funcion inspired by code from http://www.w3schools.com/howto/howto_js_filter_table.asp
         */
        function searchByWord() {
            //Get Which section to search
            var searchCriteria;
            var section;
            searchCriteria = document.getElementById("filterByOptions").val();

            //switch to determine section
            switch(searchCriteria) {
                case clubname:
                    section = 0;
                    break;
                case genre:
                    section = 1;
                    break;
                case description:
                    section = 2;
                    break;
                default:
                    section = 0; //defaults to club name
            }

            // Declare variables
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("usersTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
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

    <h2>Clubs and Societies of Portlethen Go!</h2>
    <p>Below is a list of all Clubs and Societies</p>
    <table id="usersTable">
        <input type="text" id="searchInput" onkeyup="searchByWord()" placeholder="Search by Keyword..">
        <select id="filterByOptions">
            <option value="clubname">Club Name</option>
            <option value="genre">Genre</option>
            <option value="description">Description</option>
        </select>
        <tr>
            <th>Club Name</th>
            <th>Genre</th>
            <th>Club Description</th>
        </tr>
<?
include(__DIR__ . "/../scripts/dbconnect.php");
//Takes all database information from the clubs Table.
$sql_query = "SELECT * FROM club;";
$sql_query2 = "SELECT * FROM genre";
//Process the queries
if (mysqli_query($db, $sql_query)) {
} else {
echo "Error: " . $sql_query . "<br>Error Message:" . mysqli_error($db);
}
$result = $db->query($sql_query);
//Takes all database information from the genre Table.
if (mysqli_query($db, $sql_query2)) {
} else {
echo "Error: " . $sql_query2 . "<br>Error Message:" . mysqli_error($db);
}
$genreArray = array(); //array to store genre ids and names as key -> value pairs
$result2 = $db->query($sql_query2);
while ($row2 = $result2->fetch_array()){    //iterate through result to create array
$index = $row2['genreID'];  //index of array
$value = $row2['name'];     //value of array
$genreArray[$index] = $value; //array values
}

// Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
while ($row = $result->fetch_array()) {
    $clubID = $row['clubID'];
    $clubName = $row['clubName'];
    $index2 = $row['genreID'];
echo "<tr class='hoverableRowsAndColumns' onclick=\"location.href='" . "clubPage/{$clubID}'\"><td class='hoverableSpecificRowAndColumn'>" . $clubName . "</td>";
echo "<td class='hoverableSpecificRowAndColumn'>" . $genreArray[$index2] . "</td>"; //the name row contains the name of the genre
echo "<td class='hoverableSpecificRowAndColumn'>" . $row['clubDescription'] . "</td>";
echo "</tr>";
}
?>
</table>
</main>
<?
/*
* Using the database take all the information from the Club Table
* Using an SQL command to pull all the information

$sql_query = "SELECT * FROM Club;";

/*
* Once all information has been pulled process the SQL query

$result = $db->query($sql_query);

/*
* Iterate through and sort out all the data


while($row = $result->fetch_array()){
$clubID = $row['clubID'];
$clubName = $row['clubName'];
echo "<li><a href='clubPage/{$clubID}'> $clubName </a></li>";
}

echo "</main>";*/
include ("scripts/footer.php");
?>