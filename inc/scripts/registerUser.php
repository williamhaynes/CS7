<?php
/**
 * Created by PhpStorm.
 * User: hype_
 * Date: 21/11/2016
 * Time: 14:12
 */

include("dbconnect.php");
//Access the posted variables
$userName = $_POST['userName'];
$emailAddress = $_POST['emailAddress'];
$displayName = $_POST['displayName'];
$password = $_POST['password'];


/*
//check if user already in database*/
$sql_query = "SELECT * FROM User WHERE userName ='" . $userName . "' AND password = '" . $password ."';";

//if they're not, then add them and password to the database
/*$sql_query = ";"; //Add user to table
$result = $db->query($sql_query);
$result->close();
$db->close();*/

?>