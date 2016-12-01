<!-- Displays all Club and Societies as a list, which can be searched and filtered by the user. Will include information
about the clubs like events and descriptions of each club. It will also include an events overview calender to show
when the latest events are for each club and society.-->

<!--Allows user to view all verified health and wellbeing blog posts as per system requirements. Site Admin will have
overlay to authorise/reject blog posts. As per System Requirements.-->

<?php
include ("scripts/dbconnect.php");
include ("scripts/header.php");
echo "
<main>
<h2>Clubs and Societies</h2>";
if ($_SESSION['accessLevel']==21||$_SESSION['accessLevel']==31){
            echo "<a id='createClubFormLink' href='/Forms/createClubForm'>Create Club Form</a>";
        }
?>
<main>
    <h2>Clubs and Societies</h2>
    <p>Below is a list of all Clubs and Societies</p>
    <table>
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
        $genreArray = array();
        $result2 = $db->query($sql_query2);
        while ($row2 = $result2->fetch_array()){
            $genreArray = array($row2['genreID'], $row2['name']);
        }
        echo "<p>" . var_dump($array) . "</p>";

        // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
        while ($row = $result->fetch_array()) {
            echo "<tr class='hoverableRowsAndColumns'><th class='hoverableSpecificRowAndColumn'>" . $row['clubName'] . "</th>";
            echo "<th class='hoverableSpecificRowAndColumn'>" . $genreArray[$row['genreID']] . "</th>"; //the name row contains the name of the genre
            echo "<th class='hoverableSpecificRowAndColumn'>" . $row['clubDescription'] . "</th>";
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