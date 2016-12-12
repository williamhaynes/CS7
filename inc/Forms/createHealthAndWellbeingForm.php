<?php
session_start();
if (isset($_SESSION['username']))
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__."/../scripts/header.php");
        ?>
        <main>
            <div id="divForCreateHealthAndWellbeing">
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>tinymce.init({selector: 'textarea'});</script>
            <form action='' method="post">
                <h2 class="pageHeaderText">Create New Health & Wellbeing Article</h2>
                <p>Article Title:</p>
                <input type="text" name="articleName" placeholder="Article Name">
                <p>Article Content:</p>
                <textarea name="articleText"></textarea>
                <input type="submit">
            </form>
            </div>
        </main>
        <?
        include(__DIR__."/../scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include (__DIR__ . "/../scripts/dbconnect.php");
        $articleName = $_POST["articleName"];
        $articleText = $_POST["articleText"];
        $authorName = $_SESSION["displayName"];
        //If admin the verified value should be 1 and not 0
        if($_SESSION['accessLevel'] == '31'){
            $verified = 1;
        }else{
            $verified = 0;
        }
        $sql = "INSERT INTO healthnews (title, content, authorName, verified) VALUES ('" . $articleName . "', '" . $articleText . "', '" . $authorName . "', " . $verified . ")";
        if (mysqli_query($db, $sql)) {
            header("location:../healthAndWellbeingPage");
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
    }
//test
} else {
    header("location:login");
}
?>