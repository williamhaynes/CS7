<!--
Will hold details on the specific user's account, this will allow them to make any changes to their details as they see
fit, it will also allow users to clearly see what their access rights are to the site. Possible ability to expand upon
this and allow them to see their pending and verified posts, though this is an option for expandability not a
requirement.
-->

<?php
include ("scripts/header.php");
include("scripts/dbconnect.php");

echo "
    <main>
    <p>userDetailsPage</p>";

if (isset($_SESSION['username'])) {
    $sql_query = "SELECT * FROM User WHERE userName ='" . $_SESSION['username'] ."';";
    $result = $db->query($sql_query);
    while ($row = $result->fetch_array()) {
        echo "<p>" . $row['userName'] . "</p>";
        echo "<p>" . $row['password'] . "</p>";
        echo "<p>" . $row['emailAddress'] . "</p>";
        echo "<p>" . $row['displayName'] . "</p>";
        echo "<p>" . $row['levelCode'] . "</p>";
    }
}
    echo "</main>";

include ("scripts/footer.php");
?>