<!-- This is the comment box where signed in users can comment -->

<?php
session_start();
include(__DIR__ . "/../scripts/dbconnect.php");
if (isset($_SESSION['userID'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo date('l jS \of F Y h:i:s A');
        ?>

        <p>Tell us what you think!</p>
        <form action='./commentToDatabase' method="post">
            <textarea name="comment" id="comment" placeholder="Say something!"></textarea>
            <p> This is code code code code i love code code code hagiohgadsdofashidfhafhhdafsiohoifdahafdshadsfpiihadsfohpoiadfshioad</p>
            <p><input type="submit" value='Submit Comment'></p>
        </form>
        <?
    }
}else{
    //If not logged in don't show comment box
    echo"<p>Login to comment</p>";
} ?>