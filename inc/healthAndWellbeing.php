<!--Allows user to view all verified health and wellbeing blog posts as per system requirements. Site Admin will have
overlay to authorise/reject blog posts. As per System Requirements.-->

<?php
    include ("scripts/header.php");

    echo "
    <main>
    <p>Welcome to Health and Wellbeing</p>
    </main>
    ";


//Takes all database information from the Health News Table.
$sql_query = "SELECT * FROM Health News;";

//Process the query
$result = $db->query($sql_query);

// Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
while ($row = $result->fetch_array()) {
    echo "<p>" . $row['title'] . "</p>";
    echo "<p>" . $row['content'] . "</p>";
}




    include ("scripts/footer.php");
?>