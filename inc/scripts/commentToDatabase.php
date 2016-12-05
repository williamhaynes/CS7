<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include(__DIR__ . "/../scripts/dbconnect.php");
    $comment = $_POST["comment"];
    $currentUrl = $_POST["currentUrl"];
    $userID = $_SESSION["userID"];
    echo "<script> alert($currentUrl); </script>";
    $sql = "INSERT INTO comment (comment,userID) VALUES ('" . $comment . "', '" . $userID . "')";
    if (mysqli_query($db, $sql)) {
        header("location:/../$currentUrl");
    }
}else {
echo "<p>Comment unsuccessful please try again.</p>";
}
?>