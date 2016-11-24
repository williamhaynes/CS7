<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Form</title>
</head>

<body>


</body>
</html>



<?php
/**
 * Created by PhpStorm.
 * User: hype_
 * Date: 21/11/2016
 * Time: 14:12
 */

include("dbconnect.php");

$userName = $_POST['userName'];
$password = $_POST['password'];

$sql_query = "SELECT * FROM User WHERE userName ='" . $userName . "' AND password = '" . $password ."';";

$result = $db->query($sql_query);

// Mysql_num_row is counting table row
$count = mysqli_num_rows($result);

// Checks to see if there was a result from the query
if($count<1){   //if query returned no result
    echo "<p>Username/Password Incorrect</p>";
}
else{           //if query returned a result
    while ($row = $result->fetch_array()) {
        echo "<p>" . $row['userName'] . "</p>";
        echo "<p>" . $row['password'] . "</p>";
        echo "<p>" . $row['emailAddress'] . "</p>";
        echo "<p>" . $row['displayName'] . "</p>";
        echo "<p>" . $row['levelCode'] . "</p>";
    }
}



$result->close();
$db->close();


?>