<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include(__DIR__ . "/../scripts/dbconnect.php");
    $comment = $_POST["comment"];
    $comment = $_POST["currentUrl"];
    $userID = $_SESSION["userID"];
    echo "<script> alert($currentUrl); </script>";
    $sql = "INSERT INTO comment (comment,userID) VALUES ('" . $comment . "', '" . $userID . "')";
    if (mysqli_query($db, $sql)) {
        echo "<p>Comment Successful!</p>";
    }
}else {
echo "<p>Comment unsuccessful please try again.</p>";
}
?>