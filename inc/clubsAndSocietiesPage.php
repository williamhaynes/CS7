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

echo "
    <p>Below is a list of all Clubs and Societies</p><ul>
";

/*
 * Using the database take all the information from the Club Table
 * Using an SQL command to pull all the information
 */
$sql_query = "SELECT * FROM Club;";

/*
 * Once all information has been pulled process the SQL query
 */
$result = $db->query($sql_query);

/*
 * Iterate through and sort out all the data
 */
while($row = $result->fetch_array()){
    $clubID = $row['clubID'];
    $clubName = $row['clubName'];
    echo "<li><a href='clubPage/{$clubID}'> $clubName </a></li>";
}

echo "</main>";
include ("scripts/footer.php");

?>