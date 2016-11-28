<!--Functional Requirement. A page to display all the clubs and societies in a list, and allow them to be searched and
filtered. Will also have an events overview calendar.-->

<?php
include ("scripts/header.php");

echo "
    <main>
    <p>Welcome to Clubs and Societies Page</p>
    </main>
    ";

/*
//Takes all database information from the Club Table.
$sql_query = "SELECT * FROM Club;";

//Process the query
$result = $db->query($sql_query);

// Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
while ($row = $result->fetch_array()) {
    echo "<p>" . $row['clubName'] . "</p>";
    echo "<p>" . $row['clubDescription'] . "</p>";
    echo "<p>" . $row['contactInformation'] . "</p>";
}*/



include ("scripts/footer.php");
?>