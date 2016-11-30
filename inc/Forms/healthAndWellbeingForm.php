
<?php
session_start();
if (isset($_SESSION['username']))
{
    include (__DIR__ . "/../scripts/dbconnect.php");
    $itemID = $params['itemID'];
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__."/../scripts/header.php");


            //Takes all database information from the Club Table for a chosen club.
            $sql = "SELECT * FROM healthnews where itemID = '$itemID'";
            //Process the query
            $result = $db->query($sql);
            // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
            while($row = $result->fetch_array()) {
                $title = $row['title'];
                $articleText = $row['content'];
                $verified = $row['verified'];
            }
            ?>
            <main>
                <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
                <script>tinymce.init({selector: 'textarea'});</script>
                <form action="healthAndWellbeingForm.php" method="post">
                    <input type="text" name="title" value="$title" placeholder="Article Name">
                    <textarea name="content"> $content </textarea>
                    <input type="text" name="verified" value="$verified" placeholder="verified">
                    <input type="submit">
                </form>
            </main>

                <?
        include(__DIR__."/../scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $articleName = $_POST["title"];
        $articleText = $_POST["content"];
        $verified = $_POST["verified"];

        $sql = "UPDATE healthnews 
                    SET title = '" .$title."', content = '".$content."', verified = '".$verified."' 
                    WHERE itemID = $itemID";
        if (mysqli_query($db, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
        header("location:../healthAndWellbeingForm");
    }
//test
} else {
    header("location:../login");
}
?>