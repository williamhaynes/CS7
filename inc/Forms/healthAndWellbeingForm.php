
<?php
//Access session cookies
session_start();
//Check to see if has correct permission control
if($_SESSION['accessLevel']==31) {
    //Access database script
    include (__DIR__ . "/../scripts/dbconnect.php");
        //If GET request from server
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //Include Header
        include(__DIR__."/../scripts/header.php");
        //Use passed in Parameter from URL - this code is sloppy
        $itemID = $params['itemID'];
        $_SESSION['itemID'] = $itemID;
            //Takes all database information from the healthnews for a chosen article.
            $sql = "SELECT * FROM healthnews where itemID = '$itemID'";
            //Process the query
            $result = $db->query($sql);
            // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
            while($row = $result->fetch_array()) {
            ?>
        <!-- Creates form which allows Health and Wellbeing article to be manipulated/edited -->
            <main>
                <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
                <script>tinymce.init({selector: 'textarea'});</script>
                <div id="divForHealthAndWellBeingForm">
                <form action='' method="post">
                    <h2 class="pageHeaderText">Edit Health & Wellbeing Article</h2>
                    <p>Article ID: <input type="text" name="itemID" value="<?php print $row['itemID'];?>" placeholder="Article ID" readonly></p>
                    <p>Article Name: <input type="text" name="title" value="<?php print $row['title'];?>" placeholder="Article Name"></p>
                    <p>Content: </p> <textarea name="content"> <?php print $row['content'];?></textarea>
                    <p>Author: <input type="text" name="authorName" value="<?php print $row['authorName'];?>" placeholder="Author Name"></p>
                    <p>Verified: <input type="checkbox" name="verified"
                            <?php
                            if($row['verified']==1){
                                echo "checked";
                            }
                            ?>
                        ></p>
                    <?php echo "<p>". $row['verified'] ."</p>"?>
                    <p><input type="submit" value='Submit'></p>
                </form>
                </div>
            </main>

                <?}
        include(__DIR__."/../scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include (__DIR__ . "/../scripts/dbconnect.php");
        $itemID = $_SESSION["itemID"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        $verified = 1;
        //Check verified status
        if( $_POST["verified"] == 'on') {
            $verified = 1;
        }
        else{
            $verified = 0;
        }
        $authorName = $_POST["authorName"];

        $sql = "UPDATE healthnews 
                    SET title = '" .$title."', content = '".$content."', authorName = '".$authorName."', verified = ".$verified."
                    WHERE itemID = $itemID";
        if (mysqli_query($db, $sql)) {
            header("location: /healthAndWellbeingPage");
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
    }
//test
} else {
    header("location:../login");
}
?>