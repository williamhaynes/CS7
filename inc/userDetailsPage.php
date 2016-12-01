<!--
The page will hold details about the current user. They will be allowed to make any changes to their details and to clearly
see what their access rights are, i.e. club Administrator rights.

Possible ability to expand upon this and allow them to see their pending and verified posts, though this is
an option for expandability and is not a requirement.
-->

<?php
include ("scripts/header.php");
include("scripts/dbconnect.php");

echo "
    <main>
    <p>userDetailsPage</p>";

/*
 * If a user is logged in, according to the session cookie, then select all the data from the database for that user
 * Pull the following information:
 * Username: The username of the user
 * Password: The password of the user
 * Email Address: The email address of the user
 * Display Name: The display name of the user
 * Level Code: The level code for the user
 */
if (isset($_SESSION['username'])) {
    $sql_query = "SELECT * FROM User WHERE userName ='" . $_SESSION['username'] ."';";
    $result = $db->query($sql_query);
    while ($row = $result->fetch_array()) {
        echo "<p>UserName: " . $row['userName'] . "</p>";
        echo "<p>Password: " . $row['password'] . "</p>";
        echo "<p>Email Address: " . $row['emailAddress'] . "</p>";
        echo "<p>Display Name: " . $row['displayName'] . "</p>";
        echo "<p>Level Code: " . $row['levelCode'] . "</p>";
    }
}
    echo "</main>";

include ("scripts/footer.php");
?>