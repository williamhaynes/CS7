<!-- Exclusively accessed by Site Administrators. Allows site administrators to view all users, their details, and
change their access controls.-->

<?php/*
include ("../scripts/header.php");

echo "
<main>
<h2>Users Admin Page</h2>
<p>Below is a list of all Members</p>
<table>
    <tr>
        <th>Username</th>
        <th>Email Address</th>
        <th>Display Name</th>
        <th>Level Code</th>
    </tr>";

//Takes all database information from the Users Table.
include ("../scripts/dbconnect.php");
$sql_query = "SELECT * FROM User;";

//Process the query
$result = $db->query($sql_query);

// Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
while($row = $result->fetch_array()){

    echo "<tr>
                <th>" . $row['userName'] . "</th>
                <th>" . $row['emailAddress'] . "</th>
                <th>" . $row['displayName'] . "</th>
                <th>" . $row['levelCode'] . "</th>
          </tr>";
}

echo "</table></main>";
include ("scripts/footer.php");
*/



include ("../scripts/header.php");

echo "
    <main>
    <p>Welcome to map Page</p>
    </main>
    ";

include ("../scripts/footer.php");
?>