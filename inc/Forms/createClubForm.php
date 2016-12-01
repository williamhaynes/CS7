<?php
session_start();
if (isset($_SESSION['username']))
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__."/../scripts/header.php");
        include (__DIR__ . "/../scripts/dbconnect.php");
        ?>
        <main>
            <!-- JAVASCRIPT TO BLANK OUT INPUTS IF TICKBOXS ARENT TICKED -->
            <script>
                function checkboxClicked() {
                    if (document.getElementById('website').checked) {
                        document.getElementById('websiteUrl').disabled = false;
                    }
                    else{
                        document.getElementById('websiteUrl').disabled = true;
                    }
                    if (document.getElementById('facebook').checked) {
                        document.getElementById('facebookUrl').disabled = false;
                    }
                    else{
                        document.getElementById('facebookUrl').disabled = true;
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
                <p>Sessions Time: </p><textarea name="sessionTime"></textarea>
                <p>Contact Name: </p><input type="text" name="contactName" placeholder="Contact Name">
                <p>Contact Number: </p><input type="text" name="contactNumber" placeholder="Contact Number">
                <p>Contact Email: </p><input type="text" name="contactEmail" placeholder="Contact Email">
                <p>Tick if you have a website: </p><input type="checkbox" name="website" id="website" onclick="checkboxClicked()">
                <p>WebsiteUrl: </p><input type="text" name="websiteUrl" placeholder="websiteUrl" id="websiteUrl" disabled=true>
                <p>Tick if you have a facebook page: </p><input type="checkbox" name="facebook" id="facebook" onclick="checkboxClicked()">
                <p>Facebook url: </p><input type="text" name="facebookUrl" placeholder="facebookUrl" id="facebookUrl" disabled=true>
                <p>Genre: </p>
                <select name="genreID" id="genreID" onclick="getGenres()">
                    <?
                        //Takes all database information from the Genre TABLE.
                        $sql_query = "SELECT * FROM Genre";
    
                        //Process the query
                        $result = $db->query($sql_query);
    
                        // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
                        while($row = $result->fetch_array()){
                            $genreID = $row['genreID'];
                            $name = $row['name'];
                            echo "<option value='{$genreID}'>$name</option>";
                        }

                    ?>
                </select>
                <p><input type="submit" value='Submit'></p>
            </form>
        </main>
        <?
        include(__DIR__."/../scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include (__DIR__ . "/../scripts/dbconnect.php");
        $clubName = $_POST["clubName"];
        $activity = $_POST["activity"];
        $clubDescription = $_POST["clubDescription"];
        $sessionTime = $_POST["sessionTime"];
        $contactName = $_POST["contactName"];
        $contactNumber = $_POST["contactNumber"];
        $contactEmail = $_POST["contactEmail"];
        if( $_POST["website"] == 'on') {
            $website = 1;
            $websiteUrl = $_POST["websiteUrl"];
        }
        else{
            $website = 0;
            $websiteUrl = NULL;
        }
        if( $_POST["facebook"] == 'on') {
            $facebook = 1;
            $facebookUrl = $_POST["websiteUrl"];
        }
        else{
            $facebook = 0;
            $facebookUrl = NULL;
        }
        $genreID = $_POST["genreID"];
        $adminID = $_SESSION["userID"];


        //IF clubDescription, contactInformation or clubName is blank it will just add a blank to that column

        //If adminID is blank set it to NULL
        if ($adminID == ""){
            $adminID = NULL;
        }

        $sql = "INSERT INTO Club (clubName, activity, clubDescription, sessionTime, contactName, contactNumber, contactEmail, website, websiteUrl, facebook, facebookUrl, genreID, adminID)
        VALUES ('".$clubName."','".$activity."', '".$clubDescription."','".$session."','".$contactName."','".$contactNumber."','".$contactEmail."',".$website.",'".$websiteUrl."',".$facebook.",'".$facebookUrl."','".$genreID."',".$adminID.")";
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