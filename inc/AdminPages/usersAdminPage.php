<!-- Canother Comment-->
<?php
include(__DIR__."/../scripts/header.php");
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
        <tr>
            <th>Example</th>
            <th>Example</th>
            <th>Example</th>
            <th>Example</th>
        </tr>
        <?
        include (__DIR__ . "/../scripts/dbconnect.php");
        //Takes all database information from the Users Table.
        $sql_query = "SELECT * FROM User;";
        //Process the query
        if (mysqli_query($db, $sql_query)) {
        } else {
            echo "Error: " . $sql_query . "<br>Error Message:" . mysqli_error($db);
        }
        $result = $db->query($sql_query);
        // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
        while($row = $result->fetch_array()){
            echo "<tr><th>" . $row['userName'] . "</th>";
            echo "<th>" . $row['emailAddress'] . "</th>";
            echo "<th>" . $row['displayName'] . "</th>";
            echo "<th>" . $row['levelCode'] . "</th></tr>";
        }
        ?>
        <tr>
            <th>Example2</th>
            <th>Example2</th>
            <th>Example2</th>
            <th>Example2</th>
        </tr>
    </table>
    <p>Got to between table and main</p>
</main>
<?
echo "<p>Got to end of file before footer</p>";
include(__DIR__."/../scripts/footer.php");
?>