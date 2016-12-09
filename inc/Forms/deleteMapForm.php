<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include("/../scripts/dbconnect.php");
        $locationID = $params['locationID'];
        $sql = "DELETE FROM location WHERE locationID = $locationID";
        if (mysqli_query($db, $sql)) {
            header("location:../mapPage");
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
    }
}
?>