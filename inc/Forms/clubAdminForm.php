<?php
session_start();
if ($_SESSION['userID']==$_SESSION['adminID'] || $_SESSION['accessLevel'] == '31'){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__."/../scripts/header.php");
        include (__DIR__ . "/../scripts/dbconnect.php");
        ?>
        <main  onload="checkboxClicked()">
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
                <p>Club Name: </p><input type="text" name="clubName" value="<?php print $_SESSION["clubName"];?>" placeholder="Club Name">
                <p>Activity: </p><input type="text" name="activity" value="<?php print $_SESSION["activity"];?>" placeholder="Activity">
                <p>Club Description: </p><textarea name="clubDescription"><?php print $_SESSION["clubDescription"];?></textarea>
                <p>Sessions Time: </p><textarea name="sessionTime"><?php print $_SESSION["sessionTime"];?></textarea>
                <p>Contact Name: </p><input type="text" name="contactName" value="<?php print $_SESSION["contactName"];?>" placeholder="Contact Name">
                <p>Contact Number: </p><input type="text" name="contactNumber" value="<?php print $_SESSION["contactNumber"];?>" placeholder="Contact Number">
                <p>Contact Email: </p><input type="text" name="contactEmail" value="<?php print $_SESSION["contactEmail"];?>" placeholder="Contact Email">
                <p>Tick if you have a website: </p><input type="checkbox" name="website" id="website" <?php if($_SESSION["website"]==1){print checked;}?>  onclick="checkboxClicked()">
                <p>WebsiteUrl: </p><input type="text" name="websiteUrl" placeholder="websiteUrl" id="websiteUrl" value="<?php if($_SESSION["website"]==1){print $_SESSION["websiteUrl"];}?>" >
                <p>Tick if you have a facebook page: </p><input type="checkbox" name="facebook" id="facebook" <?php if($_SESSION["facebook"]==1){print checked;}?> onclick="checkboxClicked()">
                <p>Facebook url: </p><input type="text" name="facebookUrl" placeholder="facebookUrl" id="facebookUrl" value="<?php if($_SESSION["facebook"]==1){print $_SESSION["facebookUrl"];}?>" >
                <p>Genre: </p>
                <select name="genreID" id="genreID">
                    <?
                    //Takes all database information from the Genre TABLE.
                    $sql_query = "SELECT * FROM Genre";

                    //Process the query
                    $result = $db->query($sql_query);

                    // Iterate through the result and present data (This needs to be tidied into a displayable format, but does grab all available data)
                    while($row = $result->fetch_array()){
                        $genreID = $row['genreID'];
                        $name = $row['name'];
                        if($_SESSION["genreID"]==$genreID) {
                            echo "<option value='{$genreID}' selected='selected'>$name</option>";
                        }else{
                            echo "<option value='{$genreID}'>$name</option>";
                        }
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
        $clubID = $_SESSION["clubID"];
        $clubName = $_POST["clubName"];
        $activity = $_POST["activity"];
        $clubDescription = $_POST["clubDescription"];
        $sessionTime = $_POST["sessionTime"];
        $contactName = $_POST['contactName'];
        $contactNumber = $_POST['contactNumber'];
        $contactEmail = $_POST['contactEmail'];
        $website = $_POST['website'];
        $websiteUrl = $_POST['websiteUrl'];
        $facebook = $_POST['facebook'];
        $facebookUrl = $_POST['facebookUrl'];
        $genreID = $_POST['genreID'];
        $adminID = $_POST["adminID"];


            $sql = "UPDATE Club 
                    SET clubName = '" .$clubName."', activity = '".$activity."', clubDescription = '".$clubDescription."', sessionTime = '".$sessionTime."', contactName = '".$contactName."', contactNumber = '".$contactNumber."', contactEmail = '".$contactEmail."', website = '".$website."', websiteUrl = '".$websiteUrl."', facebook = '".$facebook."', facebookUrl = '".$facebookUrl."', genreID = '".$genreID."', adminID = '".$adminID."' 
                    WHERE clubID = $clubID";
            if (mysqli_query($db, $sql)) {
                header("location:../$clubID");
            } else {
                echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
            }



//            UNNEEDED CHECK BECAUSE IF YOU ARE AT THIS PAGE THERE MUST ALREADY BE A CLUB SHOULD HAVE
//                function checkClubExist($clubID, $db){
//            $sql_query = "SELECT * FROM Club WHERE clubID ='" . $clubID . "';";
//            $result = $db->query($sql_query);
//            while($row = $result->fetch_array()){
//                return true;
//            }
//            return false;
//        }
//if (checkClubExist($clubID, $db)){
//        }
//        else{
//            $sql = "INSERT INTO Club (clubID, clubName, clubDescription, contactInformation, adminID)
//            VALUES ('". $clubID ."', '" .$clubName."', '".$clubDescription."','".$contactInformation."', '".$adminID."')";
//            if (mysqli_query($db, $sql)) {
//            } else {
//                echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
//            }
//            header("../$clubID");
//        }


    }
//test
} else {
    header("location:loginPage");
}
?>