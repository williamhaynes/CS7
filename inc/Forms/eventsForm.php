<!--Allows Club Admin/Site Admin to add events to the Calendar.-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events Form</title>
</head>

<body>

    <form action="" method="post">
        <input type="text" placeholder="Date" name="date">
        <input type="text" placeholder="Event Description" name="eventDescription">
        <input type="text" placeholder="Duration" name="duration">
        <input type="submit" value='Go Go Go!'>
    </form>

</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: hype_
 * Date: 07/11/2016
 * Time: 12:27
 */

//include database
include ("../scripts/dbconnect.php");

//variables

$clubCalanderID = $_GET["this.clubID"];
$date = $_POST["date"];
$eventDescription = $_POST["eventDescription"];
$duration = $_POST["duration"];

//Get session details
$clubIDSession = $_SESSION[clubID_session];

$sql = "INSERT INTO /*TABLENAME*/ (/*tablenames*/) VALUES (/*'$nameOfVariable'*/)";


if (mysqli_query($db, $sql)) {
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
}

header("location:viewusers.php");
?>