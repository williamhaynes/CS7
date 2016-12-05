<!--Allows user to view all verified health and wellbeing blog posts as per system requirements. Site Admin will have
overlay to authorise/reject blog posts. As per System Requirements.-->

<?php
include ("scripts/dbconnect.php");
include ("scripts/header.php");
echo "
<main>
<h2>Health and Wellbeing Articles</h2>
";
if (isset($_SESSION['username'])) {
    echo "<a id='createArticleLink' href='/createHealthAndWellbeingForm'> Create Article </a>";
    if ($_SESSION['accessLevel']==31) {
        echo "<a id='verifyArticleLink' href='/verifyHealthAndWellbeingForm'> Verify Articles </a>";
    }
}
echo "

<ul>
";

/*
 * Pulls database information from the 'Health News Table' if it has been verified
 */
$sql_query = "SELECT * FROM HealthNews WHERE verified = '1';";

/*
 * Processes the SQL Query
 */
$result = $db->query($sql_query);


/*
 * Iterate through the table and output the data 
 */
while($row = $result->fetch_array()){
    $itemID = $row['itemID'];
    $title = $row['title'];
    $content = $row['content'];
    $authorName = $row['authorName'];
    echo "<li><p><h1>$title</h1></p><p>$content</p>";
    echo "<p>Author: $authorName</p></li>";
    if($_SESSION['accessLevel'] == 31) {
        echo "<a href='Forms/healthAndWellbeingForm/{$itemID}'> Edit </a>";
    }
}
echo "
<a class='twitter-timeline'
  href=\"https://twitter.com/portyacad\">
    Tweets by @portyacad
</a>";

echo "</main>";
include ("scripts/footer.php");

?>