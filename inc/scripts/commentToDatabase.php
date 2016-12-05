<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include(__DIR__ . "/../scripts/dbconnect.php");
    $comment = $_POST["comment"];
    $currentUrl = $_POST["currentUrl"];
    $clubID = $_SESSION['clubID'];
    $userID = $_SESSION["userID"];
    echo "<script> alert($clubID); </script>";
    $sql = "INSERT INTO comment (comment,clubID,userID) VALUES ('" . $comment . "','" . $clubID . "', '" . $userID . "')";
    if (mysqli_query($db, $sql)) {
        header("location:/../$currentUrl");
    }else{
        echo "<p>ERROR</p>";
    }
}else {
echo "<p>Comment unsuccessful please try again.</p>";
}
?>