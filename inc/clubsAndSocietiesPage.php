<!--Functional Requirement. A page to display all the clubs and societies in a list, and allow them to be searched and
filtered. Will also have an events overview calendar.-->

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

//Takes all database information from the Club Table.
$sql_query = "SELECT * FROM Club;";

//Process the query
$result = $db->query($sql_query);

// Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
while($row = $result->fetch_array()){
    $clubID = $row['clubID'];
    $clubName = $row['clubName'];
    echo "<li><a href='clubPage/{$clubID}'> $clubName </a></li>";
}

echo "</main>";
include ("scripts/footer.php");

?>



