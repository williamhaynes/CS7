<?php
session_start();
if ($_SESSION['userID']==$_SESSION["adminID"]) //CHECK USERID VS ADMINID OF CLUB
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__."/../scripts/header.php");
        ?>
        <main>
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>tinymce.init({selector: 'textarea'});</script>
            <form action="clubAdminForm" method="post">
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
        $clubID = $_SESSION["clubID"];
        $clubName = $_POST["clubName"];
        $clubDescription = $_POST["clubDescription"];
        $contactInformation = $_POST['contactInformation'];
        $adminID = $_POST["adminID"];


            $sql = "UPDATE Club 
                    SET clubName = '" .$clubName."', clubDescription = '".$clubDescription."', contactInformation = '".$contactInformation."', adminID = '".$adminID."' 
                    WHERE clubID = $clubID";
            if (mysqli_query($db, $sql)) {
            } else {
                echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
            }
            header("location:../$clubID");


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
    header("location:login");
}
?>