<!--Will display all the stored information on each club as single web pages-->

<?php
include ("scripts/header.php");

echo "
    <main>
    <p>Welcome to SPECIFIC!! Clubs and Societies Page</p>
    </main>
    ";


$selectedClub = $_POST['selectedClub'];

//Takes all database information from the Club Table for a chosen club.
$sql_query = "SELECT * FROM " . $selectedClub . ";";

//Process the query
$result = $db->query($sql_query);

// Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
while ($row = $result->fetch_array()) {
    echo "<p>" . $row['clubName'] . "</p>";
    echo "<p>" . $row['clubDescription'] . "</p>";
    echo "<p>" . $row['contactInformation'] . "</p>";
}

include ("scripts/footer.php");
?>