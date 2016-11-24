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

$sql_query = "SELECT * FROM User WHERE userName ='" . $userName . "';";

$result = $db->query($sql_query);

if($result == 0){
    echo "<p>Incorrect Username</p>";
}
else {
    while ($row = $result->fetch_array()) {
        if ($row['password'] == $password) {
            echo "<p>" . $row['userName'] . "</p>";
            echo "<p>" . $row['password'] . "</p>";
            echo "<p>" . $row['emailAddress'] . "</p>";
            echo "<p>" . $row['displayName'] . "</p>";
            echo "<p>" . $row['levelCode'] . "</p>";
        } else {
            echo "<p>Username/Password Incorrect</p>";
        }
    }
}


$result->close();
$db->close();


?>