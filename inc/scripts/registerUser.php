<!--Page to register a user to the website, by adding users to the database -->

<?php

include("dbconnect.php");
//Access the posted variables
$userName = htmlentities($_POST['userName']);
$emailAddress = htmlentities($_POST['emailAddress']);
$displayName = htmlentities($_POST['displayName']);
$password = htmlentities($_POST['password']);

//deprecated

/*
//check if user already in database*/
$sql_query = "SELECT * FROM User WHERE userName ='" . $userName . "' AND password = '" . $password ."';";

//if they're not, then add them and password to the database
/*$sql_query = ";"; //Add user to table
$result = $db->query($sql_query);
$result->close();
$db->close();*/

?>