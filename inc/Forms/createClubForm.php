<?php
session_start();
if (isset($_SESSION['username']))
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__."/../scripts/header.php");
        ?>
        <main>
            <!-- JAVASCRIPT TO BLANK OUT INPUTS IF TICKBOXS ARENT TICKED -->
            <script>
                function checkboxClicked() {
                    if (document.getElementById('website').getAttribute('checked') == false) {
                        document.getElementById('websiteUrl').setAttribute('disabled', 'true');
                    } else {
                        document.getElementById('websiteUrl').setAttribute('disabled', 'false');
                    }
                }
            </script>
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>tinymce.init({selector: 'textarea'});</script>
            <form action='' method="post">
                <h2>Create New Club</h2>
                <p>Club Name: </p><input type="text" name="clubName" placeholder="Club Name">
                <p>Activity: </p><input type="text" name="activity" placeholder="Activity">
                <p>Club Description: </p><textarea name="clubDescription"></textarea>
                <p>Sessions: </p><textarea name="session"></textarea>
                <p>Contact Name: </p><input type="text" name="contactName" placeholder="Contact Name">
                <p>Contact Number: </p><input type="text" name="contactNumber" placeholder="Contact Number">
                <p>Contact Email: </p><input type="text" name="contactEmail" placeholder="Contact Email">
                <p>Tick if you have a website: </p><input type="checkbox" name="website" id="website" onclick="checkboxClicked()">
                <p>WebsiteUrl: </p><input type="text" name="websiteUrl" placeholder="websiteUrl" id="websiteUrl">
                <p>Tick if you have a facebook page: </p><input type="checkbox" name="facebook" id="facebook" onclick="checkboxClicked()">
                <p>Facebook url: </p><input type="text" name="facebookUrl" placeholder="facebookUrl" id="facebookUrl">


                <p>Club Admin ID: </p><input type="number" name="adminID" value=<?php print $_SESSION["userID"];?> placeholder="Admin ID">
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


        //IF clubDescription, contactInformation or clubName is blank it will just add a blank to that column

        //If adminID is blank set it to NULL
        if ($adminID == ""){
            $adminID = 'NULL';
        }

        $sql = "INSERT INTO Club (clubName, clubDescription, contactInformation, adminID)
        VALUES ('".$clubName."', '".$clubDescription."','".$contactInformation."', ".$adminID.")";
        if (mysqli_query($db, $sql)) {
            header("location:../clubsAndSocietiesPage");
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
    }
//test
} else {
    header("location:login");
}
?>