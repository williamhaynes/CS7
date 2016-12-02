
<?php
session_start();
if (isset($_SESSION['username']))
{
    include (__DIR__ . "/../scripts/dbconnect.php");
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__."/../scripts/header.php");
        //Takes all database information from the healthnews for a chosen article.
        $sql = "SELECT * FROM healthnews where verified = '0'";
        //Process the query
        $result = $db->query($sql);
        // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
        while($row = $result->fetch_array()) {
            $itemID = $row['itemID'];
            $_SESSION['itemID'] = $itemID;
            $title = $row['title'];
            $_SESSION['title'] = $title;
            $content = $row['content'];
            $_SESSION['content'] = $content;
            $verified = $row['verified'];
            $_SESSION['verified'] = $verified;
            $authorName = $row['authorName'];
            $_SESSION['authorName'] = $authorName;
        }
        ?>
        <main>
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>tinymce.init({selector: 'textarea'});</script>
            <form action='' method="post">

                <p>Article Name: </p><input type="text" name="title" value="<?php print $_SESSION["title"];?>" placeholder="Article Name">
                <p>Content: </p> <textarea name="content"> <?php print $_SESSION["content"];?></textarea>
                <p>Author: </p> <input type="text" name="authorName" value="<?php print $_SESSION["authorName"];?>" placeholder="Author Name">
                <p>Verified: </p> <input type="checkbox" name="verified">
                <p><input type="submit" value='Submit'></p>
            </form>
        </main>

        <?
        include(__DIR__."/../scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include (__DIR__ . "/../scripts/dbconnect.php");
        $itemID = $_SESSION["itemID"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        if( $_POST["verified"] == 'on') {
            $verified = 1;
        }
        else{
            $verified = 0;
        }
        $authorName = $_POST["authorName"];

        $sql = "UPDATE healthnews 
                    SET title = '" .$title."', content = '".$content."', verified = ".$verified.", verified = '".$authorName."' 
                    WHERE itemID = $itemID";
        if (mysqli_query($db, $sql)) {
            header("location: /healthAndWellbeingPage");
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
    }
//test
} else {
    header("location:404");
}
?>