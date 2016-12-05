<!-- This is the comment box where signed in users can comment -->

<?php
session_start();
include(__DIR__ . "/../scripts/dbconnect.php");
if (isset($_SESSION['userID'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        ?>

        <p>Tell us what you think!</p>
        <form action='/../commentToDatabase' method="post">
            <textarea name="comment" id="comment" placeholder="Say something!"></textarea>
            <p><input type="submit" value='Submit Comment'></p>
        </form>
        <?
    }
}else{
    //If not logged in don't show comment box
    echo"<p>Login to comment</p>";
} ?>