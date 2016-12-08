<!-- This is the comment box where signed in users can comment -->

<?php
session_start();
include(__DIR__ . "/../scripts/dbconnect.php");
if (isset($_SESSION['userID'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $afterSlashUrl = $_SERVER['REQUEST_URI'];
        ?>
        <div id="clubPageCommentsBox">
            <p xmlns="http://www.w3.org/1999/html">Tell us what you think!</p>
            <form action='/../commentToDatabase' method="post">
                <textarea name="comment" id="comment" placeholder="Say something!"></textarea>
                <input type="hidden" id='currentUrl' name="currentUrl" value="">
                <p><input type="submit" value='Submit Comment'></p>
            </form>
            <?php


            /*
             * Pulls database information from the 'Comment Table'
             */
            $sql_query = "SELECT * FROM comment WHERE clubID = '$clubID';";

            /*
             * Processes the SQL Query
             */
            $result = $db->query($sql_query);

            /*
             * Iterate through the table and output the data
             */
            while($row = $result->fetch_array()){
                $comment = $row['comment'];
                $userID = $row['userID'];
                $sql_query2 = "SELECT displayName FROM User WHERE userID = '$userID';";
                $result2 = $db->query($sql_query2);
                while($row = $result2->fetch_array()){
                    $displayName = $row['displayName'];
                }
                echo "<li><p>$comment</p><p>Name: $displayName</p></li>";
            }
            ?>
        </div>
        <script>
            var url = "<?php Print($afterSlashUrl); ?>";
            document.getElementById('currentUrl').setAttribute('value', url);
        </script>
        <?
    }
}else{
    //If not logged in don't show comment box
    echo"<p>Login to comment</p>";
} ?>