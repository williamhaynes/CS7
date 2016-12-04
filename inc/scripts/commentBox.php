<?php
session_start();
include(__DIR__ . "/../scripts/dbconnect.php");
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $username = $_SESSION['username'];
        ?>
        <p>Tell us what you think!</p>
        <form method="post">
            <textarea name="comment" id="comment" placeholder="Say something!"></textarea>
            <p><?$username?></p>
            <p><input type="submit" value='Submit Comment'></p>
        </form>
        <?
    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    }
}else{
    //If not logged in don't show comment box
    echo"<p>Login to comment</p>";
} ?>