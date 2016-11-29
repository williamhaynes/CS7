<!-- Exclusively accessed by Site Administrators. Allows site administrators to view all users, their details, and
change their access controls.-->
<!--
<?php
include("../scripts/header.php");

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
include("../scripts/dbconnect.php");
$sql_query = "SELECT * FROM User;";

//Process the query
$result = $db->query($sql_query);

// Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
while($row = $result->fetch_array()){

    echo "<tr>";
    echo "<th>" . $row['userName'] . "</th>";
    echo "<th>" . $row['emailAddress'] . "</th>";
    echo "<th>" . $row['displayName'] . "</th>";
    echo "<th>" . $row['levelCode'] . "</th>";
    echo"</tr>";
}
echo "</table>
        </main>";
include ("../scripts/footer.php");
?>-->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include ("../scripts/header.php");
    ?>
    <main>
        <form action="loginPage" method="post">
            <input type="text" placeholder="User Name" name="username">
            <input type="password" placeholder="Password" name="password">
            <p><input type="submit" value='Login'></p>
        </form>
    </main>
    <?
    include("../scripts/footer.php");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include("../scripts/dbconnect.php");
}