<?php
session_start();
if (isset($_SESSION['username'])) //SESSION DOES EXIST
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include("scripts/header.php");
        ?>
        <main>
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>tinymce.init({selector: 'textarea'});</script>
            <form action="clubAdminForm" method="post">
                <p>Club Name: </p><input type="text" name="clubName" placeholder="<?php print $_SESSION["clubName"];?>">
                <p>Club Description: </p><textarea name="clubDescription" placeholder="<?php print $_SESSION["clubDescription"];?>"></textarea>
                <p>Contact Information: </p><input type="text" name="<?php print $_SESSION["contactInformation"];?>">
                //Only if admin can change next value
                <p>Club Admin ID: </p><input type="number" name="adminID" placeholder="<?php print $_SESSION["adminID"];?>">
                <p><input type="submit" value='Submit'></p>
            </form>
        </main>
        <?
        include("scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include ('../scripts/dbconnect.php');
        $clubID = $_SESSION["clubID"];
        $clubName = $_POST["clubName"];
        $clubDescription = $_POST["clubDescription"];
        $contactInformation = $_POST['contactInformation'];
        $adminID = $_POST["adminID"];

        $sql = "INSERT INTO Club (clubID, clubName, clubDescription, contactInformation, adminID) 
        VALUES ('". $clubID ."', '" .$clubName."', '".$clubDescription."','".$contactInformation."', '".$adminID."')";
        if (mysqli_query($db, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
        header("../clubPage");
    }
//test
} else {
    header("location:login");
}
?>