<!-- Exclusively accessed by Site Administrators. Allows site administrators to view all users, their details, and
change their access controls.-->
<?php
include("../scripts/dbconnect.php");
include("../scripts/header.php");
?>
<main>
    <h2>Users Admin Page</h2>
    <p>Below is a list of all Members</p>
    <table>
        <tr>
            <th>Username</th>
            <th>Email Address</th>
            <th>Display Name</th>
            <th>Level Code</th>
        </tr>
        <?php
        //Takes all database information from the Users Table.

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
        ?>
    </table>
    </main>
<?php
echo "<p>Got to end of file before footer</p>";
include ("../scripts/footer.php");
?>