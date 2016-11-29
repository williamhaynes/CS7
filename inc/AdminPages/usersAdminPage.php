<!-- Exclusively accessed by Site Administrators. Allows site administrators to view all users, their details, and
change their access controls.-->

<?php
include ("../scripts/dbconnect.php");
include ("../scripts/header.php");
echo "
<main>
<h2>Users Admin Page</h2>
<p>Below is a list of all Members</p>
<ul>";

//Takes all database information from the Users Table.
$sql_query = "SELECT * FROM User;";

//Process the query
$result = $db->query($sql_query);

// Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
while($row = $result->fetch_array()){
    $user = $row['userName'];
    $level = $row['levelCode'];
    echo "<li><a href='clubPage/{user}'> $level </a></li>";
}

echo "</main>";
include ("../scripts/footer.php");

?>