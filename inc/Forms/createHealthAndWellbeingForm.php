<?php
session_start();
if (isset($_SESSION['username']))
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__."/../scripts/header.php");
        ?>
        <main>
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>tinymce.init({selector: 'textarea'});</script>
            <form action="createHealthAndWellbeingForm" method="post">
                <h2>Create New News</h2>
                <input type="text" name="articleName" placeholder="Article Name">
                <textarea name="articleText"></textarea>
                <input type="submit">
            </form>
        </main>
        <?
        include(__DIR__."/../scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include (__DIR__ . "/../scripts/dbconnect.php");
        $articleName = $_POST["articleName"];
        $articleText = $_POST["articleText"];

        $sql = "INSERT INTO Health News (title, content, verified) VALUES ('" . $articleName . "', '" . $articleText . "', 'FALSE')";
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