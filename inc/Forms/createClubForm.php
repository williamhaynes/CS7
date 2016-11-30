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
            <form action="createClubForm" method="post">
                <h2>Create New Club</h2>
                <p>Club Name: </p><input type="text" name="clubName" value="<?php print $_SESSION["clubName"];?>" placeholder="Club Name">
                <p>Club Description: </p><textarea name="clubDescription"> <?php print $_SESSION["clubDescription"];?> </textarea>
                <p>Contact Information: </p><input type="text" name="contactInformation" value="<?php print $_SESSION["contactInformation"];?>" placeholder="Contact Information">
                <p>Club Admin ID: </p><input type="number" name="adminID" value="<?php print $_SESSION["adminID"];?>" placeholder="Admin ID">
                <p><input type="submit" value='Submit'></p>
            </form>
        </main>
        <?
        include(__DIR__."/../scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include (__DIR__ . "/../scripts/dbconnect.php");
        $clubName = $_POST["clubName"];
        $clubDescription = $_POST["clubDescription"];
        $contactInformation = $_POST['contactInformation'];
        $adminID = $_POST["adminID"];

        $sql = "INSERT INTO Club (clubName, clubDescription, contactInformation, adminID)
        VALUES ('". $clubID ."', '" .$clubName."', '".$clubDescription."','".$contactInformation."', '".$adminID."')";
        if (mysqli_query($db, $sql)) {
            header("../clubsAndSocietiesPage");
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
    }
//test
} else {
    header("location:login");
}
?>