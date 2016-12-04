<?php
session_start();
include(__DIR__ . "/../scripts/dbconnect.php");
if (isset($_SESSION['userID'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        ?>
        <p>Tell us what you think!</p>
        <form action='' method="post">
            <textarea name="comment" id="comment" placeholder="Say something!"></textarea>
            <p><input type="submit" value='Submit Comment'></p>
        </form>
        <?
    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include (__DIR__ . "/../scripts/dbconnect.php");
        $comment = $_POST["comment"];
        $userID = $_SESSION["userID"];

        $sql = "INSERT INTO comment (comment,userID) VALUES ('" . $comment . "', '" . $userID . "')";
        if (mysqli_query($db, $sql)) {
            echo"<p>Comment Successful!</p>";
        } else {
            echo "<p>Comment unsuccessful please try again.</p>";
        }
    }
}else{
    //If not logged in don't show comment box
    echo"<p>Login to comment</p>";
} ?>