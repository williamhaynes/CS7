
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
                //This code is creating unneccessary calls to database and creating duplicate variables - could be cleaned up.
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
        <!-- Creates form which allows Health and Wellbeing article to be manipulated/edited -->
            <main>
                <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
                <script>tinymce.init({selector: 'textarea'});</script>
                <form action='' method="post">
                    <p>Article Name: </p><input type="text" name="title" value="<?php print $_SESSION["title"];?>" placeholder="Article Name">
                    <p>Content: </p> <textarea name="content"> <?php print $_SESSION["content"];?></textarea>
                    <?php
                    //If user is a site administrator (authorised to verify articles)
                    if($_SESSION['accessLevel']==31){
                        echo "<p> Verified: </p > <input type = 'checkbox' name = 'verified' checked >";
                    }
                    ?>
                    <p><input type="submit" value='Submit'></p>
                    <?php if($_SESSION['accessLevel']==21 || $_SESSION['accessLevel']==11 || $_SESSION['accessLevel']==1){
                    echo "<p>Your article will not post until authorised by an Administrator</p>";
                    }
                    ?>
                </form>
            </main>

                <?
        include(__DIR__."/../scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include (__DIR__ . "/../scripts/dbconnect.php");
        $itemID = $_SESSION["itemID"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        $verified = 1;
        if( $_POST["verified"] == 'off') {
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