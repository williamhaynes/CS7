<?php
session_start();
if ($_SESSION['userID']==$_SESSION['adminID'] || $_SESSION['accessLevel'] == '31'){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__."/../scripts/header.php");
        include (__DIR__ . "/../scripts/dbconnect.php");
        ?>
        <main>
            <div id="divForClubAdminForm">
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
                <p><input type="submit" name="updateClub" value='Submit'></p>
            </form>
                <?php
                echo "<div id='divForUploadImage'>";
                echo "<form action='' method=\"post\" enctype=\"multipart/form-data\">";
                echo "Select an image to upload (Supported Formats):";
                echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"10000000\"/>";
                echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">";
                echo "<input type=\"submit\" value=\"Upload Image\" name=\"uploadImage\">";
                echo "</form>";
                echo "</div>";
                ?>
            </div>
        </main>
        <script>
            checkboxClicked();
        </script>
        <?
        //include (__DIR__."/../scripts/fileUploadPageClubMedia.php");
        include(__DIR__."/../scripts/footer.php");

    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['updateClub'])) {
            include(__DIR__ . "/../scripts/dbconnect.php");
            $clubID = filter_var($_SESSION["clubID"], FILTER_SANITIZE_STRING);
            $clubName = filter_var($_POST["clubName"], FILTER_SANITIZE_STRING);
            $activity = filter_var($_POST["activity"], FILTER_SANITIZE_STRING);
            $clubDescription = filter_var($_POST["clubDescription"], FILTER_SANITIZE_STRING);
            $sessionTime = filter_var($_POST["sessionTime"], FILTER_SANITIZE_STRING);
            $contactName = filter_var($_POST['contactName'], FILTER_SANITIZE_STRING);
            $contactNumber = filter_var($_POST['contactNumber'], FILTER_SANITIZE_STRING);
            $contactEmail = filter_var($_POST['contactEmail'], FILTER_SANITIZE_STRING);
            if ($_POST["website"] == 'on') {
                $website = 1;
                $websiteUrl = filter_var( $_POST["websiteUrl"], FILTER_SANITIZE_STRING);
            } else {
                $website = 0;
                $websiteUrl = NULL;
            }
            if ($_POST["facebook"] == 'on') {
                $facebook = 1;
                $facebookUrl = filter_var($_POST["facebookUrl"], FILTER_SANITIZE_STRING);
            } else {
                $facebook = 0;
                $facebookUrl = NULL;
            }
            $genreID = filter_var($_POST['genreID'], FILTER_SANITIZE_STRING);
            $adminID = filter_var($_SESSION["userID"], FILTER_SANITIZE_STRING);


            $sql = "UPDATE Club 
                    SET clubName = '" . $clubName . "', activity = '" . $activity . "', clubDescription = '" . $clubDescription . "', sessionTime = '" . $sessionTime . "', contactName = '" . $contactName . "', contactNumber = '" . $contactNumber . "', contactEmail = '" . $contactEmail . "', website = " . $website . ", websiteUrl = '" . $websiteUrl . "', facebook = " . $facebook . ", facebookUrl = '" . $facebookUrl . "', genreID = '" . $genreID . "', adminID = '" . $adminID . "' 
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


        } elseif (!empty($_POST['uploadImage'])) {
            include("../scripts/dbconnect.php");
            //Doesn't work.
            $fileName = $_FILES['fileToUpload']['name'];
            $tmpName  = $_FILES['fileToUpload']['tmp_name'];
            $fileSize = $_FILES['fileToUpload']['size'];
            $fileType = $_FILES['fileToUpload']['type'];
            $ext = "fail";
//Boolean to control whether file is allowed to upload or not
            $uploadOk = 1;

            $fp      = fopen($tmpName, 'r');
            $content = fread($fp, filesize($tmpName));
            //$content = addslashes($content);
            fclose($fp);

// Check file size - currently set to 500KB
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }


            $imageClubID = $_SESSION['clubID'];
            $filename =$_FILES['$fileToUpload'];

// Allow certain file formats
            if ($fileType != "image/jpg" && $fileType != "image/png" && $fileType != "image/jpeg"
                && $fileType != "image/gif"
            ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                echo "<p>".$fileType."</p>";
                $uploadOk = 0;
            }/* /*else{
                switch ($fileType){
                    case "image/jpg":
                        $ext = "jpg";
                        break;
                    case "image/png":
                        $ext = "png";
                        break;
                    case "image/jpeg":
                        $ext = "jpeg";
                        break;
                    case "image/gif":
                        $ext = "gif";
                        break;
                    default:
                        $ext = "unrecognized";
                }
            }*/

// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
            } else {
                //$content = stripslashes($content);
                $content = mysqli_real_escape_string($db, $content);
                //$sanitizedContent = $db->real_escape_string($content);
                //echo "<p>".$sanitizedContent."</p>";
                $sql="INSERT INTO images(image_type, image, image_clubID, name)
              VALUES('".$fileType."', ". $content .", ".$imageClubID.", '".$fileName."');";
                if (mysqli_query($db, $sql)) {
                } else {
                    echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
                }

            }
        }
    }/*
            $image = file_get_contents($_FILES['fileToUpload']);
            file_put_contents('../uploads/', $image); //save the image on your server
        }
    }*/
} else {
    header("location:loginPage");
}
?>