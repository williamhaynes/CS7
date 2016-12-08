<!--Allows user to view all verified health and wellbeing blog posts as per system requirements. Site Admin will have
overlay to authorise/reject blog posts. As per System Requirements.-->

<?php
include ("scripts/dbconnect.php");
include ("scripts/header.php");
echo "<main>
      <h2>Health & Wellbeing</h2>
      <div id='divForHealthNews'>";
if (isset($_SESSION['username'])) {
    echo "<a id='createArticleLink' href='/createHealthAndWellbeingForm' class='button'> Create Article </a>";
    if ($_SESSION['accessLevel']==31) {
        echo "<a id='verifyArticleLink' href='/healthAndWellbeingForm' class='button'> Verify Articles </a>";
    }
}
echo "<ul>";

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
    echo "<li id='healthNewsArticle'><p><h1 id='healthNewsTitle'>$title</h1></p><p id='healthNewsContent'>$content</p>";
    echo "<p id='healthNewsAuthor'>Author: $authorName</p>";
    if($_SESSION['accessLevel'] == 31) {
        echo "<a href='Forms/healthAndWellbeingForm/{$itemID}' class='button' id='healthNewsEditButton'> Edit </a></li>";
    }
    else{
        echo "</li>";
    }
}
echo "</div>";
echo "<div id='divForTwitterFeed'><a class=\"twitter-timeline\" href=\"https://twitter.com/portyacad\">Tweets by portyacad</a> <script async src=\"//platform.twitter.com/widgets.js\" charset=\"utf-8\"></script></div>";
echo "</main>";
include ("scripts/footer.php");

?>