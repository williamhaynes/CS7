<!--Allows user to view all verified health and wellbeing blog posts as per system requirements. Site Admin will have
overlay to authorise/reject blog posts. As per System Requirements.-->

<?php
include ("scripts/dbconnect.php");
include ("scripts/header.php");
echo "
<main>
<h2>Health and Wellbeing Articles</h2>
<a href='/Forms/createHealthAndWellbeingForm'> Create New News </a>
<p>Below is a list of all health and wellbeing articles</p>
<ul>
";

//Takes all database information from the Health News Table if it has been verified.
$sql_query = "SELECT * FROM HealthNews WHERE verified = '1';";

//Process the query
$result = $db->query($sql_query);

// Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
while($row = $result->fetch_array()){
    $itemID = $row['itemID'];
    $title = $row['title'];
    $content = $row['content'];
    //We should probably add an author
    echo "<li><p><h1>$title</h1></p><p>$content</p><a href='Forms/healthAndWellbeingForm/{$itemID}'> Edit </a></li>";
}
echo "</main>";
include ("scripts/footer.php");

?>